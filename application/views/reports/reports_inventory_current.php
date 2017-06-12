<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Reports</a></li>
                <li class="active"><span>Inventory</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Current Inventory</h1>
                
                <div class="pull-right top-page-ui">
<!--
                    <a href="#/purchase/order" class="btn btn-success pull-right" style="margin-left:5px" permission="[1,2]">
                        <i class="fa fa-arrow-circle-left fa-lg"></i> Back
                    </a>
-->
<!--
                    <a href="/reports/current_inventory" class="btn btn-info pull-right" style="margin-left:5px" permission="[1,2]">
                        <i class="fa fa-cloud-download fa-lg"></i> Excel
                    </a>
-->
                    <button ng-json-export-excel data="pList" report-fields="exportFields" filename ="'Running Inventory'" separator=","
                            class="btn btn-info pull-right" style="margin-left:5px">
                        <i class="fa fa-external-link fa-lg"></i> CSV
                    </button>
                    <button class="btn" ng-init="collapse=true" ng-click="collapse = !collapse" permission="[1,2,5,6]"
                            ng-class="{'btn-default': !collapse, 'btn-primary': collapse}">
                        <i class="fa fa-search fa-lg"></i></button>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row" collapse="collapse">
    <div class="col-lg-3 pull-right">
        <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">
                                Select Branch: 
                                <span class="popover-wrapper">
                                    <a editable-checkbox="advance.AllBranch"  e-title="Select all Branch?">{{(advance.AllBranch) ? 'All':'Single'}}</a>
                                </span>
                            </label>
                            <div ng-hide="advance.AllBranch">
                                <select ng-model="advance.Branch" class="form-control select">
                                    <option ng-repeat="p in branches" ng-value="p.BranchID">{{p.Description}}</option></select>
                            </div>
                        </div>
                        <button ng-click="AdvanceFilter(advance)" class="btn btn-primary btn-block"><i class="fa fa-check-circle"></i> Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div  class="form-group form-inline pull-left">
                    <select ng-model="pageSize" class="form-control pull-left">
                        <option value="5">5 per page</option>
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                    <span class="pull-left"><input type="text" class="form-control" ng-model="find" placeholder="Search..." /></span>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
							<tr>
								<th ng-hide="(userProfile.Roles==4)"><span>Branch</span></th>
								<th><span>Product</span></th>
								<th><span>Warehouse</span></th>
                                <th class="text-center"><small>InStocks</small></th>
                                <th class="text-center"><small>Committed</small></th>
                                <th class="text-center"><small>Available</small></th>
                                <th class="text-center" permission="[1,2,5,6]"><span>Unit Cost</span></th>
                                <th class="text-center" permission="[1,2,5,6]"><span>Total Cost</span></th>
								<th class="text-center" permission="[1,2,5,6]"><span>Unit Price</span></th>
								<th class="text-center" permission="[1,2,5,6]"><span>Total Price</span></th>
								<th class="text-center" permission="[1,2,5,6]">GP</th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in filtered = pList | orderBy:'+ProductDesc' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td ng-hide="(userProfile.Roles==4)">
                                    <span class="user-link">{{b.Description}}</span>
									<div class="user-subhead">
                                        <small>Branch Code: {{b.BranchCode}}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="user-link">{{b.ProductDesc | uppercase}}</span>
									<div class="user-subhead"><small>
                                        Product Code: {{b.BarCode}}
                                        </small>
                                    </div>
                                </td>
                                <td>{{b.WhsName | uppercase}}</td>
                                <td class="text-center">{{b.InStocks | number:0}}</td>
                                <td class="text-center">{{b.Committed | number:0}}</td>
                                <td class="text-center">{{b.Available | number:0}}</td>
                                <td class="text-right" permission="[1,2,5,6]">{{b.StdCost | peso:2}}</td>
                                <td class="text-right" permission="[1,2,5,6]">{{b.InStocks * b.StdCost | peso:2}}</td>
                                <td class="text-right" permission="[1,2,5,6]">{{b.CurrentPrice | peso:2}}</td>
                                <td class="text-right" permission="[1,2,5,6]">{{b.InStocks * b.CurrentPrice | peso:2}}</td>
                                <td class="text-right" permission="[1,2,5,6]">{{(b.InStocks * b.CurrentPrice)-(b.InStocks * b.StdCost) | peso:2}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <pagination total-items="totalItems" max-size="10" ng-model="currentPage" items-per-page="pageSize"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/inventory.js"></script>