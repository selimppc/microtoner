<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Input extends CI_Input {
	
	
	function get($index = NULL, $xss_clean = TRUE) {
		return parent::get($index, $xss_clean);
	}
	
	function post($index = NULL, $xss_clean = TRUE) {
		return parent::post($index, $xss_clean);
	}
	
	function cookie($index = '', $xss_clean = TRUE) {
		return parent::cookie($index, $xss_clean);
	}
	
	function server($index = '', $xss_clean = TRUE) {
		return parent::server($index, $xss_clean);
	}
	 
}

?>