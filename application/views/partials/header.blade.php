<!--<div class="navbar navbar-inverse navbar-static-top">
	<div class="navbar-inner">
	    <div class="nav-collapse collapse">
	        <ul class="nav btn-block">
	        	<li class="">
	        		<a class="text-center">Facebook Buckets</a>
	        	</li>
	        </ul>
	    </div>
	</div>
</div>-->

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