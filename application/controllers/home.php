<?php

class Home_Controller extends Base_Controller {

	public $restful = true;

	public function __construct()
	{
		$this->layout = "layouts.default";
		parent::__construct();
	}

	public function get_index()
	{
		$view = View::make('modules.home.index', array());
		$this->layout->content = $view;
	}

}