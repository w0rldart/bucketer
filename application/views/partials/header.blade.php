<?php echo
	Navbar::inverse(array(), '')
		->with_brand('Bucketer', '#')
		->with_menus(
			Navigation::links(
				array(
					array('Login', '/user'),
					array('Logout', '/user/logout'),
				)
			),
			array('class' => 'pull-right'));
?>