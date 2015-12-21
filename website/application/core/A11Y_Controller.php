<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class A11Y_Controller extends CI_Controller {

    //Page info
    protected $data = array();
    protected $viws_dir = 'frontend';
    protected $template = 'main-full';
    protected $skeleton = 'skeleton';
    protected $header_view = 'header';
    protected $footer_view = 'footer';
    //Page contents
    protected $javascript_inline = array();
    protected $javascript = array();
    protected $css = array();
    protected $fonts = array();
    //Page information
    protected $title = '';
    protected $subtitle = '';
    //Page Meta
    protected $description = '';
    protected $keywords = FALSE;
    protected $controller_name = FALSE;
    protected $action_name = FALSE;

    function __construct() {

	parent::__construct();
	//set the current controller and action name
	$this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
	$this->action_name = $this->router->fetch_method();

	$this->title = $this->controller_name . '-' . $this->action_name;

	$this->load->helper(array('cms'));
    }

    protected function _render($view = '', $renderData = 'FULLPAGE') {

	switch ($renderData) {
	    case 'AJAX' :
		$this->load->view($view, $this->data);
		break;
	    case 'JSON' :
		header('Content-Type: application/json');
		echo json_encode($this->data);
		break;
	    case 'SIMPLEPAGE' :
		$this->template = 'main-simple';

		$path = $this->router->fetch_directory() ? $this->router->fetch_directory() : '';

		if (empty($view)) {
		    $view_path = $path . 'pages/' . ltrim($this->controller_name, $this->router->fetch_directory()) . '_' . $this->action_name . '.php'; //set the path off the view

		    if (is_file(APPPATH . 'views/' . $view_path)) {
			$view = $view_path;
		    }
		}

		$toBody["content_body"] = $this->load->view($view, $this->data, true);
		
		//static
		$toTpl["javascript_inline"] = $this->javascript_inline;
		$toTpl["javascript"] = $this->javascript;
		$toTpl["css"] = $this->css;
		$toTpl["fonts"] = $this->fonts;

		//meta
		$toTpl["title"] = config_item('site_name');
		$toTpl["description"] = $this->description;
		$toTpl["keywords"] = $this->keywords;
		$toTpl["author"] = config_item('author');

		$toBody["header"] = '';
		$toBody["footer"] = $this->load->view("template/" . $this->footer_view, '', true);

		$toTpl["body"] = $this->load->view("template/" . $this->template, $toBody, true);

		//render view
		$this->load->view("template/" . $this->skeleton, $toTpl);
		break;
	    case 'DASHBOARD' :
		$this->template = 'main-dashboard';
		
		$path = $this->router->fetch_directory() ? $this->router->fetch_directory() : '';

		if (empty($view)) {
		    $view_path = $path . 'pages/' . ltrim($this->controller_name, $this->router->fetch_directory()) . '_' . $this->action_name . '.php'; //set the path off the view

		    if (is_file(APPPATH . 'views/' . $view_path)) {
			$view = $view_path;
		    }
		}

		$this->data['subtitle'] = $this->subtitle;
		$toBody["content_body"] = $this->load->view($view, $this->data, true);
		
		//static
		$toTpl["javascript_inline"] = $this->javascript_inline;
		$toTpl["javascript"] = $this->javascript;
		$toTpl["css"] = $this->css;
		$toTpl["fonts"] = $this->fonts;

		//meta
		$toTpl["title"] = config_item('site_name');
		$toTpl["description"] = $this->description;
		$toTpl["keywords"] = $this->keywords;
		$toTpl["author"] = config_item('author');

		$toBody["header"] = $this->load->view("template/" . $this->header_view, $toTpl, true);
		$toBody["footer"] = $this->load->view("template/" . $this->footer_view, '', true);
		$toBody["title"] = $this->title;
		$toBody["subtitle"] = $this->subtitle;

		$toTpl["body"] = $this->load->view("template/" . $this->template, $toBody, true);

		//render view
		$this->load->view("template/" . $this->skeleton, $toTpl);
		break;
	    case 'FULLPAGE' :
	    default :
		
		$path = $this->router->fetch_directory() ? $this->router->fetch_directory() : '';

		if (empty($view)) {
		    $view_path = $path . 'pages/' . ltrim($this->controller_name, $this->router->fetch_directory()) . '_' . $this->action_name . '.php'; //set the path off the view

		    if (is_file(APPPATH . 'views/' . $view_path)) {
			$view = $view_path;
		    }
		}

		$toBody["content_body"] = $this->load->view($view, $this->data, true);
		
		//static
		$toTpl["javascript_inline"] = $this->javascript_inline;
		$toTpl["javascript"] = $this->javascript;
		$toTpl["css"] = $this->css;
		$toTpl["fonts"] = $this->fonts;

		//meta
		$toTpl["title"] = config_item('site_name');
		$toTpl["description"] = $this->description;
		$toTpl["keywords"] = $this->keywords;
		$toTpl["author"] = config_item('author');

		$toBody["header"] = $this->load->view("template/" . $this->header_view, $toTpl, true);
		$toBody["footer"] = $this->load->view("template/" . $this->footer_view, '', true);
		$toBody["title"] = $this->title;
		$toBody["subtitle"] = $this->subtitle;

		$toTpl["body"] = $this->load->view("template/" . $this->template, $toBody, true);

		//render view
		$this->load->view("template/" . $this->skeleton, $toTpl);
		break;
	}
    }
    
    public function set_javascript($scr, $name = ''){
	if(empty($name)){
	    $this->javascript[] = $scr;
	}else{
	    $this->javascript[$name] = $scr;
	}
    }
    public function set_javascript_inline($code, $name = ''){
	if(empty($name)){
	    $this->javascript_inline[] = $code;
	}else{
	    $this->javascript_inline[$name] = $code;
	}
    }
    
    public function set_css($scr, $name = ''){
	if(empty($name)){
	    $this->css[] = $scr;
	}else{
	    $this->css[$name] = $scr;
	}
    }

}
