<!DOCTYPE html>
<html lang="en">
	@include('layouts.head')
	<body>
		<div class="wrapper ">
			@include('layouts.sidebar')
			<div class="main-panel">
				@include('layouts.navbar')
				<div class="content">
					<div class="container-fluid">
						<div class="row">
							@yield('content')
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('layouts.foot')
		@stack('js')
	</body>
</html>