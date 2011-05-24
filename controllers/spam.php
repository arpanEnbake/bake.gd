<?php
class Spam extends Controller {
	/*
	 * Constructor
	 */	
	function Spam() {
		parent::Controller();
	}

	function index() {
		
	}

	/*
	 * update_gsb
	 * 
	 * Update the GSB database.
	 */
	function gsbupdate() {
		$this->load->library('phpgsb',
					array($this->db->database,$this->db->username,$this->db->password));

		$this->phpgsb->apikey = "ABQIAAAALiANvsxzwzU5jIbWlo57wRRYNQaEde79UlGe8KvnROwW5Q628A";
		$this->phpgsb->usinglists = array('googpub-phish-shavar','goog-malware-shavar');
		$this->phpgsb->runUpdate();
		$this->phpgsb->close();
		exit;
	}
}