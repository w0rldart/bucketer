<?php

class User extends Eloquent {

	public function buckets()
	{
		return $this->has_many('Bucket');
	}

}