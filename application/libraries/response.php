<?php

class Response extends \Laravel\Response {
	
	public static function ok($message = true, $status = 200)
	{
		return Response::json($message, $status);
	}

	public static function fail($message = false, $status = 400)
	{
		return Response::json($message, $status);		
	}
}