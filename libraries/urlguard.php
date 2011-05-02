<?php
class UrlGuard {
	// URIBL variables
	private $uribl = array("multi.surbl.org", "black.uribl.com");
	private $uriblurl = array("www.surbl.org", "www.uribl.com");

	function __construct()
	{
		// Iterate and include all the files found.
		foreach (glob(APPPATH."libraries/urlguard/bl/*.php") as $filename) {
    		include($filename);
		}
	}
	
	/**
	 * Counts the number of times a substring is contained in a given string.
	 */
	function countSubstrs($haystack, $needle) {
	  return (($p = strpos($haystack, $needle)) === false) ? 0 : (1 + $this->countSubstrs(substr($haystack, $p+1), $needle));
	}

	// Check if the passed in url is in any of our spam lists.
	function isSpamUrl($url)
	{
		// TODO: Need to refractor this function not to call ghbn everytime
		// we look up the same domain. Cache in redis/mongo.
		$validurlpattern  = "\:\/\/([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@)"
		   . "*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])"
		   . "\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)"
		   . "\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)"
		   . "\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])"
		   . "|((([0-9A-F]{1,4}(((:[0-9A-F]{1,4}){5}::[0-9A-F]{1,4})|((:[0-9A-F]{1,4}){4}"
		   . "::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,1})|((:[0-9A-F]{1,4}){3}::[0-9A-F]{1,4}"
		   . "(:[0-9A-F]{1,4}){0,2})|((:[0-9A-F]{1,4}){2}::[0-9A-F]{1,4}(:[0-9A-F]{1,4})"
		   . "{0,3})|(:[0-9A-F]{1,4}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,4})|(::[0-9A-F]{1,4}"
		   . "(:[0-9A-F]{1,4}){0,5})|(:[0-9A-F]{1,4}){7}))|(::[0-9A-F]{1,4}(:[0-9A-F]{1,4}"
		   . "){0,6}))|::)|((([0-9A-F]{1,4}(((:[0-9A-F]{1,4}){3}::([0-9A-F]{1,4}){1})"
		   . "|((:[0-9A-F]{1,4}){2}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,1})|((:[0-9A-F]{1,4})"
		   . "{1}::[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,2})|(::[0-9A-F]{1,4}(:[0-9A-F]{1,4}"
		   . "){0,3})|((:[0-9A-F]{1,4}){0,5})))|([:]{2}[0-9A-F]{1,4}(:[0-9A-F]{1,4}){0,4}))"
		   . ":|::)((25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{0,2})\.){3}(25[0-5]|2[0-4][0-9]|"
		   . "[0-1]?[0-9]{0,2})"
		   . "|localhost|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org"
		   . "|mobi|biz|arpa|info|name|pro|aero|coop|museum"
		   . "|[a-zA-Z]{2}))(\:[0-9]+)*(\/.($|[a-zA-Z0-9\.\:\,\?\'\(\)\\\*\+&%\$;|#\=~_\-\s@]*))*\/*";

		$validipv4pattern  = ":\/\/(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\."
		   . "(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])"
		   . "\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/*";		
		$forbid = "\.(cmd|bat|exe|scr|pif|vbs|js|pif|msi|cdr)";
		$validschemes = "(http|https|ftp|sftp)";
	   
		if ($url) {
		    // Test for IPv4 address, reverse the quads if found
		    if (preg_match("/^".$validschemes.$validipv4pattern."/", $url, $matches)) {
		    	$domain=$matches[5] . "." . $matches[4] . "." . $matches[3] . "." . $matches[2];
		    }
		    else {
		      // The lookup guidelines brought to you by ..
		      // http://www.surbl.org/guidelines
		    	// strip out second-level domain name, *unless* on exception list,
		      // in which case, strip out third level also and test that instead.
		      // FIX: when testing uribl.com lists, also test additional level.  First hit wins.
		      preg_match("/^".$validschemes.$validurlpattern."$/", $url, $matches);
		      $domain = $matches[4];

		      global $tltlds;

		      if (preg_match("/".$tltlds."$/", $domain, $matches)) {$levels = 2;} else {$levels = 1;}
		
		      // klugey stripping routine to reduce domain to base domain name
		      // expect regex wojuld be better
		      $ss = $this->countSubstrs($domain, ".");

		      while ($ss > $levels) {
		        $chop = strpos($domain, ".");
		        $domain = substr($domain, $chop + 1);
		        $ss = $this->countSubstrs($domain, ".");
		      }
		    }
		
		    // Query URI blacklists to see if domain/IP appears as target in known spam
		    // or something involved in a malware/phishing attack.
		    $uribls = '';

		    for ($i=0; $i<count($this->uribl); $i++) {
		      $fqdn = $domain . "." . $this->uribl[$i];
		      $recexists = gethostbyname($fqdn); // ghbn weirdly returns the name on failure
		      if (($recexists != $fqdn) && preg_match("/^127\./", preg_quote($recexists))) {
		        if ($i > 0) $uribls .= ", ";                
		        $uribls .= $this->uribl[$i];      
		      }
		    }
		    return ($uribls);
		  }		
	}
}