<?php

class Ajax_Controller extends Base_Controller {

	public $restful = true;

	public function __construct()
	{
		parent::__construct();

		if ( ! Request::ajax())
		{
			die(Response::make('Forbidden access', 403));
		}

		$id = URI::segment(4) ? URI::segment(4) : null;

		$this->parameters = array(
			'internal' => true,
			'id' => $id ? $id : (Input::has('uid') ? Input::get('uid') : null),
			'input' => Input::all(),
		);

		$this->method = URI::segment(3);
	}

	public function get_user()
	{
		return Controller::call('user@'.$this->method,  array($this->parameters));
	}

	public function get_bucket()
	{
		return Controller::call('bucket@'.$this->method, array($this->parameters));
	}

	public function post_bucket()
	{
		return Controller::call('bucket@'.$this->method, array($this->parameters));
	}

	public function put_bucket()
	{
		return Controller::call('bucket@'.$this->method, array($this->parameters));
	}

}