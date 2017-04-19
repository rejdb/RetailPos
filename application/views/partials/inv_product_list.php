<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><span>Inventory</span></li>
                <li><span>Item Master Data</span></li>
                <li class="active"><span>Product List</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Products</h1>
                
                <div class="pull-right top-page-ui">
                    <button ng-json-export-excel data="items" report-fields="exportFields" filename ="'Product Lists'" separator=","
                            ng-show="userProfile.Roles!=4"
                            class="btn btn-info pull-right" style="margin-left:5px">
                        <i class="fa fa-external-link fa-lg"></i> CSV
                    </button>
                    <a href="" class="btn btn-primary pull-right" style="margin-left:5px" permission="[1,5]"
                       data-toggle="modal" data-target="#addNewItemData">
                        <i class="fa fa-plus-circle fa-lg"></i> Add Item
                    </a>
                    <button class="btn" ng-init="collapse=true" permission="[1,5]" ng-click="collapse = !collapse"
                            ng-class="{'btn-default': !collapse, 'btn-primary': collapse}">
                        <i class="fa fa-pencil fa-lg"></i> References</button>
                </div>
            </div>
        </div>
	</div>
</div>

<div id="timeline-grid" collapse="collapse">
    <div class="item main-box">
        <header class="main-box-header clearfix">
            <div class="pull-left"><h2>Brands</h2></div>
            <span class="pull-right" permission="[1]">
                <a editable-text="Brnd" buttons="no" e-placeholder="Add New Brand" e-required="required" e-maxlength="30"
                    onaftersave="addItemReference('ref_item_brand', $data)">Add Brand</a>
            </span>
        </header>
        <div class="main-box-body clearfix" style="padding:0px 20px;">
            <div class="input-group pull-right clearfix" style="width:50%; margin-bottom:10px;">
                <span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></span>
                <input type="text" placeholder="Search..." class="form-control" ng-model="brnFind" />
            </div>
            <ul style="margin-bottom:20px">
                <li ng-repeat="t in lnk.brands | filter:brnFind | DataFilter:(brnCurrentPage-1) * 10 | limitTo:10">
                    <td><a editable-text="t.Description" style="font-size:10px;"
                            onbeforesave="updateItemReference({BrandID: t.BrandID}, 'ref_item_brand', $data)">{{t.Description}}</a></td>
                </li>
            </ul>
            <div class="pull-right">
                <pagination total-items="lnk.brands.length" max-size="3" ng-model="brnCurrentPage" items-per-page="10"></pagination>
            </div>
        </div>
    </div>
    <div class="item main-box">
        <header class="main-box-header clearfix">
            <div class="pull-left"><h2>NetSuite Brands</h2></div>
            <span class="pull-right" permission="[1]">
                <a editable-text="NSBrand" buttons="no" e-placeholder="Add New NS Brand" e-required="required" e-maxlength="30"
                    onaftersave="addItemReference('ref_item_family', $data)">Add NS Brand</a>
            </span>
        </header>
        <div class="main-box-body clearfix" style="padding:0px 20px;">
            <div class="input-group pull-right clearfix" style="width:50%; margin-bottom:10px;">
                <span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></span>
                <input type="text" placeholder="Search..." class="form-control" ng-model="brnNSFind" />
            </div>
            <ul style="margin-bottom:20px">
                <li ng-repeat="t in lnk.families | filter:brnNSFind | DataFilter:(famCurrentPage-1) * 10 | limitTo:10">
                    <a editable-text="t.Description" style="font-size:10px;"
                            onbeforesave="updateItemReference({FamID: t.FamID}, 'ref_item_family', $data)">{{t.Description}}</a>
                </li>
            </ul>
            <div class="pull-right">
                <pagination total-items="lnk.families.length" max-size="3" ng-model="famCurrentPage" items-per-page="10"></pagination>
            </div>
        </div>
    </div>
    <div class="item main-box">
        <header class="main-box-header clearfix">
            <div class="pull-left"><h2>Pricelists</h2></div>
            <span class="pull-right" permission="[1]">
                <a buttons="no" editable-text="PrList" buttons="no" e-placeholder="Add New Price List Name" e-required="required" e-maxlength="50"
                    onaftersave="addItemReference('stp_item_pricelist', $data)">Add Pricelist</a>
            </span>
        </header>
        <div class="main-box-body clearfix" style="padding:0px 20px;">
            <div class="input-group pull-right clearfix" style="width:50%; margin-bottom:10px;">
                <span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></span>
                <input type="text" placeholder="Search..." class="form-control" ng-model="priceFind" />
            </div>
            <ul style="margin-bottom:20px">
                <li ng-repeat="t in lnk.pricelists | filter:priceFind | DataFilter:(priceCurrentPage-1) * 10 | limitTo:10">
                    <a editable-text="t.Description" style="font-size:10px;"
                            onbeforesave="updateItemReference({PLID: t.PLID}, 'ref_item_family', $data)">{{t.Description}}</a>
                </li>
            </ul>
            <div class="pull-right">
                <pagination total-items="lnk.pricelists.length" max-size="3" ng-model="priceCurrentPage" items-per-page="10"></pagination>
            </div>
        </div>
    </div>
    <div class="item main-box">
        <header class="main-box-header clearfix">
            <div class="pull-left"><h2>Life Cycle</h2></div>
            <span class="pull-right" permission="[1]">
                <a editable-text="LCycle" buttons="no" e-placeholder="Add New Life Cycle" e-required="required" e-maxlength="30"
                    onaftersave="addItemReference('ref_item_cycle', $data)">Add Life Cycle</a>
            </span>
        </header>
        <div class="main-box-body clearfix" style="padding:0px 20px;">
            <div class="input-group pull-right clearfix" style="width:50%; margin-bottom:10px;">
                <span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></span>
                <input type="text" placeholder="Search..." class="form-control" ng-model="cycleFind" />
            </div>
            <ul style="margin-bottom:20px">
                <li ng-repeat="t in lnk.cycles | filter:cycleFind | DataFilter:(cycleCurrentPage-1) * 10 | limitTo:10">
                    <a editable-text="t.Description" style="font-size:10px;"
                            onbeforesave="updateItemReference({P_CycleID: t.P_CycleID}, 'ref_item_cycle', $data)">{{t.Description}}</a>
                </li>
            </ul>
            <div class="pull-right">
                <pagination total-items="lnk.cycles.length" max-size="3" ng-model="cycleCurrentPage" items-per-page="10"></pagination>
            </div>
        </div>
    </div>
    <div class="item main-box">
        <header class="main-box-header clearfix">
            <div class="pull-left"><h2>Category</h2></div>
            <span class="pull-right" permission="[1]">
                <a editable-text="Cat" buttons="no" e-placeholder="Add New Category" e-required="required" e-maxlength="30"
                    onaftersave="addItemReference('ref_item_category', $data)">Add Category</a>
            </span>
        </header>
        <div class="main-box-body clearfix" style="padding:0px 20px;">
            <div class="input-group pull-right clearfix" style="width:50%; margin-bottom:10px;">
                <span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></span>
                <input type="text" placeholder="Search..." class="form-control" ng-model="catFind" />
            </div>
            <ul style="margin-bottom:20px">
                <li ng-repeat="t in lnk.categories | filter:catFind | DataFilter:(catCurrentPage-1) * 10 | limitTo:10">
                    <a editable-text="t.Description" style="font-size:10px;"
                            onbeforesave="updateItemReference({P_CatID: t.P_CatID}, 'ref_item_category', $data)">{{t.Description}}</a>
                </li>
            </ul>
            <div class="pull-right">
                <pagination total-items="lnk.categories.length" max-size="3" ng-model="catCurrentPage" items-per-page="10"></pagination>
            </div>
        </div>
    </div>
    <div class="item main-box">
        <header class="main-box-header clearfix">
            <div class="pull-left"><h2>Item Types</h2></div>
            <span class="pull-right" permission="[1]">
                <a editable-text="ItemType" buttons="no" e-placeholder="Add New Item Type" e-required="required" e-maxlength="30"
                    onaftersave="addItemReference('ref_item_type', $data)">Add Type</a>
            </span>
        </header>
        <div class="main-box-body clearfix" style="padding:0px 20px;">
            <div class="input-group pull-right clearfix" style="width:50%; margin-bottom:10px;">
                <span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></span>
                <input type="text" placeholder="Search..." class="form-control" ng-model="typeFind" />
            </div>
            <ul style="margin-bottom:20px">
                <li ng-repeat="t in lnk.types | filter:typeFind | DataFilter:(typeCurrentPage-1) * 10 | limitTo:10">
                    <a editable-text="t.Description" style="font-size:10px;"
                            onbeforesave="updateItemReference({TypeID: t.TypeID}, 'ref_item_type', $data)">{{t.Description}}</a>
                </li>
            </ul>
            <div class="pull-right">
                <pagination total-items="lnk.types.length" max-size="3" ng-model="typeCurrentPage" items-per-page="10"></pagination>
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
                        <option value="500">500 per page</option>
                        <option value="1000">1000 per page</option>
                    </select>
                    <span class="pull-left"><input type="text" class="form-control" ng-model="find" placeholder="Search..." /></span>
                </div>
                <button class="btn btn-success pull-right" permission="[1,5]"
                        style="margin-right:5px;" ng-model="toggle" btn-checkbox>
                    <i class="fa" ng-class="{'fa-arrow-left':!toggle, 'fa-arrow-right':toggle}"></i> {{(toggle) ? "Hide":"Show More"}}
                </button>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <table class="table user-list table-hover">
                        <thead>
							<tr>
								<th style="width:30%"><span>Name</span></th>
                                <th ng-cloak ng-hide="toggle" class="text-center"><span>Order Level</span></th>
                                <th ng-cloak ng-hide="toggle" class="text-center"><span>Cost <small>(Vat-Ex)</small></span></th>
                                <th ng-cloak ng-hide="toggle" class="text-center"><span>SRP <small>(Vat-Ex)</small></span></th>
                                <th ng-cloak ng-show="toggle" class="text-center"><span>Type</span></th>
                                <th ng-cloak ng-show="toggle" class="text-center"><span>Category</span></th>
								<th ng-cloak ng-show="toggle" class="text-center"><span>Brand</span></th>
								<th ng-cloak ng-show="toggle" class="text-center"><span>Life Cycle</span></th>
								<th ng-cloak ng-show="toggle" class="text-center"><span>NS Brand</span></th>
								<th ng-cloak ng-hide="toggle" class="text-center"><span>Price List</span></th>
                                <!--<th class="text-center"><span>Inventory</span></th>-->
                                <th ng-cloak ng-show="toggle" class="text-center"><span>Serialized?</span></th>
                                <th class="text-center"><span>Status</span></th>
							</tr>
						</thead>
                        <tbody class="register">
                            <tr ng-init="itemLoader=true" ng-show="itemLoader">
                                <td colspan="6">
                                    <div class="inputspinner">
                                        <div class="rect1"></div>
                                        <div class="rect2"></div>
                                        <div class="rect3"></div>
                                        <div class="rect4"></div>
                                        <div class="rect5"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr ng-repeat="item in filtered = items | orderBy:'+ProductDesc' | filter:find | DataFilter:(currentPage-1) * pageSize | limitTo:pageSize">
                                <td>
<!--									<img src="/resources/img/avatar/products/default_product.jpeg" alt=""/>-->
									<div class="popover-wrapper">
                                        <a buttons="no" editable-text="item.ProductDesc" e-required="required" e-maxlength="50"
                                            edit-disabled="userProfile.Roles!=1"
                                           onaftersave="updateItem(item.PID, 'ProductDesc', $data)"
                                           >{{item.ProductDesc}}</a>
                                    </div><br/>
                                    <div class="popover-wrapper user-subhead">
                                        <a editable-text="bcode" edit-disabled="true">[{{item.BarCode}}] -</a>
                                        <a buttons="no" editable-text="item.SKU" e-required="required" e-maxlength="50"
                                           edit-disabled="userProfile.Roles!=1"
                                           onaftersave="updateItem(item.PID, 'SKU', $data)"
                                           >{{item.SKU}}</a>
                                    </div>
								</td>
                                <td ng-cloak ng-hide="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-number="item.OrderLevel" e-required="required" e-maxlength="10"
                                           edit-disabled="userProfile.Roles!=1"
                                           onaftersave="updateItem(item.PID, 'OrderLevel', $data, true)">
                                            {{item.OrderLevel | number:0}}</a>
                                    </div>
                                </td>
                                <td ng-cloak ng-hide="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-number="item.StdCost"  e-required="required" e-maxlength="18"
                                           edit-disabled="(userProfile.Roles!=6 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'StdCost', $data, true)">
                                            {{item.StdCost | peso:2}}</a>
                                    </div>
                                </td>
                                <td ng-cloak ng-hide="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a buttons="no" editable-number="item.CurrentPrice"  e-required="required" e-maxlength="18"
                                           edit-disabled="(userProfile.Roles!=6 && userProfile.Roles!=1)"
                                           onaftersave="updateSRP(item.PDID, 'Price', $data-0)">
                                            {{item.CurrentPrice | peso:2}}</a>
                                    </div>
                                </td>
                                <td ng-cloak ng-show="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-select="item.ItemType" buttons="no" 
                                           edit-disabled="(userProfile.Roles!=5 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'ItemType', $data-0, true)"
                                           e-ng-options="s.TypeID as s.Description for s in lnk.types">
                                            {{ Filler('type',item.ItemType) }}
                                        </a>
                                    </div>
                                </td>
                                <td ng-cloak ng-show="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-select="item.Category" buttons="no" 
                                           edit-disabled="(userProfile.Roles!=5 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'Category', $data-0, true)"
                                           e-ng-options="s.P_CatID as s.Description for s in lnk.categories">
                                            {{ Filler('category',item.Category) }}
                                        </a>
                                    </div>
                                </td>
                                <td ng-cloak ng-show="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-select="item.Brand" buttons="no" 
                                           edit-disabled="(userProfile.Roles!=5 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'Brand', $data-0, true)"
                                           e-ng-options="s.BrandID as s.Description for s in lnk.brands">
                                            {{ Filler('brand',item.Brand) }}
                                        </a>
                                    </div>
                                </td>
                                <td ng-cloak ng-show="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-select="item.LifeCycle" buttons="no" 
                                           edit-disabled="(userProfile.Roles!=5 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'LifeCycle', $data-0, true)"
                                           e-ng-options="s.P_CycleID as s.Description for s in lnk.cycles">
                                            {{ Filler('cycles',item.LifeCycle) }}
                                        </a>
                                    </div>
                                </td>
                                <td ng-cloak ng-show="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-select="item.Family" buttons="no" 
                                           edit-disabled="(userProfile.Roles!=5 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'Family', $data-0, true)"
                                           e-ng-options="s.FamID as s.Description for s in lnk.families">
                                            {{ Filler('families',item.Family) }}
                                        </a>
                                    </div>
                                </td>
                                <td ng-cloak ng-hide="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-select="item.PriceList" buttons="no" 
                                           edit-disabled="(userProfile.Roles!=6 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'PriceList', $data-0, true)"
                                           e-ng-options="s.PLID as s.Description for s in lnk.pricelists">
                                            {{ Filler('PriceList',item.PriceList) }}
                                        </a>
                                    </div>
                                </td>
                                <!--<td class="text-center">{{item.Inventory | number:0}}</td>-->
                                <td ng-cloak ng-show="toggle" class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-checkbox="item.IsSerialized" buttons="no" 
                                           edit-disabled="(item.Inventory>0 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'IsSerialized', $data-0, true)"
                                           e-ng-true-value="1" e-ng-false-value="0"
                                           e-title="{{!(item.IsSerialized=='1') ? 'Serialized':'Deserialized'}} this Item?"
                                           ng-class="{'label-success': (item.IsSerialized=='1'), 'label-default': (item.IsSerialized=='0')}"
                                           class="label">{{ (item.IsSerialized=='1') && 'Serialized' || 'Not Serialized'}}</a>
                                    </div>
								</td>
                                <td class="text-center">
                                    <div class="popover-wrapper">
                                        <a editable-checkbox="item.IsActive" buttons="no" 
                                           edit-disabled="(item.Inventory>0 && userProfile.Roles!=1)"
                                           onaftersave="updateItem(item.PID, 'IsActive', $data-0, true)"
                                           e-ng-true-value="1" e-ng-false-value="0"
                                           e-title="{{!(item.IsActive=='1') ? 'Activate':'Deactivate'}} this Item?"
                                           ng-class="{'label-success': (item.IsActive=='1'), 'label-default': (item.IsActive=='0')}"
                                           class="label label-default">{{ (item.IsActive=='1') && 'Active' || 'In Active'}}</a>
                                    </div>
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

<div class="modal fade" id="addNewItemData" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container mywizard">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <form name="formAddItem" ng-submit="addNewProduct()" novalidate="novalidate">
                    <div class="wizard-header">
                        <div class="h3">
                            <b>ADD NEW</b> PRODUCT<br/>
                            <small ng-show="notify" ><br/>
                                <div class="alert" 
                                     ng-class="{'alert-danger': !response.success, 'alert-success': response.success}">
                                    <i class="fa fa-fw fa-lg"
                                       ng-class="{'fa-times-circle':!response.success, 'fa-check-circle':response.success}"></i><strong>{{(response.success) ? 'Well done!':'Opppsss!'}}</strong> {{response.message}}.
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
                        <li ng-click="onTabs(1)" class="active" style="width:50%"><a data-target="#about" data-toggle="tab">Product Info</a></li>
                        <li ng-click="onTabs(2)" class="" style="width:50%"><a data-target="#account" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content clearfix">
                        <div class="active tab-pane" id="about">
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <h4 class="info-text">Let's start with the basic information</h4>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-4">
                                            <label for="ItemBarCode">Bar Code</label>
                                            <input type="text" class="form-control" required="required" ng-maxlength="15"
                                                   id="ItemBarCode" ng-model="product.BarCode" placeholder="Item Code" />
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <label for="ItemDesc">Description</label>
                                            <input type="text" class="form-control" required="required" ng-maxlength="50"
                                                   id="ItemDesc" ng-model="product.ProductDesc" placeholder="Item Name" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label for="ItemSKU">SKU</label>
                                            <input type="text" class="form-control" required="required" ng-maxlength="50"
                                                   id="ItemSKU" ng-model="product.SKU" placeholder="Item Model" />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="ItemBrand">Brand</label>
                                            <select class="form-control select"
                                                    cast-to-integer="true"
                                                    ng-model="product.Brand"
                                                    required="required">
                                                <option ng-repeat="b in lnk.brands | orderBy:'+Description'" value="{{b.BrandID}}">{{b.Description}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="ItemCategory" class="col-sm-12 control-label">Category</label><br/>
                                        <div class="col-sm-12 text-center">
                                            <select class="form-control select"
                                                    cast-to-integer="true"
                                                    ng-model="product.Category"
                                                    required="required">
                                                <option ng-repeat="b in lnk.categories | orderBy:'+Description'" value="{{b.P_CatID}}">{{b.Description}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="ItemCategory" class="col-sm-12 control-label">Item Type</label><br/>
                                        <div class="col-sm-12 text-center">
                                            <select class="form-control select"
                                                    cast-to-integer="true"
                                                    ng-model="product.ItemType"
                                                    required="required">
                                                <option ng-repeat="b in lnk.types | orderBy:'+Description'" value="{{b.TypeID}}">{{b.Description}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="ItemCategory" class="col-sm-12 control-label">NS Brand</label><br/>
                                        <div class="col-sm-12 text-center">
                                            <select class="form-control select"
                                                    cast-to-integer="true"
                                                    ng-model="product.Family"
                                                    required="required">
                                                <option ng-repeat="b in lnk.families | orderBy:'+Description'" value="{{b.FamID}}">{{b.Description}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="ItemSerialize" class="col-sm-12 control-label">Has IMEI? <small>(Serialized?)</small></label><br/>
                                        <div class="col-sm-12 text-center">
                                            <div class="btn-group">
                                                <label class="btn btn-primary" btn-radio="true" ng-model="product.IsSerialized">Yes</label>
                                                <label class="btn btn-primary" btn-radio="false" ng-model="product.IsSerialized">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="account">
                            <div class="row clearfix">
                                <h4 class="col-xs-10 col-sm-offset-1">Set your default pricelist and this product status.</h4>
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group col-sm-6">
                                        <label>Price List</label>
                                        <select class="form-control"
                                                cast-to-integer="true"
                                                ng-model="product.PriceList"
                                                required="required">
                                            <option ng-repeat="b in lnk.pricelists | orderBy:'+Description'" value="{{b.PLID}}">{{b.Description}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Life Cycle</label>
                                        <select class="form-control"
                                                cast-to-integer="true"
                                                ng-model="product.LifeCycle"
                                                required="required">
                                            <option ng-repeat="b in lnk.cycles | orderBy:'+Description'" value="{{b.P_CycleID}}">{{b.Description}}</option>
                                        </select>
                                    </div>
                                </div>
                                <h4 class="col-xs-10 col-sm-offset-1">Set your default product Cost and SRP. <small>(this can be change however you want)</small></h4>
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="form-group col-sm-6">
                                        <label for="ItemStdCost">Standard Cost <small>(VAT-EX)</small></label>
                                        <input type="number" 
                                               ng-maxlength=18 
                                               class="form-control" 
                                               required="required" 
                                               id="ItemStdCost" ng-model="product.StdCost" />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="ItemSRP">Selling Price <small>(VAT-EX)</small></label>
                                        <input type="number" 
                                               ng-maxlength=18 
                                               class="form-control" 
                                               required="required" 
                                               id="ItemSRP" ng-model="pricelist.Price" />
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

<script src="/resources/js/app/product.js"></script>