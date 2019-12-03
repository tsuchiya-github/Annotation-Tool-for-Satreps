<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Haruki Tsuchiya">
<title>Haruki Tsuchiya</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link href="/css/tsuchiyaweb.css" rel="stylesheet">
<script src="/js/tsuchiyaweb.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>

		<div class="zdo_drawer_menu left">
				<div class="zdo_drawer_bg"></div>
				<button type="button" class="zdo_drawer_button">
					<span class="zdo_drawer_bar zdo_drawer_bar1"></span>
					<span class="zdo_drawer_bar zdo_drawer_bar2"></span>
					<span class="zdo_drawer_bar zdo_drawer_bar3"></span>
					<span class="zdo_drawer_menu_text zdo_drawer_text">MENU</span>
					<span class="zdo_drawer_close zdo_drawer_text">CLOSE</span>
				</button>
				<nav class="zdo_drawer_nav_wrapper">
					<ul class="zdo_drawer_nav">
						<li>
							<a href="/" style="color: white; opacity:1.0;">
								TOP PAGE
							</a>
						</li>
						<li>
							<a href="/about" style="color: white; opacity:1.0;">
								About Me
							</a>
						</li>
						<li>
							<a href="/research" style="color: white; opacity:1.0;">
								Research Theme
							</a>
						</li>
						<li>
							<a href="/info" style="color: white; opacity:1.0;">
								Contact
							</a>
						</li>
						<li>
							<a href="http://www.cvl.cs.chubu.ac.jp/index-j.html" style="color: white; opacity:1.0;">
								Laboratory
							</a>
						</li>
						<li>
							<a style="color: black; opacity:1.0;">
								<input type="button" value="Questionnaire" onclick="gate();">
							</a>
						</li>
						<li>
						</li>
					</ul>
				</nav>
			</div>
<div class='section'>
	@yield('slide')
	<div class='container'>
	<div class="row">
	{{-- @yield('slide') --}}
	</div>
</div>
<div class='container'>
	@yield('content')
	<br>
</div>

</div>

<p id="page-top"><a href="#wrap">PAGE TOP</a></p>


<div id="footer">

		<div class="container">
				<span class="copyright">
						&copy; Copyright <a href="http://localhost:8000/" target="_blank">Haruki Tsuchiya</a> All Rights Reserved.
				</span>
		</div>
  
</div>
<!--//footer-->
<style>
#wrap {
  min-height: 100%;
  height: auto;
  /* フッターの高さ分だけ、ネガティブインデントを指定 */
  margin: 0 auto -60px;
  /* フッターの高さ分だけ、パディングを指定 */
  padding: 0 0 60px;
}

/* ここでフッターの高さを指定 */
#footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  height: 30px;
  background-color: #f5f5f5;
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="/js/jquery.balloon.js"></script>

</body>
</html>

