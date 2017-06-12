<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><span>Employee</span></li>
                <li class="active"><span>Store Frontliner</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">FrontLiners <small>manage store employees</small></h1>
                
                <div class="pull-right top-page-ui">
                    <button data-toggle="modal" data-target="#myFrontLiner" 
                       class="btn btn-primary pull-right">
                        <i class="fa fa-plus-circle fa-lg"></i> Add frontliner
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
								<th><span>Display Name</span></th>
                                <th><span>Given Name</span></th>
                                <th><span>Family Name</span></th>
								<th><span>Target</span></th>
                                <th><span>Branch</span></th>
								<th class="text-center"><span>Status</span></th>
								<th><span>Last Login</span></th>
								<th class="text-center">&nbsp;</th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="user in filtered = users | orderBy:'+DisplayName' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
									<img ng-src="/resources/img/avatar/agent/{{user.Avatar}}" alt="{{user.Avatar}}"/>
									<div class="popover-wrapper user-link">
                                        <a editable-text="user.DisplayName" 
                                           onaftersave="updateUser(user.UID, 'DisplayName', $data)"
                                           buttons="no">{{user.DisplayName}}</a>
                                    </div>
									<div class="user-subhead popover-wrapper">
                                        <a editable-text="user.Email" 
                                           onaftersave="updateUser(user.UID, 'Email', $data)" 
                                           buttons="no">{{user.Email}}</a>
                                    </div>
								</td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="user.FirstName"
                                           onaftersave="updateUser(user.UID, 'FirstName', $data)">
                                            {{user.FirstName}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-text="user.LastName"
                                           onaftersave="updateUser(user.UID, 'LastName', $data)">
                                            {{user.LastName}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a editable-text="user.Target" buttons="no"
                                           onaftersave="updateIntFl(user.UsrTargetID, 'Target', ($data-0))" 
                                           e-title="Set Target">{{ user.Target | peso:2 }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a editable-select="user.BranchID" buttons="no" 
                                           onaftersave="updateIntFl(user.UserBranchID, 'BranchID', $data-0)"
                                           e-ng-options="s.BranchID as s.Description for s in branches">
                                            {{ repeatFiller(user.BranchID) }}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center" >
                                    <div class="popover-wrapper">
                                        <a editable-checkbox="user.IsActive" buttons="no"
                                               e-ng-true-value="1" e-ng-false-value="0"
                                           onaftersave="updateUser(user.UID, 'IsActive', $data-0, true)"
                                               e-title="{{!(user.IsActive==='1') ? 'Activate': 'Deactivate'}} this user?"
                                           class="label" style="cursor:pointer;"
                                              ng-class="{'label-success': (user.IsActive==='1'), 
                                                        'label-default': (user.IsActive==='0')}">
                                                {{(user.IsActive==="1") ? 'Active': 'InActive'}}
                                        </a>
                                    </div>
								</td>
                                <td><span>{{ user.LastLogin | dateFilter:'yyyy-MM-dd HH:mma'}}</span></td>
                                <td style="width: 8%;">
									<a ng-click="changePwd(user.UID-0)" class="table-link">
										<span class="fa-stack">
											<i class="fa fa-square fa-stack-2x"></i>
											<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
										</span>
									</a>
								</td>
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

<div class="modal fade" id="myFrontLiner" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container mywizard">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <form ng-submit="addFrontliner()" novalidate="novalidate">
                    <div class="wizard-header">
                        <div class="h3">
                            <b>ADD NEW</b> STORE PERSONNEL<br/>
                            <small ng-show="notify" ><br/>
                                <div class="alert" 
                                     ng-class="{'alert-danger': !response.success, 'alert-success': response.success}">
                                    <i class="fa fa-fw fa-lg"
                                       ng-class="{'fa-times-circle':!response.success, 'fa-check-circle':response.success}"></i><strong>{{(response.success) ? 'Well done!':'Opppsss!'}}</strong> {{response.message}}.
                                </div>
                            </small>
                        </div>
                    </div>
                    <ul class="nav nav-pills ct-red">
                        <li ng-click="onTabs(1)" class="active" style="width:50%"><a data-target="#about" data-toggle="tab">Personal Info</a></li>
                        <li ng-click="onTabs(2)" class="" style="width:50%"><a data-target="#account" data-toggle="tab">Account</a></li>
                    </ul>
                    <div class="tab-content clearfix">
                        <div class="active tab-pane" id="about">
                            <div class="row">
                                <h4 class="info-text">Let's start with the basic information</h4>
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
                                        <label for="UserFName">Given Name <small>(required)</small></label>
                                        <input type="text" class="form-control" required="required" 
                                               id="UserFName" ng-model="user.FirstName" placeholder="Reggie" />
                                    </div>
                                    <div class="form-group">
                                        <label for="UserLName">Last Name <small>(required)</small></label>
                                        <input type="text" class="form-control" required="required" 
                                               id="UserLName" ng-model="user.LastName" placeholder="Dabu" />
                                    </div>
                                </div>
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group col-sm-8">
                                        <label for="UserEmail">Email <small>(will be use as login account)</small></label>
                                        <input type="email" class="form-control" required="required" id="UserEmail" ng-model="user.Email" placeholder="email@techbox.com.ph" />
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="UserContact">Contact No.</label>
                                        <input type="text" class="form-control" required="required" id="UserContact" ng-model="user.ContactNo" placeholder="Contact No." />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="account">
                            <div class="row clearfix">
                                <h4 class="col-xs-10 col-sm-offset-2">Select store where do you want this user to be deployed.</h4>
                                <div class="col-xs-8 col-sm-offset-2 clearfix">
                                    <div class="form-group form-group-select2">
                                        <label>Assign Store <small>(required)</small></label>
                                        <select class="form-control select"
                                                cast-to-integer="true"
                                                ng-model="fl.BranchID"
                                                required="required">
                                            <option ng-repeat="b in branches | orderBy:'+Description'" value="{{b.BranchID}}">{{b.Description}}</option>
                                        </select>
                                    </div>
                                </div>
                                <h4 class="col-xs-8 col-sm-offset-2">Set monthly target to measure performance.</h4>
                                <div class="col-xs-8 col-sm-offset-2 clearfix">
                                    <div class="form-group">
                                        <label for="SetTarget">Monthly Target <small>(required)</small></label>
                                        <input type="number" 
                                               ng-maxlength=10 
                                               ng-min=10000 
                                               ng-max=1000000 
                                               min=10000 max=1000000 
                                               class="form-control" 
                                               required="required" 
                                               id="SetTarget" ng-model="fl.Target" />
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
                            <a data-dismiss="modal"
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


<script src="/resources/js/app/frontliner.js"></script>