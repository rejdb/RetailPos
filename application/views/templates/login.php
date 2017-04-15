<!DOCTYPE html>
<html ng-app="loginApp">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Login | Techbox POS</title>
	
	<!-- bootstrap -->
	<link rel="stylesheet" type="text/css" href="/resources/css/bootstraps/bootstrap.min.css" />
	
	<!-- libraries -->
	<link rel="stylesheet" type="text/css" href="/resources/css/libs/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="/resources/css/libs/nanoscroller.css" />

	<!-- global styles -->
	<link rel="stylesheet" type="text/css" href="/resources/css/compiled/theme_styles.css" />
    <link rel="stylesheet" type="text/css" href="/resources/css/compiled/spinner.css" />

	<!-- this page specific styles -->

	<!-- google font libraries -->
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>
	
	<!-- Favicon -->
	<link type="image/x-icon" href="/favicon.png" rel="shortcut icon"/>

	<!--[if lt IE 9]>
		<script src="../js/html5shiv.js"></script>
		<script src="../js/respond.min.js"></script>
	<![endif]-->
</head>
<body ng-controller="loginCtrl">
	<div class="container">
		<div class="row">
            <span ng-init="$root.loadSpinner=false" ng-show="loadSpinner">  
              <div class="overlay"></div>
              <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
              </div>
              <div class="please-wait">Please Wait...</div>
            </span> 
            <span ng-init="$root.notify=false" ng-show="$root.notify" ng-cloak="false">
                <div class="overlay"></div>
                <div class="alert text-center"
                     ng-class="{'alert-success success':$root.successfully, 'alert-danger success':!$root.successfully}">
                    <span class="fa fa-times pull-right" ng-click="$root.notify=false"></span>
                    <small>{{alert_message}}</small>
                </div>
            </span>
			<div class="col-xs-12">
				<div id="login-box">
					<div id="login-box-holder">
						<div class="row">
							<div class="col-xs-12">
								<header id="login-header">
									<div id="login-logo">
<!--										<img src="/resources/img/tbx.jpg" alt=""/>-->
                                        <span style="font-size:25px">Techbox POS</span>
									</div>
								</header>
								<div id="login-box-inner">
									<form ng-submit="submitLogin()" novalidate="novalidate">
<!--
                                        <div class="alert alert-danger" ng-show="error">
                                            <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                            <strong>Opppsss!</strong> {{err_msg}}.
                                        </div>
-->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input class="form-control" type="text" required="required" ng-model="login.Email" placeholder="Email address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                <input type="password" class="form-control" required="required" ng-model="login.Password" placeholder="Password">
                                            </div>
                                        </div>
										<div class="row">
											<div class="col-xs-12">
												<button class="btn btn-success col-xs-12" id="SubmitBtn" data-loading-text='<i class="fa fa-spinner fa-spin"></i>'>Login</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="config-tool" class="closed">
		<a id="config-tool-cog">
			<i class="fa fa-cog"></i>
		</a>
		
		<div id="config-tool-options">
			<h4>Layout Options</h4>
			<ul>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-fixed-header" />
						<label for="config-fixed-header">
							Fixed Header
						</label>
					</div>
				</li>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-fixed-sidebar" />
						<label for="config-fixed-sidebar">
							Fixed Left Menu
						</label>
					</div>
				</li>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-fixed-footer" />
						<label for="config-fixed-footer">
							Fixed Footer
						</label>
					</div>
				</li>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-boxed-layout" />
						<label for="config-boxed-layout">
							Boxed Layout
						</label>
					</div>
				</li>
				<li>
					<div class="checkbox-nice">
						<input type="checkbox" id="config-rtl-layout" />
						<label for="config-rtl-layout">
							Right-to-Left
						</label>
					</div>
				</li>
			</ul>
			<br/>
			<h4>Skin Color</h4>
			<ul id="skin-colors" class="clearfix">
				<li>
					<a class="skin-changer" data-skin="" data-toggle="tooltip" title="Default" style="background-color: #34495e;">
					</a>
				</li>
				<li>
					<a class="skin-changer" data-skin="theme-white" data-toggle="tooltip" title="White/Green" style="background-color: #2ecc71;">
					</a>
				</li>
				<li>
					<a class="skin-changer blue-gradient" data-skin="theme-blue-gradient" data-toggle="tooltip" title="Gradient">
					</a>
				</li>
				<li>
					<a class="skin-changer" data-skin="theme-turquoise" data-toggle="tooltip" title="Green Sea" style="background-color: #1abc9c;">
					</a>
				</li>
				<li>
					<a class="skin-changer" data-skin="theme-amethyst" data-toggle="tooltip" title="Amethyst" style="background-color: #9b59b6;">
					</a>
				</li>
				<li>
					<a class="skin-changer" data-skin="theme-blue" data-toggle="tooltip" title="Blue" style="background-color: #2980b9;">
					</a>
				</li>
				<li>
					<a class="skin-changer" data-skin="theme-red" data-toggle="tooltip" title="Red" style="background-color: #e74c3c;">
					</a>
				</li>
				<li>
					<a class="skin-changer" data-skin="theme-whbl" data-toggle="tooltip" title="White/Blue" style="background-color: #3498db;">
					</a>
				</li>
			</ul>
		</div>
	</div>
	
	<!-- global scripts -->
	<script src="/resources/js/dependencies/skin-changer.js"></script> <!-- only for demo -->
	
	<script src="/resources/js/dependencies/jquery-2.2.3.min.js"></script>
	<script src="/resources/js/dependencies/bootstrap.min.js"></script>
	<script src="/resources/js/dependencies/jquery.nanoscroller.min.js"></script>
    <script src="/resources/js/dependencies/jquery.cookie.js"></script>
	
	<script src="/resources/js/dependencies/tbxApp.js"></script> <!-- only for demo -->
	
	<!-- this page specific scripts -->
    <!-- angular libs -->
    <script src="/resources/js/angular/angular.min.js"></script>
    <script src="/resources/js/angular/angular-ui-router.min.js"></script>
    <script src="/resources/js/angular/angular-cookies.min.js"></script>
    <script src="/resources/js/angular/angular-animate.js"></script>
    <script src="/resources/js/angular/loading-bar.js"></script>
    <script src="/resources/js/angular/angular.easypiechart.min.js"></script>
    <script src="/resources/js/angular/jcs-auto-validate.min.js"></script>
    <script src="/resources/js/dependencies/ui-bootstrap-tpls-2.5.0.min.js"></script>


    <!-- angular scripts -->
    <script src="/resources/js/app/login.js"></script>
	
	<!-- theme scripts -->
	<script src="/resources/js/dependencies/scripts.js"></script>
	
	<!-- this page specific inline scripts -->
	
</body>
</html>