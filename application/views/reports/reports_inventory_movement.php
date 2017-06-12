<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Reports</a></li>
                <li class="active"><span>Inventory Movement</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Stock Movement Report</h1>
                
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
                    <button ng-json-export-excel data="pList" report-fields="exportFields" filename ="'Stock Movement Report (' + advance.DateFrom + ' - ' + advance.DateTo + ')'" separator=","
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
    <div class="col-lg-6 pull-right">
        <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="text" readonly ng-model="advance.DateFrom" class="form-control podate" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon">To</span>
                                <input type="text" readonly ng-model="advance.DateTo" class="form-control podate" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                <th class="text-center"><small>Beginning</small></th>
                                <th class="text-center"><small>Purchase Received</small></th>
                                <th class="text-center"><small>Receiving</small></th>
                                <th class="text-center"><small>Transfer In</small></th>
                                <th class="text-center"><small>Transfer Out</small></th>
                                <th class="text-center"><small>Sales</small></th>
                                <th class="text-center"><small>Postpaid</small></th>
                                <th class="text-center"><small>Return</small></th>
                                <th class="text-center"><small>Pullout</small></th>
                                <th class="text-center"><small>Ending</small></th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in filtered = pList | orderBy:'+ProductDesc' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td ng-hide="(userProfile.Roles==4)">
                                    <span class="user-link">{{b.BranchDesc}}</span>
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
                                <td class="text-center">{{b.Beginning | number:0}}</td>
                                <td class="text-center">{{b.GRPO | number:0}}</td>
                                <td class="text-center">{{b.Receiving | number:0}}</td>
                                <td class="text-center">{{b.TransferIn | number:0}}</td>
                                <td class="text-center">{{b.TransferOut | number:0}}</td>
                                <td class="text-center">{{b.Sales | number:0}}</td>
                                <td class="text-center">{{b.Postpaid | number:0}}</td>
                                <td class="text-center">{{b.SalesReturn | number:0}}</td>
                                <td class="text-center">{{b.Pullout | number:0}}</td>
                                <td class="text-center">{{b.Ending | number:0}}</td>
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