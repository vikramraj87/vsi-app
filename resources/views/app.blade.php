<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') - VSI</title>

    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/app.css') }}"       rel="stylesheet">
</head>
<body ng-app="app">
	<nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Kiv!</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/categories') }}">Categories</a></li>
                <li><a href="{{ url('/cases') }}">Cases</a></li>
            </ul>
        </div>
    </nav>
	<!-- End of navigation -->

    <div class="container">
        @yield('content')
    </div>


	<!-- Scripts -->
	<script src="{{ asset('/js/vendor.js') }}"></script>
	<script src="{{ asset('/js/src/app.js') }}"></script>
	@yield('scripts')
</body>
</html>
