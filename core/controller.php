<?php
class controller {

	public function __construct() {

	}

	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()) {
		//extract($viewData);
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadLibrary($lib){
	    if(file_exists('libraries/'.$lib.'.php')){
	        include 'libraries/'.$lib.'.php';
        }
    }
}