<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Branch</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Branches <small>setup and manage store</small></h1>
                
                <div class="pull-right top-page-ui">
                    <button ng-json-export-excel data="branches" report-fields="exportFields" filename ="'Branches'" separator=","
                            ng-show="userProfile.Roles!=4"
                            class="btn btn-info pull-right" style="margin-left:5px">
                        <i class="fa fa-external-link fa-lg"></i> CSV
                    </button>
                    <a href="#/Branches" class="btn btn-success pull-right" style="margin-left:5px" permission="[1]">
                        <i class="fa fa-plus-circle fa-lg"></i> New Branch
                    </a>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
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
								<th><span>Name</span></th>
                                <th class="text-center"><span>Contract Status</span></th>
								<th class="text-center"><span>Sales Tax</span></th>
                                <th class="text-center"><span>Return Policy</span></th>
                                <th class="text-center"><span>Price Include Tax?</span></th>
                                <th class="text-center"><span>Backdating?</span></th>
								<th class="text-center"><span>Active</span></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in filtered = branches | orderBy:'+Description' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
                                    <img ng-src="/resources/img/avatar/store/{{b.Avatar}}" alt="{{user.Avatar}}"/>
									<span class="popover-wrapper user-link">
                                        <a buttons="no"
                                           onaftersave="changeVal(b.BranchID, 'Description', this.$data)"
                                           editable-text="b.Description" 
                                           e-title="Update Store Name">
                                            {{ b.Description || 'Empty' }}
                                        </a>
                                    </span>
									<span class="user-subhead">
                                        <a buttons="no"
                                           onaftersave="changeVal(b.BranchID, 'BranchCode', this.$data)"
                                           editable-text="b.BranchCode" 
                                           e-title="Update Store Code">
                                            {{ b.BranchCode || 'Empty' }}
                                        </a>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="label"
                                          ng-class="{'label-warning':((b.Expiry | xpry_day)<=30 && (b.Expiry | xpry_day)>0),
                                                    'label-danger':(b.Expiry | xpry_day)<0,
                                                    'label-success':(b.Expiry | xpry_day)>30}">{{b.Expiry | expiry}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" e-title="Sales Tax" 
                                           onaftersave="changeVal(b.BranchID, 'SalesTax', this.$data-0, true)"  
                                           editable-text="b.SalesTax" >{{(b.SalesTax > 0) ? b.SalesTax + '%' : 'Not Set'}}</a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" onaftersave="changeVal(b.BranchID, 'DefaultReturnPolicy', this.$data-0, true)"  
                                           editable-text="b.DefaultReturnPolicy">{{(b.DefaultReturnPolicy > 0) ? b.DefaultReturnPolicy + ' Days' : 'Not Set'}}</a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" e-ng-true-value="1" e-ng-false-value="0"
                                           onaftersave="changeVal(b.BranchID, 'IsTaxInclude', this.$data-0, true)"
                                           editable-checkbox="b.IsTaxInclude" 
                                           e-title="{{!(b.IsTaxInclude==1) ? 'Include' : 'Exclude'}} Tax on Price?">
                                            {{ (b.IsTaxInclude==1) ? 'Enable':'Disable' }}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" e-ng-true-value="1" e-ng-false-value="0"
                                           onaftersave="changeVal(b.BranchID, 'IsBackdateAllowed', this.$data-0, true)"
                                           editable-checkbox="b.IsBackdateAllowed" 
                                           e-title="{{!(b.IsBackdateAllowed==1) ? 'Enable' : 'Disable'}} backdating on this branch?">
                                            {{ (b.IsBackdateAllowed==1) ? 'Allowed':'Not Allowed' }}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" e-ng-true-value="1" e-ng-false-value="0"
                                           onaftersave="changeVal(b.BranchID, 'IsActive', this.$data-0, true)"
                                           editable-checkbox="b.IsActive" 
                                           e-title="{{!(b.IsActive==1) ? 'Activate' : 'Deactivated'}} this branch?">
                                            {{ (b.IsActive==1) ? 'Yes':'No' }}
                                        </a>
                                    </div>
                                </td>
                                <td style="width: 14%;">
                                    <a href="" class="table-link"
                                       ng-click="setTarget(b)">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
									<a href="" 
                                       ng-click="showModal(b)"
                                       class="table-link">
										<span class="fa-stack">
											<i class="fa fa-square fa-stack-2x"></i>
											<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
										</span>
									</a>
                                    <a href="" 
                                       ng-click="showSeries(b)"
                                       class="table-link">
										<span class="fa-stack">
											<i class="fa fa-square fa-stack-2x"></i>
											<i class="fa fa-external-link fa-stack-1x fa-inverse"></i>
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

<div class="modal fade" id="editBranchData" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <div class="wizard-header">
                    <div class="h3">
                        <b>UPDATE</b> {{ branch.Description }}
                        <small><br/><a buttons="no"
                                       onaftersave="changeVal(b.BranchID, 'Address', this.$data)"
                                       editable-text="branch.Address" 
                                       e-title="Update Store Address">{{branch.Address}}</a>
                        </small>
                    </div>
                </div>
                <form ng-submit="updateBranch()" novalidate="novalidate">    
                    <div class="tab-content">
                        <div class="row">
                            <h4 class="info-text">Let's start updating the basic information</h4>
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="form-group col-sm-5">
                                    <label for="UserEmail">Email <small>(will be use as login account)</small></label>
                                    <input type="email" class="form-control" required="required" ng-model="branch.BranchEmail" placeholder="email@techbox.com.ph" />
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="UserEmail">Size <small>(SQM)</small></label>
                                    <input type="number" step="0.01" class="form-control" required="required" ng-model="branch.BranchSize" placeholder="0.00" />
                                </div>
                                <div class="form-group col-sm-5">
                                    <label for="UserEmail">Contract Expiration</label>
                                    <input type="date" class="form-control" required="required" ng-model="branch.Expiry" placeholder="Date" />
                                </div>
                            </div>
                            <div class="col-sm-3 col-sm-offset-1">
                                <div class="picture-container">
                                    <div class="picture">
                                        <img ng-src="/resources/img/avatar/store/{{branch.Avatar}}" class="picture-src" id="wizardPicturePreview" title=""/>
                                              <input type="file" id="wizard-picture">
                                    </div>
                                    <h6>Choose Picture</h6>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="StoreType">Store Type</label>
                                            <select class="form-control"
                                                    cast-to-integer="true"
                                                    ng-model="branch.Type"
                                                    required="required">
                                                <option ng-repeat="c in lnk.types"
                                                        value="{{c.TypeID}}">
                                                    {{c.TypeDesc}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="StoreChannel">Store Channel</label>
                                            <select class="form-control"
                                                    cast-to-integer="true"
                                                    ng-model="branch.Channel"
                                                    required="required">
                                                <option ng-repeat="c in lnk.channels"
                                                        value="{{c.ChannelID}}">
                                                    {{c.Channel}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="StoreCategory">Category</label>
                                            <select class="form-control"
                                                    cast-to-integer="true"
                                                    ng-model="branch.Category"
                                                    required="required">
                                                <option ng-repeat="c in lnk.categories"
                                                        value="{{c.CatID}}">
                                                    {{c.Category}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="StoreGroup">Store Group</label>
                                            <select class="form-control"
                                                    cast-to-integer="true"
                                                    ng-model="branch.Groups"
                                                    required="required">
                                                <option ng-repeat="c in lnk.groups"
                                                        value="{{c.GroupID}}">
                                                    {{c.Description}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group col-xs-12">
                                            <label for="BrnCity">What City?</label>
                                            <select class="form-control"
                                                    cast-to-integer="true"
                                                    ng-model="branch.City"
                                                    id="BrnCity"
                                                    required="required">
                                                <option ng-repeat="c in lnk.cities"
                                                        value="{{c.CityID}}">
                                                    {{c.City}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group col-xs-12">
                                            <label for="BrnManager">Area Manager</label>
                                            <select class="form-control"
                                                    cast-to-integer="true"
                                                    ng-model="branch.Manager"
                                                    required="required">
                                                <option ng-repeat="c in lnk.managers"
                                                        value="{{c.UID}}">
                                                    {{c.DisplayName}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-footer">
                        <div class="pull-right">
                            <button class="btn btn-primary pull-right">
                                <i class="fa fa-plus-circle fa-lg"></i> Submit
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="setTarget" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <div class="wizard-header">
                    <div class="h3">
                        <b>SET TARGET</b> {{ branch.Description }}
                        <small><br/>{{ branch.Address }}
                        </small>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="table-responsive col-sm-10 col-sm-offset-1">
                        <table class="table user-list table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center"><span>Month</span></th>
                                    <th class="text-center"><span>Target</span></th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="target in targets">
                                    <td class="text-center">
                                        <span editable-month="target.Month" 
                                              e-name="Month" 
                                              e-form="rowform" 
                                              e-required>
                                          {{ target.Month | date: "yyyy-MM" }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span editable-number="target.Target" 
                                              e-name="Target" 
                                              e-form="rowform" 
                                              e-required>
                                          {{ target.Target | number:2 }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="white-space: nowrap">
                                        <!-- form -->
                                        <form editable-form name="rowform" 
                                              onbeforesave="saveTarget($data)"
                                              ng-show="rowform.$visible" 
                                              class="form-buttons form-inline" 
                                              shown="inserted == target">
                                          <button type="submit" 
                                                  ng-disabled="rowform.$waiting" 
                                                  class="btn btn-primary">
                                                <i class="fa fa-check"></i>
                                          </button>
                                          <button type="button" 
                                                  ng-disabled="rowform.$waiting" 
                                                  ng-click="rowform.$cancel()" 
                                                  class="btn btn-default">
                                                <i class="fa fa-times"></i>
                                          </button>
                                        </form>
                                        <div class="buttons" ng-show="!rowform.$visible">
                                            <a href="" ng-click="rowform.$show()"
                                               class="table-link">
                                                <span class="fa-stack">
                                                    <i class="fa fa-square fa-stack-2x"></i>
                                                    <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                            <a href="" ng-click="removeTarget($index)"
                                               class="table-link danger">
                                                <span class="fa-stack">
                                                    <i class="fa fa-square fa-stack-2x"></i>
                                                    <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
<!--
                                          <button class="btn btn-primary" ng-click="rowform.$show()">edit</button>
                                          <button class="btn btn-danger" ng-click="removeUser($index)">del</button>
-->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="wizard-footer">
                    <div class="pull-right">
                        <button ng-click="addTarget()"
                                class="btn btn-primary pull-right">
                            <i class="fa fa-plus-circle fa-lg"></i> Add Target
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="setSeries" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                <h4 class="modal-title"><span>{{SetBranch}}</span></h4>
            </div>
            <div class="modal-body">
                <small ng-show="show_notif" ><br/>
                    <div class="alert" 
                         ng-class="{'alert-danger': !response.status, 'alert-success': response.status}">
                        <i class="fa fa-fw fa-lg"
                           ng-class="{'fa-times-circle':!response.status, 'fa-check-circle':response.status}"></i>
                        {{response.message}}.
                    </div>
                </small>
                <form name="form" ng-submit="updateSeries()" novalidate="novalidate">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Start Series</span>
                            <input type="number" class="form-control" 
                                   min=0 ng-min=0
                                   ng-model="series.Start"
                                   placeholder="Current password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Current Series</span>
                            <input type="number" class="form-control" 
                                   ng-maxlength=6 min=0 ng-min=0
                                   ng-model="series.Current" required
                                   placeholder="Current Series">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">End Series</span>
                            <input type="number" class="form-control" 
                                   ng-maxlength=6 min=0 ng-min=0
                                   ng-model="series.End" required
                                   placeholder="Confirm password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-success col-xs-12">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/branches.js"></script>