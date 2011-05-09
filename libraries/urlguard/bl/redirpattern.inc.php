<?php
  define("TLRDPVERSION", "0.1.3.3");
  $redir = "(0rz\.tw|leenk\.org|dwarfurl\.com|\.1tiny\.com|\.301url\.com|"
   . "\.all\.at|andmuchmore\.com|ataja\.es|babyurl\.com|\.back\.to|"
   . "\.beam\.at|\.been\.at|biglnk\.com|\.bite\.to|\.board\.to|"
   . "\.bounce\.to|\.bowl\.to|\.break\.at|\.browse\.to|browser\.to|"
   . "\.change\.to|\.chip\.ms|compactURL\.com|\.connect\.to|"
   . "\.crash\.to|\.cut\.by|digbig\.com|\.direct\.at|\.dive\.to|"
   . "\.doiop\.com|\.drink\.to|\.drive\.to|\.drop\.to|\.easy\.to|"
   . "\.eb\.cx|\.elfurl\.com|escape\.to|\.everything\.at|\.fade\.to|"
   . "\.fanclub\.ms|\.firstpage\.de|\.flingk\.com|\.fly\.to|"
   . "\.flying\.to|fornovices\.com|\.forward\.to|\.fullspeed\.to|"
   . "fun\.to|\.fun\.ms|\.gameday\.de|gentleurl\.net|\.germany\.ms|"
   . "\.get\.to|\.getit\.at|glinki\.com|got\.to|\.hard-ware\.de|"
   . "\.hello\.to|\.hey\.to|\.hop\.to|hottestpix\.com|\.how\.to|"
   . "\.hp\.ms|imegastores\.com|jeeee\.net\.jump\.to|\.kiss\.to|"
   . "latest-info\.com|learn\.to|\.lin\.kz|link\.toolbot\.com|"
   . "linkezy\.com|linktrim\.com|ln-s\.net|\.lnk\.in|lznk\.com|"
   . "makeashorterlink\.com|\.mediasite\.de|\.megapage\.de|"
   . "\.metamark\.net|\.messages\.to|\.mine\.at|\.minilien\.com|"
   . "\.more\.at|\.more\.by|\.move\.to|moviefever\.com|mp3-archives\.com|"
   . "\.musicpage\.de|\.mypage\.org|myprivateidaho\.com|\.mysite\.de|"
   . "myurl\.com\.tw|\.nav\.to|nlug\.org\/url|\.notlong\.com|"
   . "\.notrix\.at|\.notrix\.ch|\.notrix\.de|\.notrix\.net|"
   . "now\.to|\.on\.to|\.page\.to|\.pagina\.de|\.paulding\.net|"
   . "\.played\.by|\.playsite\.de|\.privat\.ms|\.quickly\.to|\.qrl\.be|"
   . "qurl\.com|\.qurl\.net|radpages\.com|\.redirect\.to|remember\.to|"
   . "resourcez\.com|return\.to|rubyurl\.com|\.rulestheweb\.com|"
   . "\.run\.to|\.runurl\.com|sail\.to|\.scroll\.to|\.seite\.ms|"
   . "\.shorl\.com|\.shortcut\.to|\.shortlinks\.co\.uk|shurl\.net|"
   . "shurl\.org|\.simurl\.com|\.skip\.to|skocz\.pl|\.smcurl\.com|"
   . "\.snap\.to|snipurl\.com|\.soft-ware\.de|sports-reports\.com|"
   . "\.start\.at|\.stick\.by|stop\.to|\.surf\.to|s-url\.net|"
   . "\.switch\.to|\.talk\.to|thrill\.to|\.tighturl\.com|tiny\.cc|"
   . "tinyclick\.com|tinylink\.com|\.tinyr\.us|tinyurl\.co\.uk|"
   . "tinyurl\.com|tiny\.vj\.e\.pl|\.tip\.nu|\.tny\.se|\.top\.ms|"
   . "tophonors\.com|\.transfer\.to|\.travel\.to|turl\.jp|\.turn\.to|"
   . "uncutuncensored.com|\.url123\.com|url\.fibiger\.org|\.url\.fm|"
   . "urlcut\.com|urlcut\.net|urlfreeze\.com|urlic\.com|urlin\.it|"
   . "urlmask\.com|\.urlx\.org|urlser\.com|vacations\.to|veryweird\.com|"
   . "videopage\.de|virtualpage\.de|\.w3\.to|\.w3t\.org|\.walk\.to|"
   . "\.warp9\.to|web-freebies\.com|webalias\.com|webdare\.com|"
   . "\.window\.to|xrl\.us|xxx-posed\.com|\.yatuc\.com|\.yep\.it|"
   . "\.yours\.at|\.zap\.to|\.zip\.to|zuso\.tw|hugeurl\.com|elfurl\.com|"
   . "doiop\.com|301url\.com|kuso\.cc|urlx\.org|urlsnip\.com|sx\.am|"
   . "trimurl\.com|urlbee\.com|urllogs\.com|tiniuri\.com|xn6\.net|"
   . "9ax\.ne|shorturl\.com|not2long\.net|iceglow\.com|irotator\.com|"
   . "igoto\.co\.uk|dl\.am|zwap\.to|explode\.to|unonic\.com|net\.tf|"
   . "us\.tf|int\.tf|ca\.tf|ch\.tf|edu\.tf|ru\.tf|pl\.tf|cz\.tf|bg\.tf|"
   . "sg\.tf|kickme\.to|lovez\.it|needz\.it|craves\.it|means\.it|"
   . "digs\.it|adores\.it|chills\.it|is-groovin\.it|is-chillin\.it|"
   . "drives\.it|reads\.it|surfs\.it|swims\.it|playz\.it|singz\.it|"
   . "dances\.it|has\.it|does\.it|shows\.it|rules\.it|rocks\.it|"
   . "makes\.it|says\.it|owns\.it|zor\.org|1024bit\.at|128bit\.at|"
   . "16bit\.at|256bit\.at|32bit\.at|512bit\.at|64bit\.at|8bit\.at|"
   . "again\.at|allday\.at|alone\.at|altair\.at|american\.at|"
   . "amiga500\.at|ammo\.at|amplifier\.at|amstrad\.at|anglican\.at|"
   . "angry\.at|around\.at|arrange\.at|australian\.at|baptist\.at|"
   . "basque\.at|battle\.at|bazooka\.at|berber\.at|blackhole\.at|"
   . "booze\.at|bosnian\.at|brainiac\.at|brazilian\.at|bummer\.at|"
   . "burn\.at|c-64\.at|catholic\.at|catalonian\.at|chapel\.at|"
   . "christiandemocrats\.at|cname\.at|colors\.at|commodore\.at|"
   . "commodore64\.at|communists\.at|conservatives\.at|conspiracy\.at|"
   . "cooldude\.at|croatian\.at|cuteboy\.at|dancemix\.at|danceparty\.at|"
   . "danish\.at|dealing\.at|deep\.at|democrats\.at|divxlinks\.at|"
   . "divxmovies\.at|divxstuff\.at|dizzy\.at|dork\.at|dutch\.at|"
   . "dvdlinks\.at|dvdmovies\.at|dvdstuff\.at|emulaaaaars\.at|end\.at|"
   . "english\.at|eniac\.at|error403\.at|error404\.at|evangelism\.at|"
   . "exhibitionist\.at|faith\.at|fight\.at|finish\.at|finnish\.at|"
   . "forward\.at|freebie\.at|freemp3\.at|french\.at|graduatejobs\.at|"
   . "greenparty\.at|grunge\.at|hacked\.at|hang\.at|hangup\.at|hide\.at|"
   . "hindu\.at|htmlpage\.at|hungarian\.at|icelandic\.at|independents\.at|"
   . "invisible\.at|japanese\.at|jive\.at|kickass\.at|kindergarden\.at|"
   . "kurd\.at|labour\.at|leech\.at|liberals\.at|linuxserver\.at|"
   . "liqour\.at|maxed\.at|meltdown\.at|methodist\.at|microcomputers\.at|"
   . "mingle\.at|mirror\.at|moan\.at|mormons\.at|musicmix\.at|"
   . "nationalists\.at|nerds\.at|neuromancer\.at|newbie\.at|nicepage\.at|"
   . "ninja\.at|norwegian\.at|ntserver\.at|paint\.at|palestinian\.at|"
   . "phoneme\.at|phreaking\.at|polish\.at|popmusic\.at|portuguese\.at|"
   . "powermac\.at|processor\.at|prospects\.at|protestant\.at|rapmusic\.at|"
   . "raveparty\.at|reachme\.at|reboot\.at|relaxed\.at|republicans\.at|"
   . "researcher\.at|reset\.at|resolve\.at|retrocomputers\.at|rockparty\.at|"
   . "rollover\.at|rough\.at|rumble\.at|russian\.at|scared\.at|seikh\.at|"
   . "serbian\.at|short\.as|silence\.at|simpler\.at|sinclair\.at|"
   . "slowdown\.at|socialists\.at|spanish\.at|split\.at|stand\.at|"
   . "saaaaned\.at|stumble\.at|supercomputer\.at|swedish\.at|synagogue\.at|"
   . "syntax\.at|syntaxerror\.at|techie\.at|temple\.at|thinkbig\.at|"
   . "thirsty\.at|throw\.at|aaaaplist\.at|trekkie\.at|trouble\.at|"
   . "turkish\.at|unexplained\.at|unixserver\.at|vegetarian\.at|venture\.at|"
   . "verycool\.at|vic-20\.at|viewing\.at|vintagecomputers\.at|"
   . "virii\.at|vodka\.at|wannabe\.at|webpagedesign\.at|wheels\.at|"
   . "whisper\.at|whiz\.at|wonderful\.at|zx80\.at|zx81\.at|zxspectrum\.at|"
   . "15h\.com|1dr\.biz|2url\.org|7ref|8rf\.com|active\.ws|bydl\.com|"
   . "bittyurl\.com|bizz\.cc\|briefurl\.com|c-o\.in|chopurl\.com|"
   . "ko168\.com|cool158\.com|cool168\.com|ontheinter\.net|cutalink\.com|"
   . "dephine\.org|fx\.to|drlinky\.com|fireme\.to|ontheway\.to|"
   . "nextdoor\.to|fancyurl\.com|get2\.us|spotted\.us|went2\.us|"
   . "hasballs\.com|globalredirect\.com|go\.cc|gonow\.to|gowwwgo\.com|"
   . "hotshorturl\.com|here\.is|hothere\.com|coolhere\.com|homepagehere\.com|"
   . "mustbehere\.com|onlyhere\.net|pagehere\.com|surfhere\.net|"
   . "zonehere\.com|iscool\.net|l8t\.com|5ux\.xom|9irl\.com|9uy\.com|"
   . "just\.as|linkfrog\.net|lispurl\.com|linkzip\.net|midgeturl\.com|"
   . "r8\.org|nanoref\.com|ozonez\.com|ppcredirect\.com|pulsar\.net|"
   . "quickurl\.net|qwer\.org|red\.tc|sky\.tc|tnx\.be|lol\.la|the\.vg|"
   . "redirectfree\.com|surl\.ws|sg5\.co\.uk|freegaming\.org|"
   . "freebiefinders\.net|op7\.net|2cd\.net|0kn\.com|v9z\.com|"
   . "shortenurl\.com|simurl\.com|passingg\.as|redirect\.hm|rr\.nu|"
   . "kwik\.to|fw\.nu|ontheweb\.nu|isthebe\.st|byinter\.net|findhere\.org|"
   . "onthenet\.as|ugly\.as|assexy\.as|pass\.as|athissite\.com|"
   . "athersite\.com|isgre\.at|lookin\.at|beastdeals\.at|lowestprices\.at|"
   . "spydar\.com|tz4\.com|cemper\.com|urlproxy\.com|i\.am|listen\.to|"
   . "xaddr\.com|urlot\.com|nbjmp\.com|alink2\.uic\.to|shmyl\.com|"
   . "get-shorty\.com|linkfreeze\.net)";
?>