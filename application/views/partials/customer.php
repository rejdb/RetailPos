<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="">Home</a></li>
                <li class="active"><span>Customer</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Customers <small>CRM</small></h1>
                <div class="pull-right">
                    <button class="btn" ng-init="toggle=true"
                            ng-class="{'btn-primary':toggle,'btn-default':!toggle}"
                            data-toggle="modal" data-target="#myCustomers"
                            ng-click="toggle = !toggle">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                    <button ng-json-export-excel data="customers" report-fields="exportFields" filename ="'Customer Master Data'" separator=","
                            ng-show="userProfile.Roles!=4"
                            class="btn btn-info pull-right" style="margin-left:5px">
                        <i class="fa fa-external-link fa-lg"></i> CSV
                    </button>
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
								<th><span>Branch</span></th>
                                <th><span>Contact No.</span></th>
                                <th><span>Email</span></th>
                                <th><span>City</span></th>
                                <th><span>Province</span></th>
                                <th ng-hide="(userProfile.Roles==4)"><span>Points</span></th>
								<th ng-hide="(userProfile.Roles==4)"><span>Credits</span></th>
								<th class="text-center"><span>Action</span></th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="cs in filtered = customers | orderBy:'+CustFirstName' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
<!--									<img ng-src="/resources/img/avatar/agent/{{cs.Avatar}}" alt="{{cs.Avatar}}"/>-->
									<div>
                                        <a editable-text="cs.CustFirstName" buttons="no" 
                                           e-ng-maxlength="50" edit-disabled="cs.IsActive==1"
                                           onaftersave="updateField(cs.CustID, 'CustFirstName', $data)">
                                            {{cs.CustFirstName || 'First Name'}}
                                        </a> <a editable-text="cs.CustLastName" buttons="no" 
                                            e-ng-maxlength="50" edit-disabled="cs.IsActive==1"
                                           onaftersave="updateField(cs.CustID, 'CustLastName', $data)">
                                            {{cs.CustLastName || 'Surname'}}
                                        </a>
                                    </div>
									<div><small>
                                        <a editable-text="cs.Address" buttons="no" 
                                           e-ng-maxlength="50" edit-disabled="cs.IsActive==1"
                                           onaftersave="updateField(cs.CustID, 'Address', $data)" >
                                            {{cs.Address || 'Address'}}
                                        </a></small>
                                    </div>
                                    <div class="popover-wrapper"><small>
                                        <a editable-text="cs.CardNo" buttons="no" 
                                           e-ng-maxlength="20" edit-disabled="true"
                                           onaftersave="updateField(cs.CustID, 'CardNo', $data)" >
                                            Card No.: {{cs.CardNo}}
                                        </a></small>
                                    </div>
								</td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-select="cs.Branch" 
                                           edit-disabled="userProfile.Roles==4"
                                           onaftersave="updateField(cs.CustID, 'Branch', $data-0,true)"
                                           e-ng-options="s.BranchID as s.Description for s in branches">
                                            {{Filler(cs.Branch,'Branch')}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="cs.ContactNo" 
                                           e-ng-maxlength="15" edit-disabled="cs.IsActive==1"
                                           onaftersave="updateField(cs.CustID, 'ContactNo', $data)">
                                            {{cs.ContactNo || 'Mobile No.'}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="cs.CustEmail" 
                                           e-ng-maxlength="30" edit-disabled="cs.IsActive==1"
                                           onaftersave="updateField(cs.CustID, 'CustEmail', $data)">
                                            {{cs.CustEmail || 'Email'}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-select="cs.CustCity" edit-disabled="cs.IsActive==1"
                                           e-ng-options="s.CityID as s.City for s in lnk.cities"
                                           onaftersave="updateField(cs.CustID, 'CustCity', $data-0, true)">
                                            {{Filler(cs.CustCity,'CustCity')}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-select="cs.CustProvince" edit-disabled="cs.IsActive==1"
                                           e-ng-options="s.ProvinceID as s.Province for s in lnk.provinces"
                                           onaftersave="updateField(cs.CustID, 'CustProvince', $data-0, true)">
                                            {{Filler(cs.CustProvince,'CustProvince')}}
                                        </a>
                                    </div>
                                </td>
                                <td ng-hide="(userProfile.Roles==4)">
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-number="cs.CustPoints" e-ng-maxlength="10"
                                           edit-disabled="(userProfile.Roles==4)"
                                           onaftersave="updateField(cs.CustID, 'CustPoints', $data-0, true)">
                                            {{cs.CustPoints | peso:2}}
                                        </a>
                                    </div>
                                </td>
                                <td ng-hide="(userProfile.Roles==4)">
                                    <div class="popover-wrapper">
                                        <a editable-number="cs.CustCredits" buttons="no" e-ng-maxlength="10"
                                           edit-disabled="(userProfile.Roles==4)"
                                           onaftersave="updateField(cs.CustID, 'CustCredits', $data-0, true)">
                                            {{ cs.CustCredits | peso:2}}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center" >
                                    <div class="popover-wrapper">
                                        <a editable-checkbox="cs.IsActive" buttons="no"
                                           edit-disabled="cs.IsActive==1 && userProfile.Roles==4"
                                               e-ng-true-value="1" e-ng-false-value="0"
                                           onaftersave="updateField(cs.CustID, 'IsActive', $data-0, true)"
                                               e-title="{{!(cs.IsActive==='1') ? 'Activate': 'Deactivate'}} this customer?"
                                           class="label" style="cursor:pointer;"
                                              ng-class="{'label-success': (cs.IsActive==='1'), 
                                                        'label-default': (cs.IsActive==='0')}">
                                                {{(cs.IsActive==="1") ? 'Deactivate': 'Activate'}}
                                        </a>
                                    </div>
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

<div class="modal fade" id="myCustomers" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container mywizard">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <form name="formAddCust" ng-submit="addNewCustomer()" novalidate="novalidate">
                    <div class="wizard-header">
                        <div class="h3">
                            <b>ADD NEW</b> CUSTOMER<br/>
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
                        <li ng-click="onTabs(1)" class="active" style="width:50%"><a data-target="#about" data-toggle="tab">Customer Information</a></li>
                        <li ng-click="onTabs(2)" class="" style="width:50%"><a data-target="#account" data-toggle="tab">Customer Address &amp; Points</a></li>
                    </ul>
                    <div class="tab-content clearfix">
                        <div class="active tab-pane" id="about">
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
<!--                                    <h4 class="info-text">Let's start with the basic information</h4>-->
                                    <div class="col-sm-12 col-sm-offset-1">
                                        <div class="form-group col-sm-5">
                                            <label for="CustCardNo">Card Number</label>
                                            <input type="text" class="form-control" required="required" 
                                                   id="CustCardNo" ng-model="customer.CardNo" 
                                                   ng-maxlength="20"
                                                   placeholder="Card Number" />
                                        </div>
                                        <div class="form-group form-group-select2 col-sm-7">
                                            <label>Branch</label>
                                            <select class="form-control select"
                                                ng-model="customer.Branch">
                                                <option ng-repeat="b in branches"
                                                        value="{{b.BranchID}}">
                                                        {{b.Description}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-sm-offset-1">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <img src="/resources/img/avatar/agent/default.png" class="picture-src" id="wizardPicturePreview" title=""/>
                                                <input type="file" id="wizard-picture">
                                            </div>
                                            <h6>Choose Picture</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="CustFName">Given Name <small>(required)</small></label>
                                            <input type="text" class="form-control"
                                                   id="CustFName" ng-model="customer.CustFirstName" placeholder="Reggie" />
                                        </div>
                                        <div class="form-group">
                                            <label for="CustLName">Last Name <small>(required)</small></label>
                                            <input type="text" class="form-control"
                                                   id="CustLName" ng-model="customer.CustLastName" placeholder="Dabu" />
                                        </div>
                                    </div>
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="form-group col-sm-8">
                                            <label for="CustEmail">Email</label>
                                            <input type="email" class="form-control" 
                                                   id="CustEmail" ng-model="customer.CustEmail" 
                                                   placeholder="customer@gmail.com.ph" />
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="CustContact">Contact No.</label>
                                            <input type="text" class="form-control" 
                                                   id="CustContact" 
                                                   ng-model="customer.ContactNo" placeholder="Contact No." />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="account">
                            <div class="row clearfix">
                                <h4 class="col-xs-10 col-sm-offset-1">Where does this customer live?</h4>
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group col-xs-12">
                                        <label for="CustAddress">Street</label>
                                        <input type="text" class="form-control" id="CustAddress"
                                                  ng-maxlength="50"
                                                  ng-model="customer.Address"/>
                                    </div>
                                    <div class="row">
                                        <div class="form-group form-group-select2 col-xs-6">
                                            <label>City</label>
                                            <select class="form-control select"
                                                id="CustCity"
                                                ng-model="customer.CustCity">
                                                <option ng-repeat="city in lnk.cities"
                                                        value="{{city.CityID}}">
                                                        {{city.City}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group form-group-select2 col-xs-6">
                                            <label>Province</label>
                                            <select class="form-control select"
                                                id="CustProvince"
                                                ng-model="customer.CustProvince">
                                                <option ng-repeat="province in lnk.provinces"
                                                        value="{{province.ProvinceID}}">
                                                        {{province.Province}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="col-xs-10 col-sm-offset-1">Set customer initial points and credits if there is. <small>(Leave zero if none)</small></h4>
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group col-sm-6">
                                        <label for="CustPoints">Customer Points</label>
                                        <input type="number" id="CustPoints" class="form-control"
                                               ng-min="0" min="0" required="required"
                                               ng-model="customer.CustPoints" />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="CustCredits">Initial Credits</label>
                                        <input type="number" id="CustCredits" class="form-control"
                                               ng-min="0" min="0" required="required"
                                               ng-model="customer.CustCredits" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-footer">
                        <div class="pull-right">
                            <button ng-show="(tabSel>1)"
                                    class="btn btn-success pull-right">
                                <i class="fa fa-plus-circle fa-lg"></i> Submit
                            </button>
                            <a ng-show="!(tabSel>1)"
                                    ng-click="onNav('next')"
                                    class="btn btn-primary pull-right">
                                <i class="fa fa-chevron-circle-right fa-lg"></i> Next
                            </a>
                        </div>
                        <div class="pull-left">
                            <a ng-show="(tabSel>1)"
                                    ng-click="onNav('prev')"
                                    class="btn btn-primary pull-right">
                                <i class="fa fa-chevron-circle-left fa-lg"></i> Previous
                            </a>
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

<script src="/resources/js/app/customer.js"></script>