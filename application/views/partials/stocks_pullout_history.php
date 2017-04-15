<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Stock Management</a></li>
                <li class="active"><span>Pull-out</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Pull-out History</h1>
                
                <div class="pull-right top-page-ui">
                    <a href="#/stocks/transfer" class="btn btn-success pull-right" style="margin-left:5px">
                        <i class="fa fa-history fa-lg"></i> New Pull-out
                    </a>
                    <button ng-json-export-excel data="pList" report-fields="exportFields" filename ="'Pullout Summary'" separator=","
                            ng-show="userProfile.Roles!=4"
                            class="btn btn-info pull-right" style="margin-left:5px">
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
                            <label class="btn btn-primary col-sm-2" btn-radio="1" ng-model="advance.Status">Pending</label>
                            <label class="btn btn-primary col-sm-3" btn-radio="2" ng-model="advance.Status">Approved</label>
                            <label class="btn btn-primary col-sm-2" btn-radio="3" ng-model="advance.Status">Received</label>
                            <label class="btn btn-primary col-sm-3" btn-radio="4" ng-model="advance.Status">Canceled</label>
                            <label class="btn btn-primary col-sm-2" btn-radio="-1" ng-model="advance.Status">All</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group" permission="[1,2,5,6]">
                            <label class="control-label">Select Branch: <span class="popover-wrapper"><a editable-checkbox="advance.AllBranch"  e-title="Select all Branch?">{{(advance.AllBranch) ? 'All':'Single'}}</a></span></label>
                            <div ng-hide="advance.AllBranch">
                                <select ng-model="advance.Branch" class="form-control" id="PoBranch" >
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
                <form novalidate="novalidate" ng-submit="filter(search.TransID)" name="sFormSingle">
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
								<th><span>Reference Number</span></th>
                                <th class="text-center"><span>Date</span></th>
                                <th class="text-center"><span>Quantity</span></th>
                                <th class="text-center"><span>Total</span></th>
								<th class="text-center"><span>Status</span></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in filtered = pList | orderBy:'+TransDate' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
                                    <img ng-src="/resources/img/avatar/store/{{b.Avatar}}" alt="{{user.Avatar}}"/>
                                    <span class="user-link"><a href="#/stocks/pullout/receipt/{{b.TransID}}">{{b.RefNo}}</a></span>
									<span class="user-subhead">
                                        {{(b.TransferType==1) ? 'Warehouse Transfer':'Store Transfer'}}
                                    </span>
                                </td>
                                <td class="text-center">{{b.TransDate}}</td>
                                <td class="text-center">{{b.Quantity | number:0}}</td>
                                <td class="text-center">{{b.Total | peso:2}}</td>
                                <td class="text-center">
                                    <span class="label" ng-class="{'label-warning':(b.Status=='1'), 'label-success':(b.Status=='2'),
                                          'label-info':(b.Status=='3'), 'label-danger':(b.Status=='4')}">
                                        {{b.Status-0 | pulloutStatus}}
                                    </span>
                                </td>
                                <td style="width: 12%;">
                                    <a href="#/stocks/transfer/receipt/{{b.TransID}}" class="table-link">
                                        <span class="fa-stack">
                                            <i class="fa fa-print fa-stack-2x"></i>
                                            <i class="fa fa-square fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <span ng-class="{'hidden': (b.Status!='1')}">
                                        <a ng-click="PulloutStatus(b.TransID, 2)" 
                                           permission="[1,5]"
                                           class="table-link danger">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-check fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a ng-click="PulloutStatus(b.TransID, 4)" class="table-link danger">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </span>
                                    <a ng-click="PulloutStatus(b.TransID, 3)" 
                                       ng-show="(b.Status==2 && b.Branch==userProfile.Branch.BranchID)"
                                       class="table-link danger">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-cloud-upload fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <a ng-click="PulloutStatus(b.TransID, 4)" 
                                       ng-show="(b.Status==2 && b.InvTo==userProfile.Branch.BranchID)"
                                       class="table-link danger">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
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

<script src="/resources/js/app/pullout.js"></script>