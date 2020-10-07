@extends('layouts.main')
@section('title', 'Upload Excel Sheet')
@section('content')
	<div class="col-md-8">
		<div class="card">
			<div class="card-header card-header-primary">
                <h4 class="card-title">@lang('uploader.Upload Book Excel Sheet')</h4>
                <p class="card-category">@lang('uploader.Please Make Columns Arrangement as [book-name, description, author-name]')</p>
            </div>
            <div class="card-body">
            	<form action="{{route('upload')}}" method="post" enctype="multipart/form-data">
            		@csrf
				    <input type="file" class="form-control" name="file" accept='.xls, .xlsx, .csv'>
					<div class="progress mt-3" style="height: 5rem;">
					    <div class="progress-bar progress-bar-striped" style="height: 20rem;" role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
					</div>

					<div id="status"></div>
					<div class="col-12 m-0 p-0 mt-3">
						<button type='submit' class="btn btn-primary btn-block">
							@lang('uploader.Upload File')
						</button>
					</div>
					
				</form>
            </div>
		</div>
	</div>
	@if($errors->any())
		<div class="col-12">
			@foreach($errors->all() as $error)
				<div class="alert alert-danger alert-with-icon" data-notify="container">
			        <i class="material-icons" data-notify="icon">add_alert</i>
			        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			          <i class="material-icons">close</i>
			        </button>
			        <span data-notify="message">{{$error}}</span>
			    </div>
			@endforeach
		</div>
	@endif
@endsection
