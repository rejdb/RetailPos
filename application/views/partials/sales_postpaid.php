<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="">Home</a></li>
                <li><a href="">Sales</a></li>
                <li class="active"><span>Postpaid</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Postpaid Sales</h1>
                <div class="pull-right">
                    <button class="btn" ng-init="collapse=true" ng-click="collapse = !collapse"
                            ng-class="{'btn-default': !collapse, 'btn-primary': collapse}">
                        <i class="fa fa-search fa-lg"></i></button>
                    <button class="btn" ng-init="toggle=true" permission="[4]"
                            ng-class="{'btn-primary':toggle,'btn-default':!toggle}"
                            data-toggle="modal" data-target="#myPostpaid"
                            ng-click="toggle = !toggle">
                        <i class="fa fa-plus-circle"></i> Postpaid
                    </button>
                    <button ng-json-export-excel data="pList" report-fields="exportFields" filename ="'Postpaid Sales'" separator=","
                            ng-show="userProfile.Roles!=4"
                            class="btn btn-info pull-right" style="margin-left:5px">
                        <i class="fa fa-external-link fa-lg"></i> CSV
                    </button>
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
                            <label class="btn btn-primary col-sm-3" btn-radio="0" ng-model="advance.Status">For Activation</label>
                            <label class="btn btn-primary col-sm-3" btn-radio="1" ng-model="advance.Status">Activated</label>
                            <label class="btn btn-primary col-sm-3" btn-radio="2" ng-model="advance.Status">Cancelled</label>
                            <label class="btn btn-primary col-sm-3" btn-radio="-1" ng-model="advance.Status">All</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group" permission="[1,2,5,6]">
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
        <div class="main-box no-header clearfix">
            <header class="main-box-header clearfix">
                <div  class="form-group form-inline">
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
                    <table class="table user-list table-hover">
                        <thead>
							<tr>
								<th><span>Customer Name</span></th>
								<th ng-show="userProfile.Roles!=4"><span>Branch</span></th>
                                <th><span>Date</span></th>
                                <th><span>Contact No.</span></th>
                                <th><span>Email</span></th>
                                <th><span>Deposit Slip</span></th>
                                <th><span>Deposit Amount</span></th>
                                <th><span>Comments</span></th>
								<th class="text-center"><span>Status</span></th>
								<th class="text-center"><span>Action</span></th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="cs in filtered = pList | orderBy:'+PostpaidID' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
									<div>
                                        <span>{{cs.FirstName + ' ' + cs.LastName || 'First Name'}}</span>
                                    </div>
									<div><small>ICC ID: {{cs.IccID || 'ICC ID'}}</small></div>
                                    <div><small>SIM No.: {{cs.SimNo}}</small></div>
								</td>
                                <td ng-show="userProfile.Roles!=4"><span>{{cs.BranchDesc}}</span></td>
                                <td><span>{{cs.TransDate | dateFilter:'MM/dd/yyyy'}}</span></td>
                                <td><span>{{cs.ContactNo || 'Contact No.'}}</span></td>
                                <td><span>{{cs.Email || 'Email'}}</span></td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="cs.DepositSlip" 
                                           edit-disabled="(cs.Status==0 || (['1','4'].indexOf(userProfile.Roles)==-1))" e-ng-maxlength="20"
                                           onaftersave="updateField(cs.PostpaidID, 'DepositSlip', $data)">
                                            {{cs.DepositSlip || 'Not Set'}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-number="cs.DepositAmount" step="0.01" 
                                           edit-disabled="(cs.Status==0 || (['1','4'].indexOf(userProfile.Roles)==-1))" e-ng-maxlength="10"
                                           onaftersave="updateField(cs.PostpaidID, 'DepositAmount', $data-0, true)">
                                            {{cs.DepositAmount || 'Not Set'}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="cs.Comments" edit-disabled="['1','5'].indexOf(userProfile.Roles)==-1"
                                           e-ng-maxlength="100"
                                           onaftersave="updateField(cs.PostpaidID, 'Comments', $data)">
                                            {{cs.Comments || 'Not Set'}}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center" >
                                    <div class="popover-wrapper">
                                        <a editable-checkbox="cs.Status" buttons="no" style="color:white"
                                               e-ng-true-value="1" e-ng-false-value="0" edit-disabled="['2','4','6'].indexOf(userProfile.Roles)>=0"
                                           onaftersave="updateField(cs.PostpaidID, 'Status', $data-0, true)"
                                               e-title="{{!(cs.Status==='1') ? 'Activate': 'Deactivate'}} this postpaid?"
                                           class="label" style="cursor:pointer;"
                                              ng-class="{'label-success': (cs.Status==='1'), 
                                                        'label-warning': (cs.Status==='0'),
                                                        'label-danger': (cs.Status==='2')}">
                                                {{(cs.Status-0) | postpaidStatus}}
                                        </a>
                                    </div>
								</td>
                                <td class="text-center">
                                    <span>
                                        <a ng-show="cs.Status==0" ng-click="CancelPostpaid(cs)"
                                           class="table-link danger" permission="[1,4,5]">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                            </span>
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

<div class="modal fade" id="myPostpaid" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container mywizard">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <form name="formAddPostpaid" ng-submit="addNewPostpaid()" novalidate="novalidate">
                    <div class="wizard-header">
                        <div class="h3">
                            <b>ADD NEW</b> POSTPAID SALES<br/>
                            <small ng-show="show_notif" ><br/>
                                <div class="alert" 
                                     ng-class="{'alert-danger': !response.status, 'alert-success': response.status}">
                                    <i class="fa fa-fw fa-lg"
                                       ng-class="{'fa-times-circle':!response.status, 'fa-check-circle':response.status}"></i>
                                    <strong>{{(response.status) ? 'Well done!':'Opppsss!'}}</strong> {{response.message}}.
                                </div>
                            </small>
                            <small ng-show="saving" ><br/>
                                <div class="alert alert-info" >
                                    <i class="fa fa-spinner fa-spin fa-fw" aria-hidden="true"></i> Saving...
                                </div>
                            </small>
                        </div>
                    </div>
                    <ul class="nav nav-pills ct-red">
                        <li class="active" style="width:100%"><a>Customer Information</a></li>
                    </ul>
                    <div class="tab-content clearfix">
                        <div class="active tab-pane" id="about">
                            <div class="row">
                                <div class="col-sm-11 col-sm-offset-1">
                                    <h4 class="info-text">Let's start with the basic information</h4>
                                    <div class="col-sm-11">
                                        <div class="form-group col-sm-6">
                                            <label for="InvoiceNo">SI Number</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" required="required" 
                                                       id="InvoiceNo" ng-model="postpaid.RefNo" 
                                                       ng-maxlength="20" ng-disabled="ValidSI"
                                                       placeholder="Validate SI" />
                                                <span class="input-group-btn" ng-show="ValidateSI">
                                                    <a class="btn btn-primary">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </a>
                                                </span>
                                                <span class="input-group-btn" ng-hide="ValidateSI">
                                                    <a class="btn btn-primary" ng-click="checkSI(postpaid.RefNo)">
                                                        <i class="fa"
                                                           ng-class="{'fa-check':(ValidSI==false), 'fa-times':(ValidSI==true)}"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label>ICCID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" required="required" 
                                                   ng-model="postpaid.ICCID"
                                                   ng-maxlength="30" ng-disabled="(ValidSI==ValidICC)"
                                                   placeholder="Validate ICCID" />
                                                <span class="input-group-btn" ng-show="ValidateICC">
                                                    <a class="btn btn-primary"
                                                       ng-disabled="!(ValidSI==true)">
                                                        <i class="fa fa-spin" ng-show="ValidateICC"></i>
                                                    </a>
                                                </span>
                                                <span class="input-group-btn" ng-hide="ValidateICC">
                                                    <a class="btn btn-primary" ng-click="checkICC(postpaid.ICCID)">
                                                        <i class="fa"
                                                           ng-class="{'fa-check':(ValidICC==false), 'fa-times':(ValidICC==true)}"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="form-group col-sm-4">
                                            <label for="CustLName">Last Name <small>(required)</small></label>
                                            <input type="text" class="form-control" required ng-disabled="!(ValidSI==true && ValidICC==true)"
                                                   ng-maxlength="20" ng-model="postpaid.LastName" placeholder="Dabu" />
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="CustFName">Given Name <small>(required)</small></label>
                                            <input type="text" class="form-control" required ng-disabled="!(ValidSI==true && ValidICC==true)"
                                                   ng-maxlength="30" ng-model="postpaid.FirstName" placeholder="Reggie" />
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="CustLName">Middle Name <small>(required)</small></label>
                                            <input type="text" class="form-control" required ng-disabled="!(ValidSI==true && ValidICC==true)"
                                                   ng-maxlength="20" ng-model="postpaid.MiddleName" placeholder="Dequin" />
                                        </div>
                                    </div>
                                    <div class="col-sm-11">
                                        <div class="form-group col-sm-4">
                                            <label for="CustEmail">Email</label>
                                            <input type="email" class="form-control" required ng-disabled="!(ValidSI==true && ValidICC==true)"
                                                   id="CustEmail" ng-model="postpaid.Email" ng-maxlength="50"
                                                   placeholder="customer@gmail.com.ph" />
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control" ng-maxlength=12
                                                   id="CustContact" required ng-disabled="!(ValidSI==true && ValidICC==true)"
                                                   ng-model="postpaid.ContactNo" placeholder="Contact No." />
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>SIM Card No.</label>
                                            <input type="text" class="form-control" ng-maxlength=12
                                                   id="CustContact" required ng-disabled="!(ValidSI==true && ValidICC==true)"
                                                   ng-model="postpaid.SimNo" placeholder="Sim Card No." />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-footer">
                        <div class="pull-right">
                            <button class="btn btn-success pull-right"
                                    ng-disabled="ValidSI!=ValidICC">
                                <i class="fa fa-plus-circle fa-lg"></i> Submit
                            </button>
                        </div>
                        <div class="pull-left">
                            <a data-dismiss="modal" ng-click="toggle=true"
                               style="margin-right:5px;"
                               class="btn btn-default">
                                <i class="fa fa-times-circle fa-lg"></i> Cancel
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/postpaid.js"></script>