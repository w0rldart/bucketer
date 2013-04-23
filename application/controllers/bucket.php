<?php

class Bucket_Controller extends Base_Controller {

	public $restful = true;

	public function __construct()
	{
		$this->layout = "layouts.default";
		parent::__construct();

		$this->facebook = IoC::resolve('facebook-sdk');
		$this->user = $this->facebook->getUser();
	}

	public function get_index($data = array())
	{
		if($bucket_raw = Bucket::where_id($data['id'])->first(array('id', 'user_id', 'name', 'friends')))
		{
			$bucket = $bucket_raw->attributes;
			$bucket['friends'] = unserialize($bucket['friends']);

			return Response::json($bucket);
		}
		else
		{
			return Response::fail();
		}
	}

	public function get_list($data = array())
	{
		$buckets_raw = Bucket::where('user_id', '=', $data['id'])->get();
		if($buckets_raw)
		{
			$buckets = array();
			foreach ($buckets_raw as $bucket)
			{
				$buckets[] = $bucket->attributes;
			}
		}
		else
		{
			$buckets = null;
		}

		return Response::json($buckets);
	}

	public function post_index($data = array())
	{
		$new_bucket = Bucket::create(array(
			'user_id' => $data['input']['id'],
			'name' => $data['input']['name'],
			'friends' => null,
		));

		if($new_bucket)
		{
			$result = $this->get_list($data);
		}
		else
		{
			$result = false;
		}

		return Response::json($result);
	}

	public function put_index($data = array())
	{
		if( ($bucket = Bucket::find($data['input']['bucket'])->first()) && ( ! is_null($bucket->attributes['friends'])) )
		{
			$friends = unserialize($bucket->attributes['friends']);
			$friends[] = array(
				'fb_id' => $data['input']['friend_id'],
				'name' => $data['input']['friend_name'],
			);
		}
		else
		{
			$friends = array(
				array(
					'fb_id' => $data['input']['friend_id'],
					'name' => $data['input']['friend_name'],
				),
			);
		}

		$bucket->friends = serialize($friends);

		if($bucket->save())
		{
			return Response::ok();
		}
		else
		{
			return Response::fail();
		}

	}

}