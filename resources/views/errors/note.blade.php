
@if ( Session::has('error') )
<div class="alert round bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
	<span class="alert-icon"><i class="fa fa-warning"></i></span>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<strong>{{ Session::get('error') }}</strong>
</div>                        
@endif


@if ( Session::has('success') )
<div class="alert round bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
	<span class="alert-icon"><i class="fa fa-warning"></i></span>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<strong>{{ Session::get('success') }}</strong>
</div>   
@endif


@if($errors->any())
<div class="alert round bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
	<span class="alert-icon"><i class="fa fa-warning"></i></span>
	<ul>
		@foreach ($errors->all() as $error)
		<li> <strong>{{ $error }} </strong></li>
		@endforeach
	</ul>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<strong>{{ Session::get('success') }}</strong>
</div> 
@endif