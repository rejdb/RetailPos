<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Cash</a></li>
                <li class="active"><span>Register</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Cash Register</h1>
                
                <div class="pull-right top-page-ui">
                    <button ng-json-export-excel data="pList" report-fields="exportFields" filename ="'Cash Register'" separator=","
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
    <div class="col-lg-8 pull-right">
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
                        <div class="col-sm-12 btn-group">
                            <label class="btn btn-primary col-sm-4" btn-radio="0" ng-model="advance.IsDeposited">Undeposited</label>
                            <label class="btn btn-primary col-sm-4" btn-radio="1" ng-model="advance.IsDeposited">Deposited</label>
                            <label class="btn btn-primary col-sm-4" btn-radio="-1" ng-model="advance.IsDeposited">Both</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group" permission="[1,2]">
                            <label class="control-label">Select Branch: <span class="popover-wrapper"><a editable-checkbox="advance.AllBranch"  e-title="Select all Branch?">{{(advance.AllBranch) ? 'All':'Single'}}</a></span></label>
                            <div ng-hide="advance.AllBranch">
                                <select ng-model="advance.Branch" class="form-control select">
                                    <option ng-repeat="p in branches | orderBy:'+Description'" ng-value="p.BranchID">{{p.Description}}</option></select>
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
                                <th class="text-center"><span>Date</span></th>
                                <th class="text-center"><span>Status</span></th>
                                <th class="text-center"><span>Amount</span></th>
                                <th class="text-center"><span>Deposit Slip</span></th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in filtered = pList | orderBy:'-TransDate' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td ng-hide="(userProfile.Roles==4)">
                                    <span>{{b.BranchDesc}}</span>
									<div class="user-subhead">
                                        <small>Branch Code: {{b.BranchCode}}</small>
                                    </div>
                                </td>
                                <td class="text-center">{{b.TransDate | dateFilter:'MM/dd/yyyy'}}</td>
                                <td class="text-center"><span class="label" ng-class="{'label-success':(b.IsDeposited=='1'), 'label-danger':(b.IsDeposited=='0')}">{{(b.IsDeposited=='1') ? 'DEPOSITED':'UNDEPOSITED'}}</span></td>
                                <td class="text-center"><h2 style="color:red">{{b.Amount | peso:2}}</h2></td>
                                <td class="text-center">
                                    <span>
                                        <a editable-text="b.DepositSlip"
                                           e-maxlength=30
                                           e-placeholder="Enter Deposit Slip No."
                                           onaftersave="updateDepositSlip(b, $index, $data)">{{b.DepositSlip || 'Not Set'}}
                                        </a>
                                    </span>
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

<script src="/resources/js/app/cash.js"></script>