<section id="col-left" class="col-left-nano">
    <div id="col-left-inner" class="col-left-nano-content">
        <div id="user-left-box" class="clearfix hidden-sm hidden-xs dropdown profile2-dropdown">
            <a href="/user/profile"><img alt="" ng-src="/resources/img/avatar/agent/{{userProfile.Avatar}}" /></a>
            <div class="user-box">
                <span class="name">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        {{userProfile.FirstName}}
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#/change/password"><i class="fa fa-user"></i>Change Password</a></li>
<!--                        <li><a href=""><i class="fa fa-cog"></i>Settings</a></li>-->
<!--                        <li><a href=""><i class="fa fa-envelope-o"></i>Messages</a></li>-->
                        <li><a href="/login"><i class="fa fa-power-off"></i>Logout</a></li>
                    </ul>
                </span>
                <span class="status">
                    <i class="fa fa-circle"></i> {{userProfile.Roles-0 | userRoles}}
                </span>
            </div>
        </div>
		
		<div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav" bs-navbar>
			<ul class="nav nav-pills nav-stacked">
				<li class="nav-header nav-header-first hidden-sm hidden-xs">Modules</li>
<!--
				<li data-match-route="/dasboard">
					<a href="/Dashboard">
						<i class="fa fa-dashboard"></i>
						<span>Dashboard</span>
						<span class="label label-primary label-circle pull-right">28</span>
					</a>
				</li>
-->
                <li data-match-route="/purchase*">
                    <a class="dropdown-toggle">
                        <i class="fa fa-dropbox"></i>
                        <span>Purchase</span> 
                        <i class="fa fa-angle-right drop-icon"></i></a>
                    <ul class="submenu">
                        <li permission="[1,5]">
                            <a data-match-route="/purchase/order" 
                               href="#/purchase/order">
                                <span>Create P.O</span>
                            </a>
                        </li>
                        <li permission="[1,4,5,6]">
                            <a data-match-route="/purchase/history" 
                               href="#/purchase/history">
                                <span>Purchase Order</span>
                            </a>
                        </li>
                    </ul>
				</li>
                <li data-match-route="/sales*" permission="[1,2,4,5,6]">
					<a class="dropdown-toggle">
						<i class="fa fa-money"></i>
						<span>Sales</span>
                        <i class="fa fa-angle-right drop-icon"></i>
					</a>
                    <ul class="submenu">
                        <li>
                            <a data-match-route="/sales/invoice*" 
                               href="#/sales/invoice">
                                <span>Invoice</span>
                            </a>
                        </li>
                        <li>
                            <a data-match-route="/sales/postpaid*" 
                               href="#/sales/postpaid">
                                <span>Postpaid</span>
                                <span class="label label-primary badge pull-right" style="margin:10px 20px">{{MainPage.postpaid}}</span>
                            </a>
                        </li>
                        <li>
                            <a data-match-route="/sales/return*" 
                               href="#/sales/return">
                                <span>Return</span>
                            </a>
                        </li>
                    </ul>
				</li>
                <li data-match-route="/Stocks*" permission="[1,2,4,5,6]">
					<a class="dropdown-toggle" href="#/transfer/stocks">
						<i class="fa fa-puzzle-piece"></i>
						<span>Stocks Management</span>
                        <i class="fa fa-angle-right drop-icon"></i>
					</a>
                    <ul class="submenu">
                        <li permission="[1,2,4,5,6]">
                            <a data-match-route="/stocks/receiving*" 
                               href="#/stocks/receiving">
                                <span> Receiving <small class="label label-info pull-right" style="margin:10px 20px">manual</small></span>
                            </a>
                        </li>
                        <li permission="[1,2,4,5,6]" class="clearfix">
                            <a data-match-route="/stocks/transfer*" 
                               href="#/stocks/transfer">
                                <span>Transfer</span>
                                <span class="label label-primary badge pull-right" style="margin:10px 20px">{{MainPage.transfer}}</span>
                            </a>
                        </li>
                        <li permission="[1,2,5,6]">
                            <a data-match-route="/stocks/pullout*" 
                               href="#/stocks/pullout">
                                <span>Pull-Out</span>
                                <span class="label label-primary badge pull-right" style="margin:10px 20px">{{MainPage.pullout}}</span>
                            </a>
                        </li>
                    </ul>
				</li>
                <li data-match-route="/cash*" permission="[1,2,4,6]">
					<a class="dropdown-toggle">
						<i class="fa fa-keyboard-o"></i>
						<span>Cash Register</span>
                        <i class="fa fa-angle-right drop-icon"></i>
					</a>
                    <ul class="submenu">
                        <li>
                            <a data-match-route="/cash/register*" 
                               href="#/cash/register">
                                <span>Undeposited Cash</span>
                            </a>
                        </li>
                        <li>
                            <a data-match-route="/cash/card*" 
                               href="#/cash/card">
                                <span>Non Cash Payment</span>
                            </a>
                        </li>
                    </ul>
				</li>
				<li data-match-route="/Reports*">
					<a href="" class="dropdown-toggle">
						<i class="fa fa-cubes"></i>
						<span>Reports</span>
						<i class="fa fa-angle-right drop-icon"></i>
					</a>
					<ul class="submenu">
						<li data-match-route="/Reports/Sales*">
							<a class="dropdown-toggle">
								<span>Sales</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a data-match-route="/Reports/Sales/Summary" href="#/reports/sales/summary">Sales Summary</a></li>
                                <li><a data-match-route="/Reports/Sales/Detailed" href="#/reports/sales/detailed">Sales Detailed Report</a></li>
<!--
                                <li><a data-match-route="/Reports/Sales/Serials" href="#/reports/sales/serials">IMEI Sell-out</a></li>
                                <li><a data-match-route="/Reports/Sales/Customer" href="#/reports/sales/customer">By Customer</a></li>
-->
                            </ul>
						</li>
                        <li data-match-route="/Reports/inventory*">
							<a class="dropdown-toggle">
                                <span>Inventory</span>
                                <i class="fa fa-angle-right drop-icon"></i>
                            </a>
                            <ul class="submenu">
                                <li><a data-match-route="/Reports/inventory/current" href="#/reports/inventory/current">Current Inventory</a></li>
                                <li><a data-match-route="/Reports/inventory/serials" href="#/reports/inventory/serials">Available Serials</a></li>
                                <li><a data-match-route="/Reports/inventory/tracking" href="#/reports/inventory/tracking">Inventory Tracking</a></li>
                                <li permission="[1,2,5,6]"><a data-match-route="/Reports/inventory/smr" href="#/reports/inventory/smr">Stock Movement Report</a></li>
                            </ul>
						</li>
					</ul>
				</li>
				
				<li class="nav-header nav-header-first hidden-sm hidden-xs" permission="[1,2,3,5,6]">Content Management</li>
				<li data-match-route="/setup*" permission="['1']">
					<a href="#/setup" class="dropdown-toggle">
						<i class="fa fa-edit"></i>
						<span>General Settings</span>
                        <i class="fa fa-angle-right drop-icon"></i>
					</a>
                    <ul class="submenu">
                        <li><a data-match-route="/setup/store-config" href="/setup/store-config">Store Config</a></li>
                        <li><a data-match-route="/setup/superusers" href="/setup/superusers">Add Super User</a></li>
                    </ul>
				</li>
                <li data-match-route="/branches*" permission="[1,2,5,6]">
					<a data-match-route="/branches/List" href="/Branch/List">
						<i class="fa fa-home"></i>
						<span>Branches</span>
<!--						<span class="label label-primary label-circle pull-right">0</span>-->
					</a>
				</li>
				<li data-match-route="/employee*" permission="['1']">
					<a href="" class="dropdown-toggle">
						<i class="fa fa-users"></i>
						<span>Employee</span>
						<i class="fa fa-angle-right drop-icon"></i>
					</a>
					<ul class="submenu">
                        <li><a data-match-route="/employee/manager" href="/employee/manager">Area Manager</a></li>
						<li><a data-match-route="/employee/frontliner" href="/employee/frontliner">Front Liner</a></li>
						<li><a data-match-route="/employee/head-office" href="/employee/head-office">HO Personnel</a></li>
					</ul>
				</li>
				<li data-match-route="/inventory*" permission="[1,2,5,6]">
					<a href="" class="dropdown-toggle">
						<i class="fa fa-cogs"></i>
						<span>Inventory</span>
						<i class="fa fa-angle-right drop-icon"></i>
					</a>
					<ul class="submenu">
						<li>
							<a href="" class="dropdown-toggle">
								<span>Item Master Data</span>
								<i class="fa fa-angle-right drop-icon"></i>
							</a>
							<ul class="submenu">
								<li><a data-match-route="/inventory/products" href="#/inventory/products">Product List</a></li>
								<li><a data-match-route="/inventory/product/campaign" href="#/inventory/product/campaign">Product Campaign</a></li>
							</ul>
						</li>
						<li><a data-match-route="/inventory/billofmaterial" href="#/inventory/billofmaterial">Bill of Material</a></li>
					</ul>
				</li>
				<li data-match-route="/supplier*" permission="[1,2,5,6]">
					<a data-match-route="/suppliers" href="/suppliers">
						<i class="fa fa-building"></i>
						<span>Supplier</span>
<!--						<span class="label label-primary label-circle pull-right">0</span>-->
					</a>
				</li>
				<li data-match-route="/customer*" permission="[1,2,4,5,6]">
					<a data-match-route="/customers" href="/customers">
						<i class="fa fa-user"></i>
						<span>Customer</span>
<!--						<span class="label label-primary label-circle pull-right">0</span>-->
					</a>
				</li>
			</ul>
		</div>
    </div>
</section>