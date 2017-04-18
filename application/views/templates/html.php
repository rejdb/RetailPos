<!DOCTYPE html>
<html ng-app="tbxWebApp">
    <head>
		<base href="/" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        
        <title ng-bind="title + ' | Techbox POS'">Techbox Inc. - POS</title>
        <!-- Favicon --><link type="image/x-icon" href="/favicon.png" rel="shortcut icon" />
        
        <!-- bootstrap -->
        <link rel="stylesheet" type="text/css" href="/resources/css/bootstraps/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/bootstraps/ionicons.min.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/bootstraps/ng-tags-input.min.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/bootstraps/ng-tags-input.bootstrap.min.css" />
        
        <!-- libraries -->
        <link rel="stylesheet" type="text/css" href="/resources/css/libs/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/libs/nanoscroller.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/angular/angular.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/angular/loading-bar.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/angular/angular-ui-switch.min.css" />

        <!-- select2 -->
        <link rel="stylesheet" type="text/css" href="/resources/css/libs/select2.css" />
        
        <!-- datepicker -->
        <link rel="stylesheet" type="text/css" href="/resources/css/libs/datepicker.css" />

        <!-- date range picker -->
        <link rel="stylesheet" type="text/css" href="/resources/css/libs/daterangepicker.css" />
        
        
        <!-- x-editable -->
        <link rel="stylesheet" type="text/css" href="/resources/css/libs/xeditable.min.css" />
        
        <!-- timeline -->
	   <link rel="stylesheet" type="text/css" href="/resources/css/libs/timeline.css" />
        
        <!-- wizard -->
        <link rel="stylesheet" type="text/css" href="/resources/css/compiled/mywizard.css" />
<!--        <link rel="stylesheet" type="text/css" href="/resources/css/libs/bootstrap-wizard.css" />-->
        
        <!-- global styles -->
        <link rel="stylesheet" type="text/css" href="/resources/css/compiled/theme_styles.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/compiled/spinner.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/compiled/my_styles.css" />
        <link rel="stylesheet" type="text/css" href="/resources/css/compiled/angucomplete-ie8.css" />
        
        <!-- google font libraries -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>
    </head>
    
    <body oncontextmenu="return false">
        <div id="theme-wrapper">
            <?php require 'header.php'; ?>
            <div id="page-wrapper" class="container">
                <div class="row">
                    <div id="nav-col">
                        <?php require 'sidenav.php'; ?>
                        <div id="nav-col-submenu"></div>
                    </div>
                    <div id="content-wrapper">
                        <span ng-init="loadSpinner=false" ng-show="loadSpinner">  
                          <div class="overlay"></div>
                          <div class="spinner">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                          </div>
                          <div class="please-wait">Please Wait...</div>
                        </span> 
                        <span ng-init="notify=false" ng-show="notify" ng-cloak="false">
                            <div class="overlay"></div>
                            <div class="alert text-center"
                                 ng-class="{'alert-success success':successfully, 'alert-danger success':!successfully}">
                                <span class="fa fa-times pull-right" ng-click="notify=false"></span>
                                <small>{{alert_message}}</small>
                            </div>
                        </span>
                        <div class="row">
                            <div class="col-lg-12">
<!--                                <span us-spinner="{radius:10, width:5, length: 5}" spinner-key="spinner-1"></span>--> 
                                <div class="slide-main-container">
                                    <div ui-view autoscroll=false class="slide-main-animation"></div>
                                </div>
                            </div>
                        </div>

                        <footer id="footer-bar" class="row" style="padding:0 10px 0 10px">
                            <div class="pull-right hidden-xs"><b>TAS Version</b> <?php echo  $this->config->item('version');?></div>
	                           <strong>TechboxPOS&trade; 2016-2017 <a href="http://www.techboxhub.com"><?php echo $this->config->item('company');?></a>.</strong> All rights reserved.
<!--                            <p id="footer-copyright" class="col-xs-12">Powered by Cube Theme. {{ tbxConfig }}</p>-->
                        </footer>
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
        <script src="/resources/js/dependencies/skin-changer.js"></script> <!-- Skin Changer -->

        <script src="/resources/js/dependencies/jquery-2.2.3.min.js"></script>
<!--            <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>-->
        <script src="/resources/js/dependencies/bootstrap.min.js"></script>
        <script src="/resources/js/dependencies/jquery.nanoscroller.min.js"></script>
        <script src="/resources/js/dependencies/jquery.cookie.js"></script>

        <script src="/resources/js/dependencies/tbxApp.js"></script> <!-- Techbox App-->

        
        <!-- select2 -->
        <script src="/resources/js/dependencies/select2.min.js"></script>
        
        <!-- moment js -->
        <script src="/resources/js/dependencies/moment.min.js"></script>
        
        <!-- datepicker -->
        <script src="/resources/js/dependencies/bootstrap-datepicker.js"></script>

        <!-- daterange picker -->
        <script src="/resources/js/dependencies/daterangepicker.js"></script>
        
        <!-- timeline -->
        <script src="/resources/js/dependencies/timeline.js"></script>
        <script src="/resources/js/dependencies/jquery.grid-a-licious.min.js"></script>

        <!-- angular libs -->
        <script src="/resources/js/angular/1.2.0/angular.min.js"></script>
        <script src="/resources/js/angular/1.2.0/angular-cookies.min.js"></script>
        <script src="/resources/js/angular/1.2.0/angular-animate.js"></script>
<!--
        <script src="/resources/js/angular/angular.min.js"></script>
        <script src="/resources/js/angular/angular-cookies.min.js"></script>
        <script src="/resources/js/angular/angular-animate.js"></script>
-->
        <script src="/resources/js/angular/loading-bar.js"></script>
        <script src="/resources/js/angular/angular.easypiechart.min.js"></script>
        
        <script src="/resources/js/angular/angular-ui-router.min.js"></script>
        <script src="/resources/js/angular/jcs-auto-validate.min.js"></script>
        <script src="/resources/js/angular/angular-ui-switch.min.js"></script>
        <script src="/resources/js/angular/angucomplete-ie8.min.js"></script>
        
        <script src="/resources/js/dependencies/ui-bootstrap-tpls-0.12.0.min.js"></script>
<!--        <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.12.0.js"></script>-->
<!--        <script src="/resources/js/dependencies/ui-bootstrap-tpls-2.5.0.min.js"></script>-->
        
        <!-- x-editable -->
        <script src="/resources/js/dependencies/xeditable.min.js"></script>
        <script src="/resources/js/dependencies/ngPrint.min.js"></script>
        <script src="/resources/js/dependencies/ng-tags-input.min.js"></script>
        <script src="/resources/js/dependencies/FileSaver.js"></script>
        <script src="/resources/js/dependencies/json-export-excel.min.js"></script>
        

        <!-- angular scripts -->
        <script src="/resources/js/app/app.js"></script>
        <script src="/resources/js/app/directives.js"></script>
        <script src="/resources/js/app/controllers.js"></script>
        <script src="/resources/js/app/services.js"></script>
        <script src="/resources/js/app/filters.js"></script>

        <!-- theme scripts -->
        <script src="/resources/js/dependencies/scripts.js"></script>
    </body>
</html>