<div class="panel panel-default">
	<div class="panel-primary panel-heading clearfix">
		<a href="../" class="btn btn-default">{{Auth::user()->name}}</a>
		<a href="#!" class="btn btn-info">Administrace</a>
		<span ng-show="username">
		  	<span class="glyphicon glyphicon-chevron-right btn"></span>
			<span class="btn btn-default">
				@{{username}}
			</span>
		</span>

		<div class="btn-group float-right">
			<a href="{{URL::to('logout')}}" class="btn btn-danger" title="Odhlásit"><span class="glyphicon glyphicon-log-out"></span></a>
			<a href="{{URL::to('logout')}}" class="btn btn-danger" title="Odhlásit">Odhlásit</a>
		</div>
	</div>
</div>