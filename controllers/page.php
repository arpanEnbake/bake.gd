<?php 
class Page extends Controller {
	function Page()
	{
		parent::Controller();
	}

	function index()
	{
		$this->show();
	}

	function show($url = FALSE, $data = array())
	{
		// If no URL was set, redirect to the home page
		if(!$url) {
			redirect();
		}

		// If the requested file don't exist, we display a 404
		if(!file_exists(APPPATH.'views/pages/'.$url.EXT)) {
			show_404();
		}

		// Send output to the browser
		$this->load->view('pages/'.$url, $data);
	}
}