<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Purchasing</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Purchase Order</h1>
                
                <div class="pull-right top-page-ui">
                    <a href="#/purchase/history" class="btn btn-success pull-right" style="margin-left:5px">
                        <i class="fa fa-history"></i> Logs
                    </a>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row register">
    <div class="col-sm-8 clearfix">
        
        <div class="register-box register-items-form">
            <div class="item-form form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-plus-circle fa-5x"></i></span>
                    <div class="padded-row">
                        <div angucomplete-ie8 id="ex6" 
                             placeholder="Type Product Code, Name, or Model..." 
                             pause="1000" selected-object="GetProduct" 
                             local-data="productLists" 
                             search-fields="BarCode,CustLastName,SKU" 
                             title-field="ProductDesc" 
                             description-field="BarCode"
                             image-field="Avatar"
                             minlength="1" 
                             input-class="form-control add-item-input"
                             match-class="highlight"
                             clear-selected="true"
                             auto-match="true">
                        </div>
                    </div>
                    <span class="input-group-addon register-mode purchase_order-mode dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Purchase Order
                            <span class="sr-only">Toggle Dropdown</span>
                         </a>
                         <ul class="dropdown-menu sales-dropdown" role="menu" style="cursor:pointer;">
                            <li><a href="/purchase/history">TRANSACTION HISTORY</a></li>
                         </ul>
                    </span>
                    <span class="input-group-addon grid-buttons">
                        <a ng-click="GetProduct()"><i class="fa fa-search fa-lg"></i></a>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="register-box register-items paper-cut">
            <div class="register-items-holder">
                <table id="register" class="table table-hover">
                    <thead>
                        <tr class="register-items-header">
                            <th></th>
                            <th class="item_name_heading col-sm-5">Item Name</th>
                            <th class="sales_price">Cost</th>
                            <th class="sales_price" 
                                ng-show="(tbxConfig.IsPurchaseTaxable=='1')">Vat</th>
                            <th class="sales_quantity">Qty.</th>
                            <th class="sales_discount">Disc %</th>
                            <th class="sales_price">Total</th>
                            <th ng-show="(tbxConfig.IsPurchaseTaxable=='1')">GTotal</th>
                        </tr>
                    </thead>
                    <tbody class="register-item-content"
                           ng-repeat="row in purchase.rows">
                        <tr class="register-item-details">
                            <td class="text-center"> 
                                <a class="delete-item" ng-click="removeItem($index)"><i class="fa fa-times-circle"></i></a> 
                            </td>
                            <td>
                                <span class="register-item-name">{{row.ProductDesc || 'Empty'}}</span>
                            </td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-text="row.StdCost" onaftersave="updateValue()"
                                       buttons="no" e-title="Edit Cost">{{row.StdCost || 0.00 | number:2}}</a>
                                </div>
                            </td>
                            <td class="text-center"
                                ng-show="(tbxConfig.IsPurchaseTaxable=='1')">{{row.InputVat}}%</td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-number='row.Quantity' onaftersave="updateValue()"
                                       buttons="no" e-title="Edit Price">{{row.Quantity || 1 | number:0}}</a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-number='row.Discount' onaftersave="updateValue()"
                                       e-ng-maxlength="3" e-maxlength="3" e-ng-max="100" e-ng-min="0" e-min="0" e-max="100"
                                       buttons="no" e-title="Edit Discount">{{row.Discount || 0 | number:0}}%</a>
                                </div>
                            </td>
                            <td class="text-center">{{row.Total = ((row.StdCost * (row.Quantity||1)) * (1 - ((row.Discount||0)/100))) || 0.00 | number:2}}</td>
                            <td class="text-center" ng-show="(tbxConfig.IsPurchaseTaxable=='1')">
                                {{row.GTotal = (row.Total * ((tbxConfig.IsPurchaseTaxable=='1') ? (1+((tbxConfig.InputTax-0)/100)) : 1)) || 0.00 | number:2}}</td>
                        </tr>
                        <tr class="register-item-bottom">
                            <td>&nbsp;</td>
                            <td colspan="7">
                                <dl class="register-item-extra-details dl-horizontal">
                                    <dt class="visible-lg">SKU</dt><dd class="visible-lg">{{row.SKU}}</dd>
                                    <dt>Product Code</dt><dd>{{row.BarCode}}</dd>
                                    <dt>Warehouse</dt>
                                    <dd><div class="popover-wrapper">
                                            <a editable-select="row.Warehouse" buttons="no"
                                               e-ng-options="whs.WhsCode as whs.WhsName for whs in WhsList">
                                                {{Filler(row.Warehouse)}}
                                            </a>
                                        </div>
                                    </dd>
                                </dl>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="register-item-content" ng-hide="(purchase.rows.length>0)">
                        <tr class="cart_content_area">
                            <td colspan="8">
                                <div class="text-center text-warning"> 
                                    <h4>There are no items in the cart</h4>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
<!--        <pre>{{purchase | json }}</pre>-->
    </div>
    
    <div class="col-sm-4 clearfix">
        
        <div class="register-box register-summary paper-cut">
            <ul class="list-group">
                <li class="sub-total list-group-item">
                    <span>Sub Total:</span>
                    <span class="value">{{purchase.header.Total | peso:2}}</span>
                </li>
                <li class="list-group-item global-discount-group"
                    ng-show="(tbxConfig.IsPurchaseTaxable=='1')">
                    <div class="key">Vat ({{tbxConfig.InputTax}}%) : </div>
                    <div class="value pull-right"><a>{{purchase.header.GTotal - purchase.header.Total | peso:2}}</a></div>
                </li>
            </ul>
            <div class="amount-block">
                <div class="total amount-due">
                    <div class="side-heading">Items In Cart </div>
                    <div class="amount">{{purchase.header.Quantity | number:0}}</div>
                </div>
                <div class="total amount">
                    <div class="side-heading">Total </div>
                    <div class="amount total-amount">{{purchase.header.GTotal | peso:2}}</div>
                </div>
            </div>
        </div>
        
        <div class="register-box register-summary register-right paper-cut">
            <div class="sale-buttons">
                <div class="input-group has-success">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" disabled="false" class="form-control text-center podate" readonly id="PoTransDate" ng-model="purchase.header.TransDate" />
                    <span class="input-group-addon">Del.</span>
                    <input type="text" class="form-control text-center podate" readonly id="PoTransDate" ng-model="purchase.header.DeliveryDate" />
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div> 
            <div class="customer-form" ng-hide="ShowBranchSelect">
                <div class="input-group" >
                    <span class="input-group-addon">
                        <a class="none" title="Ship to Branch"><i class="ion-paper-airplane"></i></a> </span>
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    <div class="padded-row">
                        <div angucomplete-ie8 id="ex6" 
                             placeholder="Type Ship To Store..." 
                             pause="100" selected-object="GetShipToBranch" 
                             local-data="branches" 
                             search-fields="Description,BranchCode" 
                             title-field="Description" 
                             description-field="BranchCode" 
                             image-field="Avatar"
                             minlength="1" 
                             input-class="form-control add-customer-input" 
                             match-class="highlight"
                             clear-selected="true"
                             auto-match="true">
                        </div>
                    </div>
                </div>
            </div>
            <div class="customer-badge" ng-show="ShowBranchSelect">
                <div class="avatar">
                    <i class="fa fa-truck fa-4x"></i>
                </div>
                <div class="details">
                    <a class="name">{{DeliveryStore}}</a>
                    <div class="email">{{DelEmail}}</div>
                    <a ng-click="resetShipToBranch(purchase.header)" 
                       class="btn btn-edit btn-primary pull-right" 
                       title="Change Delivery Address">
                        <i class="ion-ios-compose-outline"></i>
                    </a>
                </div>
            </div>
            <div class="customer-form" ng-show="!ShowSupplier && ShowBranchSelect">
                <div class="input-group" >
                    <span class="input-group-addon">
                        <a class="none" title="Ship to Branch"><i class="ion-ios-home"></i></a> </span>
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    <div class="padded-row">
                        <div angucomplete-ie8 id="ex6" 
                             placeholder="Type Supplier Name..." 
                             pause="100" selected-object="GetSupplier" 
                             local-data="suppliers" 
                             search-fields="CoyName" 
                             title-field="CoyName" 
                             description-field="ContactPerson" 
                             image-field="Avatar"
                             minlength="1" 
                             input-class="form-control add-customer-input" 
                             match-class="highlight"
                             clear-selected="true"
                             auto-match="true">
                        </div>
                    </div>
                </div>
            </div>
            <div class="customer-badge" ng-show="ShowSupplier">
                <div class="avatar">
                    <i class="fa fa-home fa-4x"></i>
                </div>
                <div class="details">
                    <a class="name">{{SuppName}}</a>
                    <span class="email">{{SuppEmail}}</span><br/>
                    <span class="email">{{SuppContact}}</span>
                    <a id="edit_supplier" ng-click="resetSupplier(purchase.header)" 
                       class="btn btn-edit btn-primary pull-right" 
                       title="Change Supplier">
                        <i class="ion-ios-compose-outline"></i>
                    </a>
                </div>
            </div>
            <div class="comment-block clearfix">
                <div class="side-heading"><label id="comment_label" for="comment">Comments : </label></div>
                <textarea name="comment" cols="40" rows="3" maxlength="100"
                          ng-maxlength="100" ng-model="purchase.header.Comments"
                          id="comment" class="form-control"></textarea>
                <div class="pull-right"><small>Character {{purchase.header.Comments.length}} of 100</small></div>
            </div>
            <div id="finish_sale" class="receivings-finish-sale">
                <form novalidate="novalidate" ng-submit="SubmitPurchaseOrder(purchase.header, purchase.rows)">
                    <div class="form-group">
                        <div class="input-group add-payment-form">
                            <input type="text" ng-maxlength="15" placeholder="PO No." ng-model="purchase.header.PONumber"
                                   class="add-input form-control" maxlength="15"/>
                            <span class="input-group-addon">
                                <a class="no-transfer" ng-click="SubmitPurchaseOrder(purchase.header, purchase.rows)">Send Purchase Order</a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/purchase.js"></script>