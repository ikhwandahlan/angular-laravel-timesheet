<div class="panel panel-default">
	<div class="panel-primary panel-heading clearfix">
		<a href="#!" class="btn btn-info">{{Auth::user()->name}}</a>
		@if(Auth::user()->checkAdmin())
		<a href="admin" class="btn btn-default">Administrace</a>
		@endif

		<div class="btn-group float-right">
			<a href="{{URL::to('logout')}}" class="btn btn-danger" title="Odhlásit"><span class="glyphicon glyphicon-log-out"></span></a>
			<a href="{{URL::to('logout')}}" class="btn btn-danger" title="Odhlásit">Odhlásit</a>
		</div>

	</div>
</div>