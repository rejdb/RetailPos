<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><span>Inventory</span></li>
                <li class="active"><span>Bill of Material</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Bill of Materials</h1>
                
                <div class="pull-right">
                    <a class="btn" ng-init="addBOM=true"
                       ng-class="{'btn-primary':addBOM, 'btn-default':!addBOM}"
                       ng-click="addBOM = !addBOM">
                        <i class="fa fa-plus-circle fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row" collapse="addBOM">
    <div class="col-lg-12 clearfix main-box">
        <header class="main-box-header clearfix">
            <div class="clearfix" style="padding-top:10px">
                <h4 class="pull-left">Create New Bill of Material</h4>
            </div><hr/>
        </header>
        <div class="main-box-body clearfix">
            <form novalidate="novalidate" ng-submit="addNewBoM()" name="bomBomForm">
                <div class="pull-right" style="position:absolute; top: 0; left:calc(90% - 50px); padding-top:20px">
                    <button class="btn btn-primary">
                        <i class="fa fa-plus-circle fa-lg"></i> Create BoM
                    </button>
                </div>    
                <div class="col-sm-5">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="bomID" class="label-control">BOM ID</label>
                            <input type="text" id="bomID" class="form-control" 
                                   ng-maxlength="15" required
                                   placeholder="Enter Kit Barcode"
                                   ng-model="material.bom.BoMBarCode" />
                        </div>
                        <div class="form-group col-sm-8">
                            <label for="bomName" class="label-control">BOM Name</label>
                            <input type="text" id="bomName" class="form-control" 
                                   ng-maxlength="30" required
                                   placeholder="Enter Kit Name"
                                   ng-model="material.bom.BoMName" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="bomCost" class="label-control">Cost</label>
                            <input type="number" id="bomCost" class="form-control" 
                                   ng-min=0 min=0 required
                                   placeholder="Enter BoM Cost"
                                   ng-model="material.bom.BoMCost" />
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="bomSRP" class="label-control">SRP</label>
                            <input type="number" id="bomSRP" class="form-control" 
                                   ng-min=0 min=0 required
                                   placeholder="Enter BoM SRP"
                                   ng-model="material.bom.BoMSRP" />
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-sm-7">
                <div class="table-responsive">
                    <table class="table user-list table-hover">
                        <thead>
                            <tr>
                                <th><small>Product</small></th>
                                <th class="text-center"><small class="pull-left">Warehouse</small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="prd in material.Products">
                                <td><small><span editable-select="prd.PID"
                                          e-name="PID" 
                                          e-form="rowform" 
                                          e-ng-options="s.PID as s.ProductDesc for s in itemList"
                                          e-required="required">
                                      {{ Filler(prd.PID) }}
                                    </span></small>
                                </td>
                                <td class="text-center">
                                    <span editable-select="prd.WhsCode" 
                                          e-name="WhsCode" 
                                          e-form="rowform" 
                                          e-ng-options="w.WhsCode as w.WhsName for w in whsList"
                                          e-required="required">
                                      {{ FillerWhs(prd.WhsCode)}}
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
								<th><span>BoM Name</span></th>
                                <th class="text-left"><span>Cost <small>(VATEX)</small></span></th>
                                <th class="text-left"><span>SRP <small>(VATEX)</small></span></th>
                                <th class="text-left">Status</th>
                                <th class="text-left" style="width:50%"><span>Items</span></th>
							</tr>
						</thead>
                        <tbody>
                            <tr ng-repeat="b in BoMs | orderBy:'+BoMName' | filter:find | DataFilter:(currentPage-1)*pageSize | limitTo:pageSize">
                                <td>
                                    <img ng-src="/resources/img/avatar/store/tbx.png" />
									<span class="popover-wrapper user-link">
                                        <a buttons="no"
                                           onaftersave="changeVal(b.BoMID, 'BoMName', this.$data)"
                                           editable-text="b.BoMName" 
                                           e-title="Update BoM Name">
                                            {{ b.BoMName || 'Empty' }}
                                        </a>
                                    </span>
                                    <span class="popover-wrapper user-subhead">
                                        <a buttons="no" e-title="Sales Tax" 
                                           onaftersave="changeVal(b.BoMID, 'BoMBarCode', this.$data, true)"  
                                           editable-number="b.BoMBarCode" >{{b.BoMBarCode}}</a>
                                    </span>
                                </td>
                                <td>
                                    <div class="popover-wrapper">
                                        <a buttons="no" e-title="Sales Tax" 
                                           onaftersave="changeVal(b.BoMID, 'BoMCost', this.$data, true)"  
                                           editable-number="b.BoMCost" >{{b.BoMCost | peso:2}}</a>
                                    </div>
                                </td>
                                <td class="text-left">
                                    <div class="popover-wrapper">
                                        <a buttons="no"
                                           onaftersave="changeVal(b.BoMID, 'BoMSRP', this.$data, true)"  
                                           editable-number="b.BoMSRP">{{b.BoMSRP | peso:2}}
                                        </a>
                                    </div>
                                </td>
                                <td><div class="popover-wrapper">
                                    <a editable-checkbox="b.IsActive"
                                       buttons="no" class="label"
                                       onaftersave="changeVal(b.BoMID, 'IsActive', this.$data-0, true)"
                                       e-ng-true-value="1" e-ng-false-value="0"
                                       e-title="{{(b.IsActive=='1') ? 'Deactivate':'Activate'}} this bundle?"
                                       ng-class="{'label-success':(b.IsActive==1),'label-default':(b.IsActive=='0')}">
                                        {{(b.IsActive=='1') ? 'Active':'InActive'}}</a>
                                    </div>
                                </td>
                                <td class="text-left">
                                    <table class="table">
                                        <tr style="height:3px;" ng-repeat="pl in b.BoMProducts">
                                            <td style="width:60%;">
                                                <small class="popover-wrapper">
                                                    <a editable-select="pl.PID" buttons="no"
                                                       onaftersave="changeValItem(pl.BoMSID, 'PID', $data-0, true)"
                                                       e-ng-options="i.PID as i.ProductDesc for i in itemList">
                                                    {{Filler(pl.PID)}}</a>
                                                </small>
                                            </td>
                                            <td>
                                                <small class="popover-wrapper">
                                                    <a editable-select="pl.WhsCode" buttons="no"
                                                       onaftersave="changeValItem(pl.BoMSID, 'WhsCode', $data-0,true)"
                                                       e-ng-options="i.WhsCode as i.WhsName for i in whsList">
                                                    {{FillerWhs(pl.WhsCode)}}</a>
                                                </small>
                                            </td>
<!--
                                            <td><a class="table-link"
                                                   ng-click="removeBoMListItem(pl.BoMSID)">
                                                    <span class="fa-stack">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                </a>
                                            </td>
-->
                                        </tr>
                                    </table>
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

<script src="/resources/js/app/bom.js"></script>