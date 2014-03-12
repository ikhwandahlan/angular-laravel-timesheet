<!doctype html>
<html lang="{{Config::get('app.locale')}}" id="ng-app" ng-app="app">
<head>
	@include('partials.meta')
</head>
<body class="{{$class or ''}}">
<section id="main-section" ng-controller="AttendanceCtrl">
	@include('partials.header')
	<section id="main_content">
		{{$content}}
	</section>

	@if(Request::segment(1) != 'login')
	<alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">@{{alert.msg}}</alert>
	@endif

	<section id="angular-content" ng-view></section>
	@include('partials.footer')
</section>
</body>
</html>