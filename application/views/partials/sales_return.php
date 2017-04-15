<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Sales</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Sales Return</h1>
                
                <div class="pull-right top-page-ui">
                    <a href="#/sales/return/history" class="btn btn-success pull-right" style="margin-left:5px">
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
                    <span class="input-group-addon">
                        <a><i class="fa fa-plus-circle"></i> Return No.</a>
                    </span>
                    <form ng-submit="GetSalesTransID(SalesTransID)">
                        <input type="text" id="GetProduct" ng-model="SalesTransID"
                               class="form-control add-item-input" autocomplete="off"
                               placeholder="Enter Return No.">
                    </form>
                    <span class="input-group-addon register-mode purchase_order-mode dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{register.MethodName}}
                            <span class="sr-only">Toggle Dropdown</span>
                         </a>
                         <ul class="dropdown-menu sales-dropdown" role="menu" style="cursor:pointer;">
                            <li><a ng-click="ChangeMethod(0)"><i class="fa fa-history fa-stack"></i> Sales Return</a></li>
                            <li><a ng-click="ChangeMethod(1)"><i class="fa fa-history fa-stack"></i> Sales Refund</a></li>
                            <li class="divider"></li>
                            <li><a href="#/sales/invoice"><i class="fa fa-history fa-stack"></i> CREATE NEW SALES</a></li>
                            <li><a href="#/sales/return/history"><i class="fa fa-history fa-stack"></i> TRANSACTION HISTORY</a></li>
                         </ul>
                    </span>
                    <span class="input-group-addon grid-buttons">
                        <a ng-click="GetSalesTransID(SalesTransID)"><i class="fa fa-search fa-lg"></i></a>
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
                            <th class="sales_price">Unit Price</th>
                            <th class="sales_quantity">Qty.</th>
                            <th class="sales_quantity">Disc.</th>
                            <th class="sales_price">Total</th>
                        </tr>
                    </thead>
                    <tbody class="register-item-content"
                           ng-repeat="row in register.rows">
                        <tr class="register-item-details">
                            <td class="text-center"> 
                                <a class="delete-item" ng-click="removeItem($index)"><i class="fa fa-times-circle"></i></a> 
                            </td>
                            <td>
                                <span class="register-item-name">{{row.ProductDesc || 'Empty'}}</span>
                            </td>
                            <td class="text-center" ng-hide="true">{{row.Subsidy || 0.00 | peso:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.PriceAfSub = row.Price + row.Subsidy || 0.00 | peso:2}}</td>
                            <td class="text-center">{{row.PriceAfVat = (row.PriceAfSub * (1+(row.OutputVat/100))) || 0.00 | peso:2}}</td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-number='row.Quantity' 
                                       onbeforesave="checkInventory($data, row)"
                                       onaftersave="updateValue()" 
                                       e-min=1 e-ng-min=1
                                       edit-disabled="(row.IsSerialized==1)"
                                       buttons="no" e-title="Edit Price">{{row.Quantity || 1 | number:0}}</a>
                                </div>
                            </td>
                            <td class="text-center">{{row.Discount || 0 | number:2}}%</td>
                            <td class="text-center" ng-hide="true">{{row.Total = (row.Price * (row.Quantity||1)) || 0.00 | number:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.TotalAfSub = (row.PriceAfSub * (row.Quantity||1)) || 0.00 | number:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.TotalAfVat = (row.TotalAfSub * (1+(row.OutputVat/100))) || 0.00 | number:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.DiscValue = (row.TotalAfVat * (row.Discount/100)) || 0.00 | number:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.AmountDue = ((row.PriceAfSub * (1-(row.Discount/100))) * (1+(row.OutputVat/100))) * (row.Quantity||1) || 0.00 | number:2}}</td>
                            <td class="text-center">{{row.GTotal = row.AmountDue || 0.00 | number:2}}</td>
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
                            <td colspan="3">
                                <dl class="register-item-extra-details dl-horizontal">
                                    <dt>Available for Return:</dt><dd>{{row.InStocks}}</dd>
                                    <dt ng-show="row.IsSerialized==1">Serial:</dt>
                                    <dd ng-show="row.IsSerialized==1">{{row.Serials}}</dd>
                                </dl>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="register-item-content" ng-hide="(register.rows.length>0)">
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
<!--        <pre>{{register | json}}</pre>-->
    </div>
    
    <div class="col-sm-4 clearfix">
        
        <div class="register-box register-right">
            <div class="sale-buttons">
                <div class="input-group has-success">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" ng-disabled="(register.Backdating==0)" class="form-control text-center podate" readonly id="PoTransDate" ng-model="register.header.TransDate" />
                    <span class="input-group-addon">Transaction Date</span>
                </div>
            </div> 
            <div class="customer-badge">
                <div class="input-group" ng-hide="ShowBranchSelect">
                    <span class="input-group-addon"><i class="fa fa-home fa-lg"></i> Branch</span>
                    <select class="form-control" id="PoBranch" ng-model="register.header.Branch"
                            ng-change="GetBranch()">
                        <option ng-repeat="b in branches" value="{{b.BranchID}}">{{b.Description}}</option>
                    </select>
                </div>
                <div ng-show="ShowBranchSelect">
                    <div class="avatar">
                        <i class="fa fa-home fa-4x"></i>
                    </div>
                    <div class="details">
                        <a class="name">{{register.BranchName}}</a>
                        <div class="email">Posted By: {{register.CreatedBy}}</div>
                        <a ng-click="resetBranch(register.header)" permission="[1,2,5,6]"
                           class="btn btn-edit btn-primary pull-right" 
                           title="Change Delivery Address">
                            <i class="ion-ios-compose-outline"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="customer-badge">
                <div class="avatar">
                    <img src="/resources/img/avatar/agent/default.png" alt="">
                </div>
                <div class="details">
                    <a ng-bind="register.customer.Fullname">Name here</a>
                    <div class="text-success balance">Balance: {{register.Balance || 0 | peso:2}}</div>
                    <div class="text-danger points">Points: {{register.Points || 0 | peso:2}}</div>
                    
                    <div class="email"><a>Card No.:<span ng-bind="register.customer.CardNo">Card No. here</span></a></div>
                    <span class="email"><a><span ng-bind="register.customer.Email">email add here</span></a></span>

<!--                    <a ng-click="resetCustomer(register)" id="edit_customer" class="btn btn-edit btn-primary pull-right" title="Update Customer"><i class="ion-ios-compose-outline"></i></a>-->
                </div>
                <div class="form-group" collapse="!toggleCredits">
                    <div class="input-group contacts" style="margin-top:10px">
                        <span class="input-group-addon"><a class="none">Credits</a></span>
                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                        <input type="number" class="form-control add-customer-input" 
                               ng-model="npoints" placeholder="Enter Credits!"
                               ng-keyup="ApplyCredits(0, npoints, $event)" />
                        <span class="input-group-addon" ng-click="toggleCredits=false"><a><i class="fa fa-times-circle"></i></a></span>
                    </div>
                </div>
                <div class="form-group" collapse="!togglePoints">
                    <div class="input-group contacts" style="margin-top:10px">
                        <span class="input-group-addon"><a class="none">Points</a></span>
                        <input type="number" class="form-control add-customer-input" 
                               ng-model="npoints" placeholder="Enter Points!"
                               ng-keyup="ApplyCredits(1, npoints, $event)" />
                        <span class="input-group-addon" ng-click="togglePoints=false"><a><i class="fa fa-times-circle"></i></a></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="register-box register-summary paper-cut">
            <ul class="list-group">
                <li class="sub-total list-group-item">
                    <span>Sub Total:</span>
                    <span class="value">{{register.header.TotalAfSub * -1 | peso:2}}</span>
                </li>
                <li class="list-group-item global-discount-group" ng-show="(register.header.SalesTax<0)">
                    <span class="key">Sales Tax:</span>
                    <span class="value pull-right">{{register.header.SalesTax * -1 | peso:2}}</span>
                </li>
                <li class="list-group-item global-discount-group" ng-show="(register.header.Discount<0)">
                    <span class="key">Discount:</span>
                    <span class="value pull-right">{{register.header.Discount | peso:2}}</span>
                </li>
            </ul>
            <div class="amount-block">
                <div class="total amount">
                    <div class="side-heading">Items for Return </div>
                    <div class="amount total-amount">{{register.header.Quantity * -1 | number:0}}</div>
                </div>
                <div class="total amount-due">
                    <div class="side-heading">Amount Due </div>
                    <div class="amount">{{register.header.NetTotal * -1 | peso:2}}</div>
                </div>
            </div>
            <div class="comment-block clearfix">
                <div class="side-heading"><label id="comment_label" for="comment">Comments : </label></div>
                <textarea name="comment" cols="40" rows="3" maxlength="100"
                          ng-maxlength="100" ng-model="register.header.Comments"
                          id="comment" class="form-control"></textarea>
                <div class="pull-right"><small>Character {{register.header.Comments.length}} of 100</small></div>
            </div>
            <div id="finish_sale" class="finish-sale" ng-show="(register.rows.length>0)">
                <button class="btn btn-success btn-large btn-block" 
                        data-toggle="modal" data-target="#SendReturn"
                       id="finish_sale_button">Complete Return</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="GetSalesInvoice" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                <h4 class="modal-title"><span>Enter Return No.</span></h4>
            </div>
            <div class="modal-body">
                <form ng-submit="GetSalesTransID(SalesTransID)" novalidate="novalidate" name="SForm">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Return No.</span>
                            <input type="text" required
                                   placeholder="Return No." ng-model="SalesTransID"
                                   class="add-input form-control"/>
                        </div>
                    </div>
                    <Button class="btn btn-success btn-large btn-block" 
                           id="finish_sale_button"
                           style="display: block;">Submit Sale</Button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="SendReturn" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                <h4 class="modal-title"><span>Enter Returning Invoice Number</span></h4>
            </div>
            <div class="modal-body">
                <form ng-submit="SubmitRegister(register)" novalidate="novalidate" name="SForm">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Current SI/OR</span>
                            <input type="number" maxlength="10" ng-maxlength="10" required
                                   placeholder="Ref. No." ng-model="register.header.RefNo"
                                   class="add-input form-control"/>
                        </div>
                    </div>
                    <Button class="btn btn-success btn-large btn-block" 
                           id="finish_sale_button"
                           style="display: block;">Submit Sale</Button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/return.js"></script>