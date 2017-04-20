<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Purchasing</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Purchase History</h1>
                
                <div class="pull-right top-page-ui">
                    <a href="#/purchase/order" class="btn btn-success pull-right" style="margin-left:5px" permission="[1,2]">
                        <i class="fa fa-arrow-circle-left fa-lg"></i> New P.O
                    </a>
                    <button class="btn btn-info pull-right" style="margin-left:5px"
                        ng-show="userProfile.Roles!=4" ng-click="ExportCSV(advance)">
                        <i class="fa fa-external-link fa-lg"></i> CSV
                    </button>
                    <button ng-json-export-excel data="PurchaseList" report-fields="exportFields" filename ="'Purchase Summary'" separator=","
                            ng-show="false" id="HideExport"
                            class="btn btn-info pull-right" style="margin-left:5px">
                        <i class="fa fa-external-link fa-lg"></i> HideCSV
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
    <div class="col-lg-8">
        <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
                <div class="row">
                    <div class="col-sm-8">
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
                        <div class="btn-group col-sm-12">
                            <label class="btn btn-primary col-sm-2" btn-radio="0" ng-model="advance.Type">Open</label>
                            <label class="btn btn-primary col-sm-3" btn-radio="1" ng-model="advance.Type">Partial</label>
                            <label class="btn btn-primary col-sm-2" btn-radio="2" ng-model="advance.Type">Closed</label>
                            <label class="btn btn-primary col-sm-3" btn-radio="3" ng-model="advance.Type">Canceled</label>
                            <label class="btn btn-primary col-sm-2" btn-radio="-1" ng-model="advance.Type">All</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group" permission="[1,2,5,6]">
                            <label class="control-label">Select Branch: <span class="popover-wrapper"><a editable-checkbox="advance.AllBranch"  e-title="Select all Branch?">{{(advance.AllBranch) ? 'All':'Single'}}</a></span></label>
                            <div ng-hide="advance.AllBranch">
                                <select ng-model="advance.ShipToBranch" class="form-control" id="PoBranch" >
                                    <option ng-repeat="p in branches" ng-value="p.BranchID">{{p.Description}}</option></select>
                            </div>
                        </div>
                        <button ng-click="AdvanceFilter(advance)" class="btn btn-primary btn-block"><i class="fa fa-check-circle"></i> Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
                <form novalidate="novalidate" ng-submit="Po_filter(search.TransID)" name="sFormSingle">
                    <div class="form-group">
                        <label class="control-label" for="SearchPurchaseNumbuer">Search Specific Transaction</label>
                        <input type="text" class="form-control" ng-model="search.TransID" 
                               placeholder="Enter Purchase Order Number" required />
                    </div>
                    <button class="btn btn-primary pull-right"><i class="fa fa-check-circle"></i> Search</button>
                </form>
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
                    <span class="pull-left"><input type="text" class="form-control" ng-model="find.PONumber" placeholder="Search..." /></span>
                </div>
                <div class="pull-right">
                    <div class="btn-group">
                        <label class="btn btn-primary" btn-radio="''" ng-model="find.Status">All PO</label>
                        <label class="btn btn-primary" btn-radio="0" ng-model="find.Status">Open PO</label>
                        <label class="btn btn-primary" btn-radio="1" ng-model="find.Status">Partial</label>
                        <label class="btn btn-primary" btn-radio="2" ng-model="find.Status">Closed</label>
                        <label class="btn btn-primary" btn-radio="3" ng-model="find.Status">Canceled</label>
                    </div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <table class="table user-list table-hover">
                        <thead>
							<tr>
								<th><span>Name<small>/supplier</small></span></th>
								<th class="text-center"><span>PO Date</span></th>
								<th class="text-center"><span>PO Number</span></th>
                                <th class="text-center"><span>Received<small>/QTY</small></span></th>
                                <th class="text-center"><span>Total</span></th>
								<th class="text-center"><span>GTotal</span></th>
								<th class="text-center"><span>Status</span></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in filtered = pList | orderBy:'+Description' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
                                    <img ng-src="/resources/img/avatar/store/{{b.Avatar}}" alt="{{user.Avatar}}"/>
									<span class="user-link">{{(userProfile.Roles!=4) ? b.Description : b.CoyName}}</span>
									<span class="user-subhead">
                                        Delivery Date: {{b.DeliveryDate}}
                                    </span>
                                </td>
                                <td class="text-center">{{b.TransDate}}</td>
                                <td class="text-center"><a title="View Receipt" href="/purchase/receipt/{{b.TransID}}">{{b.PONumber}}</a></td>
                                <td class="text-center">{{b.ReceivedQty | number:0}} /<small>{{b.Quantity || 'Not Set'}}</small></td>
                                <td class="text-center">{{b.Total | peso:2}}</td>
                                <td class="text-center">{{b.GTotal | peso:2}}</td>
                                <td class="text-center">
                                    <span class="label"
                                          ng-class="{'label-default': (b.Status=='0'),'label-success':(b.Status=='2'), 'label-danger':(b.Status=='3'), 'label-warning':(b.Status=='1')}">
                                        {{b.Status-0 | purchaseStatus}}
                                    </span>
                                </td>
                                <td style="width: 12%;">
                                    <span ng-show="b.ReceivedQty>0">
                                        <a href="#/purchase/received/receipt/{{b.TransID}}" 
                                           title="View and Print with Serial"
                                           class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-print fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </span>
                                    <span ng-show="{{(b.Status=='3' || b.Status=='2') ? false:true}}">
                                        <a href="#/purchase/received/{{b.TransID}}" 
                                           title="Add Quantity / Serials" class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a href="" permission="[1,2]"
                                           ng-click="ClosedPurchase(b, $index)"
                                           title="Closed / Cancel PO"
                                           class="table-link disabled">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-times-circle fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a></span>
								</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <pagination total-items="totalItems" max-size="noOfPages" ng-model="currentPage" items-per-page="pageSize"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/purchase.js"></script>