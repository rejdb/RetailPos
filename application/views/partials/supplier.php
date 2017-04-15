<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="">Home</a></li>
                <li class="active"><span>Supplier</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Suppliers</h1>
                <div class="pull-right">
                    <button class="btn" ng-init="toggle=true"
                            ng-class="{'btn-primary':toggle,'btn-default':!toggle}"
                            data-toggle="modal" data-target="#mySupplier"
                            ng-click="toggle = !toggle">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                    <button ng-json-export-excel data="suppliers" report-fields="exportFields" filename ="'Supplier Master Data'" separator=","
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
								<th><span>Company Name</span></th>
                                <th><span>Contact No.</span></th>
                                <th><span>Email</span></th>
                                <th><span>Ship To</span></th>
								<th><span>Bill To</span></th>
								<th class="text-center"><span>Status</span></th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="sp in filtered = suppliers | orderBy:'+CoyName' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
									<img ng-src="/resources/img/avatar/store/tbx.png" alt="{{user.Avatar}}"/>
									<div class="popover-wrapper user-link">
                                        <a editable-text="sp.CoyName" buttons="no" e-ng-maxlength="50"
                                           onaftersave="updateField(sp.SuppID, 'CoyName', $data)">
                                            {{sp.CoyName}}
                                        </a>
                                    </div>
									<div class="user-subhead popover-wrapper">
                                        <a editable-text="sp.ContactPerson" buttons="no" e-ng-maxlength="50"
                                           onaftersave="updateField(sp.SuppID, 'ContactPerson', $data)" >
                                            {{sp.ContactPerson}}
                                        </a>
                                    </div>
								</td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-number="sp.ContactNo" e-ng-maxlength="15"
                                           onaftersave="updateField(sp.SuppID, 'ContactNo', $data)">
                                            {{sp.ContactNo}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="sp.Email" e-ng-maxlength="30"
                                           onaftersave="updateField(sp.SuppID, 'Email', $data)">
                                            {{sp.Email}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="sp.ShipTo" e-ng-maxlength="50"
                                           onaftersave="updateField(sp.SuppID, 'ShipTo', $data)">
                                            {{sp.ShipTo}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a editable-text="sp.BillTo" buttons="no" e-ng-maxlength="50"
                                           onaftersave="updateField(sp.SuppID, 'BillTo', $data-0)">
                                            {{ sp.BillTo }}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center" >
                                    <div class="popover-wrapper">
                                        <a editable-checkbox="sp.IsActive" buttons="no"
                                               e-ng-true-value="1" e-ng-false-value="0"
                                           onaftersave="updateField(sp.SuppID, 'IsActive', $data-0, true)"
                                               e-title="{{!(sp.IsActive==='1') ? 'Activate': 'Deactivate'}} this supplier?"
                                           class="label" style="cursor:pointer;"
                                              ng-class="{'label-success': (sp.IsActive==='1'), 
                                                        'label-default': (sp.IsActive==='0')}">
                                                {{(sp.IsActive==="1") ? 'Active': 'InActive'}}
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

<div class="modal fade" id="mySupplier" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container mywizard">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <form name="formAddSupp" ng-submit="addNewSupplier()" novalidate="novalidate">
                    <div class="wizard-header">
                        <div class="h3">
                            <b>ADD NEW</b> SUPPLIER<br/>
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
                        <li ng-click="onTabs(1)" class="active" style="width:50%"><a data-target="#about" data-toggle="tab">Supplier Information</a></li>
                        <li ng-click="onTabs(2)" class="" style="width:50%"><a data-target="#account" data-toggle="tab">Address</a></li>
                    </ul>
                    <div class="tab-content clearfix">
                        <div class="active tab-pane" id="about">
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <h4 class="info-text">Let's start with the basic information</h4>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-12">
                                            <label for="CoyName">Company Name</label>
                                            <input type="text" class="form-control" required="required" ng-maxlength="50"
                                                   id="CoyName" ng-model="supplier.CoyName" placeholder="Supplier" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label for="SuppCP">Contact Person</label>
                                            <input type="text" class="form-control" required="required" ng-maxlength="50"
                                                   id="SuppCP" ng-model="supplier.ContactPerson" placeholder="Point of Contact" />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="SuppCP">Contact No.</label>
                                            <input type="text" class="form-control" required="required" ng-maxlength="15"
                                                   id="SuppCP" ng-model="supplier.ContactNo" placeholder="Mobile No." />
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="SuppEmail" class="control-label">Email</label>
                                        <input type="email" id="SuppEmail" ng-model="supplier.Email" required
                                               class="form-control" placeholder="Email Address" ng-maxlength="50"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="account">
                            <div class="row clearfix">
                                <h4 class="col-xs-10 col-sm-offset-1">Set supplier Ship To Address</h4>
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group col-sm-12">
                                        <label for="SuppShipTo">Ship To</label>
                                        <textarea rows="3" class="form-control" id="SuppShipTo"
                                                  ng-maxlength="50" required="required"
                                                  ng-model="supplier.ShipTo"></textarea>
                                    </div>
                                </div>
                                <h4 class="col-xs-10 col-sm-offset-1">Set supplier Bill To Address.</h4>
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group col-sm-12">
                                        <label for="SuppBillTo">Bill To</label>
                                        <textarea rows="3" class="form-control" id="SuppBillTo"
                                                  ng-maxlength="50" required="required"
                                                  ng-model="supplier.BillTo"></textarea>
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

<script src="/resources/js/app/supplier.js"></script>