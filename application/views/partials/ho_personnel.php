<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><span>Employee</span></li>
                <li class="active"><span>Head Office Employee</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Head Office Employees <small>manage head office accounts</small></h1>
                
                <div class="pull-right top-page-ui">
                    <a data-toggle="modal" data-target="#myPersonnel"
                       class="btn btn-primary pull-right">
                        <i class="fa fa-plus-circle fa-lg"></i> Add peronnel
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
								<th><span>Display Name</span></th>
                                <th><span>Given Name</span></th>
                                <th><span>Family Name</span></th>
								<th><span>Created</span></th>
                                <th><span>Last Login</span></th>
								<th class="text-center"><span>Status</span></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="user in filtered = users | orderBy:'+DisplayName' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
									<img ng-src="/resources/img/avatar/agent/{{user.Avatar}}" alt="{{user.Avatar}}"/>
									<div class="popover-wrapper user-link">
                                        <a buttons="no" 
                                           onaftersave="updateUser(user.UID, 'DisplayName', $data)"
                                           editable-text="user.DisplayName">
                                            {{user.DisplayName}}
                                        </a>
                                    </div>
									<div class="user-subhead popover-wrapper">
                                        <a buttons="no" 
                                           onaftersave="updateUser(user.UID, 'Email', $data)"
                                           editable-text="user.Email">
                                            {{user.Email}}
                                        </a>
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
                                <td>{{ user.CreateDate | dateFilter:'yyyy-MM-dd'}}</td>
                                <td>{{ user.LastLogin | dateFilter:'yyyy-MM-dd HH:mma'}}</td>
                                <td class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-checkbox="user.IsActive"
                                           e-ng-true-value="1" e-ng-false-value="0"
                                           e-title="{{(user.IsActive==='1') ? 'Deactivated':'Activate'}} this user?"
                                           onaftersave="updateUser(user.UID, 'IsActive', $data-0, true)"
                                           class="label"
                                           ng-class="{'label-success': (user.IsActive==='1'), 
                                                        'label-default': (user.IsActive==='0')}">
                                            {{(user.IsActive==="1") ? 'Active': 'InActive'}}
                                        </a>
                                    </div>
								</td>
                                <td style="width: 10%;">
									<a ng-click="resetPwd(user.UID)" class="table-link">
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

<div class="modal fade" id="myPersonnel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <form ng-submit="addHOPersonnel()" novalidate="novalidate">
                    <div class="wizard-header">
                        <div class="h3">
                            <b>ADD NEW</b> HEAD OFFICE USER
                            <small ng-show="error"><br/><br/>
                                <div class="alert alert-danger">
                                    <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                    <strong>Opppsss!</strong> {{err_msg}}.
                                </div>
                            </small>
                        </div>
                    </div>
                    
                    <div class="tab-content">
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
                                    <input type="text" class="form-control" required="required" id="UserFName" ng-model="user.FirstName" placeholder="Reggie" />
                                </div>
                                <div class="form-group">
                                    <label for="UserLName">Last Name <small>(required)</small></label>
                                    <input type="text" class="form-control" required="required" id="UserLName" ng-model="user.LastName" placeholder="Dabu" />
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="form-group">
                                    <label for="UserEmail">Email <small>(will be use as login account)</small></label>
                                    <input type="email" class="form-control" required="required" id="UserEmail" ng-model="user.Email" placeholder="email@techbox.com.ph" />
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

<script src="/resources/js/app/ho_personnel.js"></script>