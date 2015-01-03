<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>FOCUS Kalamazoo</title>
		@section('head')
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/modern-business.css') }}
		{{ HTML::style('font-awesome-4.2.0/css/font-awesome.min.css') }}
		<!-- Bootstrap Core CSS 
		<link href="css/bootstrap.css" rel="stylesheet">  -->

		<!-- Custom CSS 
		<link href="css/modern-business.css" rel="stylesheet">
		-->
		<!-- Custom Fonts 
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->

		@show
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::to('admin') }}">FOCUS Kalamazoo Admin Portal</a>
				</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Events <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ URL::route('admin.events.index') }} ">Edit</a>
							</li>
							<li>
								<a href=" {{ URL::route('admin.events.create') }}  ">Create new</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Students <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="{{ URL::route('admin.students.index') }} ">Edit</a>
								</li>
								<li>
									<a href=" {{ URL::route('admin.students.create') }}  ">Create new</a>
								</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Nonprofits <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ URL::route('admin.nonprofits.index') }} ">Edit</a>
							</li>
							<li>
								<a href=" {{ URL::route('admin.nonprofits.create') }}  ">Create new</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Team <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ URL::route('admin.members.index') }} ">Edit</a>
							</li>
							<li>
								<a href=" {{ URL::route('admin.members.create') }}  ">Create new</a>
							</li>
						</ul>
					</li>
					<li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Volunteers <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ URL::route('admin.volunteers.index') }} ">Edit</a>
							</li>
							<li>
								<a href=" {{ URL::route('admin.volunteers.create') }}  ">Create new</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out fa-lg"></i> Log out</a>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>
		<!-- /.navbar-->
		<div class="container">
		

		@yield('content')

		<!-- Footer -->
		<footer>
			<div class="row">
				<div class="col-lg-12">
					<p>Copyright &copy; FOCUS KZOO 2014</p>
				</div>
			</div>
		</footer>

		</div>
		<!-- /.container -->

		<!-- jQuery Version 1.11.0 -->
		{{ HTML::script('js/jquery-1.11.0.js') }}

		<!-- Bootstrap Core JavaScript -->
		{{ HTML::script('js/bootstrap.min.js') }}

		<!-- Makes restful javascript simple-->
		{{ HTML::script('js/rails.js') }}

		<!---->
		{{ HTML::script('js/jquery-sortable.js') }}
		
		<!-- Script to Activate the Carousel -->
		<script>
			$('.carousel').carousel({
				interval: 5000 //changes the speed
			})

			var group = $('.sorted_table').sortable({
			  containerSelector: 'table',
			  itemPath: '> tbody',
			  itemSelector: 'tr',
			  nested: 'false',
			  placeholder: '<tr class="placeholder"/>',

			  serialize: function (parent, children, isContainer) {
				    return isContainer ? children.join() : parent.attr("id")
  				},
			  onDrop: function ($item, container, _super, event) {
				  $item.removeClass("dragged").removeAttr("style")
				  $("body").removeClass("dragging")
				  //console.log("B he") add callback in here
				  
				var data = group.sortable("serialize").get();

    			var jsonString = JSON.stringify(data);

				console.log(jsonString)

				

				}
		})

		
		</script>
	</body>

</html>