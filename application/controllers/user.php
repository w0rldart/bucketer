<?php

class User_Controller extends Base_Controller {

	public $restful = true;

	public function __construct()
	{
		$this->layout = 'layouts.default';
		parent::__construct();

		Asset::add('jquery-ui-css', 'css/flick/jquery-ui-1.10.2.custom.min.css');
		Asset::add('jquery-ui-js', 'js/vendor/jquery-ui-1.10.2.custom.min.js');
		Asset::add('user', 'js/modules/user.js');

		$this->facebook = IoC::resolve('facebook-sdk');
		$this->user = $this->facebook->getUser();
	}

	public function get_index()
	{
		if ( ! $this->user)
		{
			return Redirect::to($this->facebook->getLoginUrl());
		}
		else
		{
			try {

				$user_profile = $this->facebook->api('/me');
				$user_friends = $this->facebook->api('/me/friends');

				/*$user_data = array(
					'fb_id' => $user_profile['id'],
					'first_name' => $user_profile['first_name'],
					'last_name' => $user_profile['last_name'],
					'username' => $user_profile['username'],
					'location' => $user_profile['location'],
					'friends' => $user_friends['data'],
				);*/

				$new_user = new User;

				$new_user->fb_id = $user_profile['id'];
				$new_user->first_name = $user_profile['first_name'];
				$new_user->last_name = $user_profile['last_name'];
				$new_user->username = $user_profile['username'];
				$new_user->location = $user_profile['location'];
				$new_user->friends = serialize($user_friends['data']);

				//$new_user->save();

			} catch (FacebookApiException $e) {
			    error_log($e);
			}

			$view = View::make('modules.user.index', array(
				'fb_id' => $user_profile['id'],
				'first_name' => $user_profile['first_name'],
				'last_name' => $user_profile['last_name'],
				'username' => $user_profile['username'],
				'location' => $user_profile['location'],
				'friends' => $user_friends['data'],
			));
			$this->layout->content = $view;
		}
	}

	public function get_logout()
	{
		if($this->user)
		{
			return Redirect::to($this->facebook->getLogoutUrl());
		}

	}
}