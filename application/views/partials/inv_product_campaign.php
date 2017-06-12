<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><span>Inventory</span></li>
                <li><span>Item Master Data</span></li>
                <li class="active"><span>Product Campaign</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Products Campaign <small>set special discount or promo on a specific period.</small></h1>
                <div class="pull-right top-page-ui">
                    <a class="btn" ng-model="toggle" 
                       ng-class="{'btn-primary':toggle,'btn-default':!toggle}"
                       btn-checkbox>
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </div>
            </div>
        </div>
 
        <div ng-show="notify" class="alert" 
             ng-class="{'alert-danger':error, 'alert-success':!error}">
            <button type="button" class="close" ng-click="notify = false">×</button>
            <i ng-show="!error" class="fa fa-check-circle fa-fw fa-lg"></i>
            <i ng-show="error" class="fa fa-times-circle fa-fw fa-lg"></i>
            <strong ng-show="!error">Well done!</strong><strong ng-show="error">Oh snap!</strong> {{message}}
        </div>

        <div collapse="!toggle">
            <div class="well well-lg">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group form-inline pull-left">
                            <label class="label-control" for="CampaignName">Campaign Name: </label>
                            <input type="text" id="CampaignName" 
                                   ng-model="campaign.title.CampaignName" ng-maxlength="50"
                                   class="form-control" />
                        </div>
                        <div class="pull-right">
                            <button ng-click="createCampaign()"
                                    class="btn btn-primary btn-xs pull-right">
                                <i class="fa fa-plus-circle"></i> Create Campaign
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="CampaingDateFrom">Date From</label>
                                    <div class="input-group">
                                        <input type="datetime" class="form-control" 
                                               id="CampaignDateFrom" 
                                               ng-model="campaign.title.DateFrom" 
                                               required="required"
                                               min="{{campaign.DateFrom}}"
                                               ng-min="{{campaign.DateFrom}}"
                                               readonly>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Date To</label>
                                    <div class="input-group">
                                        <input type="datetime" class="form-control" 
                                               id="CampaignDateTo" 
                                               ng-model="campaign.title.DateTo" 
                                               min={{campaign.DateFrom}}
                                               ng-min={{campaign.DateFrom}}
                                               readonly>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="table-responsive">
                                    <table class="table user-list table-hover">
                                        <thead>
                                            <tr>
                                                <th><small>Product Name</small></th>
                                                <th class="text-center"><small class="pull-left">Campaign Price</small>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="prd in campaign.products">
                                                <td><small><span editable-select="prd.PID" 
                                                          e-name="PID" 
                                                          e-form="rowform" 
                                                          e-ng-options="s.PID as s.ProductDesc for s in itemList"
                                                          e-required>
                                                      {{ Filler(prd.PID) }}
                                                    </span></small>
                                                </td>
                                                <td class="text-center">
                                                    <span editable-number="prd.SRP" 
                                                          e-name="SRP" 
                                                          e-form="rowform" 
                                                          e-required>
                                                      {{ prd.SRP | number:2 }}
                                                    </span>
                                                </td>
                                                <td class="text-center" style="white-space: nowrap">
                                                    <!-- form -->
                                                    <form editable-form name="rowform" 
                                                          ng-show="rowform.$visible" 
                                                          class="form-buttons form-inline" 
                                                          shown="inserted == prd">
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
                                                        <a href="" ng-click="removeListItem($index)"
                                                           class="table-link danger">
                                                            <span class="fa-stack">
                                                                <i class="fa fa-square fa-stack-2x"></i>
                                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        <button ng-click="addListItems()"
                                                class="btn btn-primary btn-xs pull-right">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="multipleSelectBranch" class="label-control">Select store affected by the campaign</label>
                                    <select name="multipleSelectBranch" id="multipleSelectBranch"
                                            ng-model="campaign.BranchID"  multiple="multiple" class="form-control"
                                            ng-options="brn.BranchID-0 as brn.Description for brn in brnList | filter:filter">
                                    </select>
                                </div>
                            </div>
                        </div>
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
								<th><span>Campaign Name</span></th>
                                <th class="text-left"><span>Branches</span></th>
                                <th class="text-left" style="width:30%"><span>Items</span></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in campaignList | orderBy:'-DateTo' | filter:find | DataFilter:(currentPage-1)*pageSize | limitTo:pageSize">
                                <td>
                                    <img ng-src="/resources/img/avatar/store/tbx.png" />
									<span class="popover-wrapper user-link">
                                        <a buttons="no"
                                           onaftersave="changeVal(b.BranchID, 'Description', this.$data)"
                                           editable-text="b.CampaignName" 
                                           e-title="Update Store Name">
                                            {{ b.CampaignName || 'Empty' }}
                                        </a>
                                    </span>
                                    <span class="popover-wrapper user-subhead">
                                        <a buttons="no" e-title="Sales Tax" 
                                           onaftersave="changeVal(b.BranchID, 'SalesTax', this.$data-0, true)"  
                                           editable-text="b.DateFrom" >{{b.DateFrom}}</a> - 
                                        <a buttons="no" e-title="Sales Tax" 
                                           onaftersave="changeVal(b.BranchID, 'SalesTax', this.$data-0, true)"  
                                           editable-text="b.DateTo" >{{b.DateTo}}</a>
                                    </span>
                                </td>
                                <td class="text-left">
                                    <div class="popover-wrapper">
                                        <a buttons="no"
                                           e-ng-options="s.BranchID as s.Description for s in brnList"
                                           editable-checklist="b.Stores">
                                            <ul>
                                                <li ng-repeat="br in showBranches(b)">{{br}}</li>
                                            </ul>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-left">
                                    <table class="table">
                                        <tr style="height:3px;" ng-repeat="pl in b.Products">
                                            <td style="width:80%;"><small>{{showItemCode(pl.PID)}}</small></td>
                                            <td><small>{{pl.SRP}}</small></td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 9%;">
                                    <a href="" class="table-link"
                                       ng-click="deleteCampaign(b.CampaignID)">
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
                        <pagination total-items="totalItems" max-size="10" ng-model="currentPage" items-per-page="pageSize"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/campaign.js"></script>