<header class="navbar" id="header-navbar">
    <div class="container">
        <a href="/" id="logo" class="navbar-brand">
			<span class="normal-logo logo-white center">Techbox POS</span>
<!--
            <img src="/resources/img/logo.png" alt="" class="normal-logo logo-white"/>
            <img src="/resources/img/logo-black.png" alt="" class="normal-logo logo-black"/>
            <img src="/resources/img/logo-small.png" alt="" class="small-logo hidden-xs hidden-sm hidden"/>
-->
            
<!--
            <img src="/resources/img/tbx.jpg" alt="" class="normal-logo logo-white"/>
            <img src="/resources/img/tblogo-black.png" alt="" class="normal-logo logo-black"/>
            <img src="/resources/img/logo-small.png" alt="" class="small-logo hidden-xs hidden-sm hidden"/>
-->
        </a>
        
        <div class="clearfix">
            <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="fa fa-bars"></span>
            </button>
            
            <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
                <ul class="nav navbar-nav pull-left">
                    <li>
                        <a class="btn" id="make-small-nav">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <li class="dropdown hidden-xs" permission="[1,5]">
                        <a class="btn dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="count">{{MainPage.approval.total}}</span>
                        </a>
                        <ul class="dropdown-menu notifications-list">
                            <li class="pointer">
                                <div class="pointer-inner">
                                    <div class="arrow"></div>
                                </div>
                            </li>
                            <li class="item-header">You have {{(MainPage.approval.total==1) ? 'a':MainPage.approval.total}} new notifications</li>
                            <li class="item">
                                <a href="#/stocks/transfer/history">
                                    <i class="ion-code-working"></i>
                                    <span class="content">You have {{MainPage.approval.transfer}} new transfer that requires approval</span>
<!--                                    <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                </a>
                            </li>
                            <li class="item">
                                <a href="#/stocks/pullout/history">
                                    <i class="fa fa-plus"></i>
                                    <span class="content">You have {{MainPage.approval.pullout}} new pullout that requires approval</span>
<!--                                    <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>-->
                                </a>
                            </li>
                            <li class="item-footer">
                                <a href="">
                                    View all notifications
                                </a>
                            </li>
                        </ul>
                    </li>
<!--
                    <li class="dropdown hidden-xs" permission="[1,2]">
                        <a class="btn dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="count">16</span>
                        </a>
                        <ul class="dropdown-menu notifications-list messages-list">
                            <li class="pointer">
                                <div class="pointer-inner">
                                    <div class="arrow"></div>
                                </div>
                            </li>
                            <li class="item first-item">
                                <a href="">
                                    <img src="/resources/img/samples/messages-photo-1.png" alt=""/>
                                    <span class="content">
                                        <span class="content-headline">
                                            George Clooney
                                        </span>
                                        <span class="content-text">
                                            Look, just because I don't be givin' no man a foot massage don't make it 
                                            right for Marsellus to throw...
                                        </span>
                                    </span>
                                    <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                                </a>
                            </li>
                            <li class="item">
                                <a href="">
                                    <img src="/resources/img/samples/messages-photo-3.png" alt=""/>
                                    <span class="content">
                                        <span class="content-headline">
                                            Robert Downey Jr.
                                        </span>
                                        <span class="content-text">
                                            Look, just because I don't be givin' no man a foot massage don't make it 
                                            right for Marsellus to throw...
                                        </span>
                                    </span>
                                    <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                                </a>
                            </li>
                            <li class="item-footer">
                                <a href="">
                                    View all messages
                                </a>
                            </li>
                        </ul>
                    </li>
-->
                </ul>
            </div>
            
            <div class="nav-no-collapse pull-right" id="header-nav">
                <ul class="nav navbar-nav pull-right">
                    <li class="mobile-search">
                        <a class="btn">
                            <i class="fa fa-search"></i>
                        </a>

                        <div class="drowdown-search" ng-controller="mainCtrl">
                            <form role="search" ng-submit="SearcPrice(SearchItemPrice)">
                                <div class="form-group">
                                    <input type="text" class="form-control" 
                                           ng-model="SearchItemPrice"
                                           placeholder="Check Item Price...">
                                    <i class="fa fa-search nav-search-icon" ng-click="SearcPrice(SearchItemPrice)"></i>
                                </div>
                            </form>
                        </div>

                    </li>
                    <li class="dropdown profile-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img ng-src="/resources/img/avatar/store/{{ userProfile.Branch.Avatar }}" alt=""/>
                            <span class="hidden-xs">{{ userProfile.Branch.Description }}</span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#/change/password"><i class="fa fa-user"></i>Change Password</a></li>
<!--                            <li><a href=""><i class="fa fa-cog"></i>Settings</a></li>-->
<!--                            <li><a href=""><i class="fa fa-envelope-o"></i>Messages</a></li>-->
                            <li><a href="/login"><i class="fa fa-power-off"></i>Logout</a></li>
                        </ul>
                    </li>
                    <li class="hidden-xxs">
                        <a href="/login" class="btn">
                            <i class="fa fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>