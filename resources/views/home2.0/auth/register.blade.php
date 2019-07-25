
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>注册</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FreeHTML5.co" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/animate.css') }}">
	<link rel="stylesheet" href="{{ url('css/style.css') }}">

	<!-- Modernizr JS -->
	<script src="{{ url('js/modernizr-2.6.2.min.js') }}"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="{{ url('js/respond.min.js') }}"></script>
	<![endif]-->

	</head>
	<body class="style-3">

		<div class="container">

			<div class="row">
				<div class="col-md-4 col-md-push-8">
					

					<!-- Start Sign In Form -->
					<form action="{{ route('register') }}" method="POST" class="fh5co-form animate-box" data-animate-effect="fadeInRight">
						{{ csrf_field() }}
						<h2>注册账号</h2>
						<!--<div class="form-group">
							<div class="alert alert-success" role="alert">Your info has been saved.</div>
						</div>-->

						<div class="form-group">
							<label for="name" class="sr-only">用户名</label>
							<input type="text" class="form-control" name="username" placeholder="用户名" autocomplete="off">
						</div>

						<div class="form-group">
							<label for="password" class="sr-only">密码</label>
							<input type="password" class="form-control" name="password" placeholder="密码" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="re-password" class="sr-only">确认密码</label>
							<input type="password" class="form-control" name="password_confirmation" placeholder="确认密码" autocomplete="off">
						</div>

						<div class="form-group">
							<p>已有账号? <a href="{{ url('login') }}">立即登录</a></p>
						</div>
						<div class="form-group">
							<input type="submit" value="立即注册" class="btn btn-primary">
						</div>
					</form>
					<!-- END Sign In Form -->


				</div>
			</div>

		</div>
	
	<!-- jQuery -->
	<script src="{{ url('js/jquery.min.js') }}"></script>
	<!-- Bootstrap -->
	<script src="{{ url('js/bootstrap.min.js') }}"></script>
	<!-- Placeholder -->
	<script src="{{ url('js/jquery.placeholder.min.js') }}"></script>
	<!-- Waypoints -->
	<script src="{{ url('js/jquery.waypoints.min.js') }}"></script>
	<!-- Main JS -->
	<script src="{{ url('js/main.js') }}"></script>

	</body>
</html>

