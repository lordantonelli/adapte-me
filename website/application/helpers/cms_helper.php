<?php

function force_ssl() {
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
	$url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	redirect($url);
	exit;
    }
}

function encode_url($str) {
    $CI = & get_instance();
    $CI->load->library('encryption');
    $ret = urlencode(urlencode($CI->encryption->encrypt($str)));
    $ret = $CI->encryption->encrypt($str);
    return strtr(
	    $ret, array(
	'+' => '.',
	'=' => '-',
	'/' => '~'
	    )
    );
}

function decode_url($str) {
    $CI = & get_instance();
    $CI->load->library('encryption');
    
    $str = strtr(
	    $str, array(
	'.' => '+',
	'-' => '=',
	'~' => '/'
	    )
    );
    
    //$ret = urldecode(urldecode($str));
    return $CI->encryption->decrypt($str);
}

function script_tag($href) {
    $CI = & get_instance();
    if (strpos($href, '//') !== FALSE) {
	$link = 'src="' . $href . '" ';
    } else {
	$link = 'src="' . $CI->config->slash_item('base_url') . $href . '" ';
    }

    return '<script type="text/javascript" ' . $link . '></script>' . "\n";
}
