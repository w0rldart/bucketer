<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		
		{{ Asset::container('bootstrapper')->styles() }}
		{{ HTML::style('css/theme.css', array('media'=>'screen,projection')) }}
		{{ HTML::style('css/animate.css', array('media'=>'screen,projection')) }}

		{{ Asset::styles() }}

		{{ HTML::script('js/vendor/modernizr-2.6.2.min.js') }}

		<!--[if (gte IE 6)&(lte IE 8)]>
			{{ HTML::script('js/vendor/selectivizr-min.js') }}
		<![endif]--> 

	</head>

	<body>

		@include('partials.header')

		<div id="master" class="container" style="margin-top: 20px;">
			{{ $content }}
		</div>
		
		@include('partials.footer')

		{{ Asset::container('bootstrapper')->scripts(); }}
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js') }}
		{{ HTML::script('js/main.js') }}
		{{ Asset::scripts() }}

	</body>

</html>
