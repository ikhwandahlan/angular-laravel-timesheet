<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="/timesheet/{{ $scope == 'user' ? '' : 'admin/'}}">

<link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
<link rel="icon" href="{{asset('favicon.ico')}}" sizes="32x32">

<script type="text/javascript">
	WebFontConfig = {
		google: { families: [ 'Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic,700italic:latin,latin-ext' ] }
	};
	(function () {
		var wf = document.createElement ('script');
		wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
				'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		wf.type = 'text/javascript';
		wf.async = 'true';
		var s = document.getElementsByTagName ('script')[0];
		s.parentNode.insertBefore (wf, s);
	}) (); </script>

{{ HTML::style('assets/css/style.css') }}
{{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css') }}

{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.min.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular-route.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular-resource.js') }}

{{ HTML::script('assets/js/moment.min.js') }}
{{ HTML::script('assets/js/moment-timezone.min.js') }}
{{ HTML::script('assets/js/moment-timezone-data.js') }}

{{ HTML::script('angular/xeditable.min.js') }}
{{ HTML::script('angular/bootstrep.js') }}

{{ HTML::script('angular/bootstrap-modal.js') }}

@if(Request::segment(1) != 'login')
{{ $scope == 'user' ? HTML::script('angular/userRoutes.js') : HTML::script('angular/adminRoutes.js') }}
@endif

{{ HTML::script('angular/services.js') }}
{{ HTML::script('angular/directives.js') }}
{{ HTML::script('angular/controllers.js') }}

{{ HTML::script('//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js') }}

{{ HTML::script('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}
{{ HTML::script('//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}
<![endif]-->
<title>{{Config::get('timesheet.name')}}</title>