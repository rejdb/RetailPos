<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Stock Management</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Stock Pullout</h1>
                <div class="pull-right top-page-ui">
                    <a href="#/stocks/pullout/history" class="btn btn-success pull-right" style="margin-left:5px">
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
                    <form ng-submit="GetProduct(register.header)">
                        <input type="text" id="GetProduct" ng-model="SearchProduct"
                               class="form-control add-item-input" autocomplete="off"
                               placeholder="Enter Product Code">
                    </form>
                    <span class="input-group-addon register-mode purchase_order-mode dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{register.SelectedWhs}}
                            <span class="sr-only">Toggle Dropdown</span>
                         </a>
                         <ul class="dropdown-menu sales-dropdown" role="menu" style="cursor:pointer;">
                            <li ng-repeat="whs in WhsList"><a ng-click="SelectWhs(whs.WhsCode)">{{whs.WhsName}}</a></li>
                            <li class="divider"></li>
                            <li><a href="#/stocks/pullout/history"><i class="fa fa-history fa-stack"></i> TRANSACTION HISTORY</a></li>
                         </ul>
                    </span>
                    <span class="input-group-addon grid-buttons">
                        <a ng-click="GetProduct(register.header)"><i class="fa fa-search fa-lg"></i></a>
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
                            <th class="sales_quantity">Qty.</th>
                            <th class="sales_price">Total</th>
                        </tr>
                    </thead>
                    <tbody class="register-item-content"
                           ng-repeat="row in register.rows">
                        <tr class="register-item-details">
                            <td class="text-center"> 
                                <a class="delete-item" ng-click="removeItem($index, (row.IsSerialized==1) ? row.Serials:row.BarCode)"><i class="fa fa-times-circle"></i></a> 
                            </td>
                            <td>
                                <span class="register-item-name">{{row.ProductDesc || 'Empty'}}</span>
                            </td>
                            <td class="text-center">{{row.StdCost || 0.00 | number:2}}</td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-number='row.Quantity' 
                                       onbeforesave="checkInventory($data, row)"
                                       onaftersave="updateValue()" 
                                       e-ng-disabled="(row.IsSerialized==1)"
                                       buttons="no" e-title="Edit Price">{{row.Quantity || 1 | number:0}}</a>
                                </div>
                            </td>
                            <td class="text-center">{{row.Total = ((row.StdCost * (row.Quantity||1)) * (1 - ((row.Discount||0)/100))) || 0.00 | number:2}}</td>
                        </tr>
                        <tr class="register-item-bottom">
                            <td>&nbsp;</td>
                            <td colspan="2">
                                <dl class="register-item-extra-details dl-horizontal">
                                    <dt class="visible-lg">SKU</dt><dd class="visible-lg">{{row.SKU}}</dd>
                                    <dt>Product Code</dt><dd>{{row.BarCode}}</dd>
                                    <dt>Warehouse</dt><dd>{{Filler(row.Warehouse)}}</dd>
                                </dl>
                            </td>
                            <td colspan="2">
                                <dl class="register-item-extra-details dl-horizontal">
                                    <dt>In Stocks:</dt><dd>{{row.InStocks}}</dd>
                                    <dt ng-show="row.IsSerialized==1">Serial:</dt>
                                    <dd ng-show="row.IsSerialized==1">{{row.Serials}}</dd>
                                </dl>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="register-item-content" ng-hide="(register.rows.length>0)">
                        <tr class="cart_content_area">
                            <td colspan="5">
                                <div class="text-center text-warning"> 
                                    <h4>There are no items in the cart</h4>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
<!--        <pre>{{register | json}}</pre>-->
    </div>
    
    <div class="col-sm-4 clearfix">
        
        <div class="register-box register-right">
            <div class="sale-buttons">
                <div class="input-group has-success">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" disabled="false" class="form-control text-center podate" readonly id="PoTransDate" ng-model="register.header.TransDate" />
                    <span class="input-group-addon">Transaction Date</span>
                </div>
            </div> 
            <div class="customer-form" ng-hide="ShowBranchSelect">
                <div class="input-group" >
                    <span class="input-group-addon">
                        <a class="none" title="Branches"><i class="ion-home"></i></a> </span>
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    <div class="padded-row">
                        <div angucomplete-ie8 id="ex6" 
                             placeholder="Type Branch Name..." 
                             pause="100" selected-object="GetBranch" 
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
                    <i class="fa fa-home fa-4x"></i>
                </div>
                <div class="details">
                    <a class="name">{{register.BranchName}}</a>
                    <div class="email">Posted By: {{register.CreatedBy}}</div>
                    <a ng-click="resetBranch(register.header)" permission="[1,2,5,6]"
                       class="btn btn-edit btn-primary pull-right" 
                       title="Change Delivery Address">
                        <i class="fa fa-external-link"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="register-box register-summary paper-cut">
            <ul class="list-group">
                <li class="sub-total list-group-item">
                    <span>Sub Total:</span>
                    <span class="value">{{register.header.Total | peso:2}}</span>
                </li>
                <li class="list-group-item global-discount-group"
                    ng-show="(tbxConfig.IsPurchaseTaxable=='1')">
                    <div class="key">Vat ({{tbxConfig.InputTax}}%) : </div>
                    <div class="value pull-right"><a>{{0.00 | peso:2}}</a></div>
                </li>
            </ul>
            <div class="amount-block">
                <div class="total amount-due">
                    <div class="side-heading">Items In Cart </div>
                    <div class="amount">{{register.header.Quantity | number:0}}</div>
                </div>
                <div class="total amount">
                    <div class="side-heading">Total </div>
                    <div class="amount total-amount">{{register.header.Total | peso:2}}</div>
                </div>
            </div>
            <div class="comment-block clearfix">
                <div class="side-heading"><label id="comment_label" for="comment">Comments : </label></div>
                <textarea name="comment" cols="40" rows="3" maxlength="100"
                          ng-maxlength="100" ng-model="register.header.Comments"
                          id="comment" class="form-control"></textarea>
                <div class="pull-right"><small>Character {{register.header.Comments.length}} of 100</small></div>
            </div>
            <div id="finish_sale" class="receivings-finish-sale">
                <form novalidate="novalidate" ng-submit="SubmitRegister(register.header, register.rows)">
                    <div class="form-group">
                        <div class="input-group add-payment-form">
                            <input type="text" ng-maxlength="10" placeholder="Ref. No." ng-model="register.header.RefNo"
                                   class="add-input form-control" maxlength="10"/>
                            <span class="input-group-addon">
                                <a class="no-transfer" ng-click="SubmitRegister(register.header, register.rows)">Send Pull-out for Approval</a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/pullout.js"></script>