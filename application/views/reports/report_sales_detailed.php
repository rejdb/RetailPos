<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Sales</a></li>
                <li class="active"><span>Report</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Sales Detailed Report</h1>
                
                <div class="pull-right top-page-ui">
                    <a href="#/sales/invoice" class="btn btn-success pull-right" style="margin-left:5px" permission="[1,2,5,6]">
                        <i class="fa fa-arrow-circle-left fa-lg"></i> Back
                    </a>
                    <button ng-json-export-excel data="pList" report-fields="exportFields" filename ="'Sales Detailed Report'" separator=","
                            id="ExportCSV" class="btn btn-info pull-right" style="margin-left:5px">
                        <i class="fa fa-external-link fa-lg"></i> CSV
                    </button>
                    <button class="btn" ng-init="collapse=true" ng-click="collapse = !collapse"
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
                    <div class="col-sm-6">
                        <div class="form-group col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="text" readonly ng-model="advance.DateFrom" class="form-control podate" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">To</span>
                                <input type="text" readonly ng-model="advance.DateTo" class="form-control podate" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" permission="[1,2,5,6]">
                            <label class="control-label">Select Branch: <span class="popover-wrapper"><a editable-checkbox="advance.AllBranch"  e-title="Select all Branch?">{{(advance.AllBranch) ? 'All':'Single'}}</a></span></label>
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
                        <option value="1">1 per page</option>
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
                    <table class="table user-list table-hover">
                        <thead>
							<tr>
                                <th ng-hide="(userProfile.Roles==4)"><span>Branch</span></th>
								<th><span>Ref Number</span></th>
                                <th class="text-center"><span>Date</span></th>
                                <th><span>Product</span></th>
                                <th><span>Warehouse</span></th>
                                <th class="text-center"><span>Quantity</span></th>
                                <th class="text-center"><span>PriceAfVat</span></th>
                                <th class="text-center"><span>Discount</span></th>
                                <th class="text-center"><span>NET Total</span></th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in filtered = pList | orderBy:'-RefNo' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td ng-hide="(userProfile.Roles==4)">
                                    <span>{{b.BranchDesc}}</span>
									<div class="user-subhead">
                                        <small>Branch Code: {{b.BranchCode}}</small>
                                    </div>
                                </td>
                                <td><span><a href="#/sales/{{b.Module}}/receipt/{{b.TransID}}">{{b.RefNo}}</a></span></td>
                                <td class="text-center">{{b.TransDate}}</td>
                                <td>{{b.ProductDesc}}</td>
                                <td>{{b.WhsName}}</td>
                                <td class="text-center">{{b.Quantity | number:0}}</td>
                                <td class="text-center">{{b.PriceAfVat | peso:2}}</td>
                                <td class="text-center">{{b.DiscValue || 0 | peso:2}}</td>
                                <td class="text-center">{{b.TotalAfDiscount | peso:2}}</td>
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

<script src="/resources/js/report/sales.js"></script>