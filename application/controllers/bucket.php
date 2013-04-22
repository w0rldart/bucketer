<?php

class Bucket_Controller extends Base_Controller {

	public $restful = true;

	public function __construct()
	{
		$this->layout = "layouts.default";
		parent::__construct();
	}

	public function get_index()
	{
		return Redirect::to('/user', 301);
	}

	public function post_index()
	{
		$input = Input::all();

		$new_bucket = new Bucket;

		$new_bucket->user_id = $input['fb_id'];
	}

}