<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Sales</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Invoice</h1>
                
                <div class="pull-right top-page-ui">
                    <a href="/sales/invoice/history" class="btn btn-success pull-right" style="margin-left:5px">
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
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{register.SelectedInst}}
                            <span class="sr-only">Toggle Dropdown</span>
                         </a>
                        <ul class="dropdown-menu sales-dropdown" role="menu" style="cursor:pointer;">
                            <li><a ng-click="SelectInst(-1)">Cash</a></li>
                            <li ng-repeat="i in installments | orderBy:'+(InstValue-0)'"><a ng-click="SelectInst(i.InsId)">{{i.InstDesc + ' (' +  i.InstValue + '%)'}}</a></li>
                         </ul>
                    </span>
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
                            <li><a href="#/sales/invoice/history"><i class="fa fa-history fa-stack"></i> TRANSACTION HISTORY</a></li>
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
                            <th class="sales_price">SRP (Vat Inc)</th>
                            <th class="sales_quantity">Qty.</th>
                            <th class="sales_quantity">Disc.</th>
                            <th class="sales_price" colspan="3">GTotal</th>
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
                            <td class="text-center" ng-hide="true">{{row.Subsidy = row.Price*(register.Subsidy/100) || 0.00 | peso:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.PriceAfSub = row.Price + row.Subsidy || 0.00 | peso:2}}</td>
                            <td class="text-center">{{row.PriceAfVat = (row.PriceAfSub * row.SalesTax) || 0.00 | peso:2}}</td>
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
                            <td class="text-center" ng-hide="true">{{row.TotalAfVat = (row.TotalAfSub * row.SalesTax) || 0.00 | number:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.DiscValue = (row.TotalAfVat * (row.Discount/100)) || 0.00 | number:2}}</td>
                            <td class="text-center" ng-hide="true">{{row.AmountDue = ((row.PriceAfSub * (1-(row.Discount/100))) * row.SalesTax) * (row.Quantity||1) || 0.00 | number:2}}</td>
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
                                    <dt>In Stocks:</dt><dd>{{row.InStocks}}</dd>
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
                    <div class="email">Sold By: {{register.CreatedBy}}</div>
                    <a ng-click="resetBranch(register.header)" permission="[1,2,5,6]"
                       class="btn btn-edit btn-primary pull-right" 
                       title="Change Delivery Address">
                        <i class="ion-ios-compose-outline"></i>
                    </a>
                </div>
            </div>
            <div class="customer-form" ng-hide="ShowFLSelect">
                <div class="input-group" >
                    <span class="input-group-addon">
                        <a class="none" title="FrontLiner"><i class="ion-android-contacts"></i></a> </span>
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    <div class="padded-row">
                        <div angucomplete-ie8 id="ex6" 
                             placeholder="Sold By..." 
                             pause="100" selected-object="GetFl" 
                             local-data="frontliners" 
                             search-fields="DisplayName" 
                             title-field="DisplayName" 
                             description-field="Email" 
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
            <div class="customer-badge" ng-show="ShowFLSelect">
                <div class="avatar">
                    <i class="fa fa-user fa-4x"></i>
                </div>
                <div class="details">
                    <a class="name">{{register.CreatedBy}}</a>
                    <div class="email">Account: {{register.Email}}</div>
                    <a ng-click="resetFL(register.header)"
                       class="btn btn-edit btn-primary pull-right" 
                       title="Change Sold By">
                        <i class="ion-ios-compose-outline"></i>
                    </a>
                </div>
            </div>
            <div class="customer-form" ng-hide="CustSelected">
                <div class="input-group contacts large-padded-row">
                    <span class="input-group-addon">
                        <a data-toggle="modal" data-target="#NewCustomer" class="none" title="New Customer" id="new-customer" tabindex="-1"><i class="ion-person-add"></i></a> </span>
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    <div class="padded-row">
                        <div angucomplete-ie8 id="ex6" 
                             placeholder="Type customer name..." 
                             pause="100" selected-object="CustomerSelected" 
                             local-data="customers" 
                             search-fields="CustFirstName,CustLastName,CardNo" 
                             title-field="CustFirstName,CustLastName" 
                             description-field="CardNo" 
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
            <div class="customer-badge" ng-show="CustSelected">
                <div class="avatar">
                    <img src="/resources/img/avatar/agent/default.png" alt="">
                </div>
                <div class="details">
                    <a ng-bind="register.customer.Fullname">Name here</a>
                    <div class="text-success balance">Balance: {{register.Balance | peso:2}}</div>
                    <div class="text-danger points">Points: {{register.Points | number:2}}</div>
                    
                    <div class="email" ng-show="register.header.IsMember==1"><a>Card No.:<span ng-bind="register.customer.CardNo">Card No. here</span></a></div>
                    <span class="email"><a><span ng-bind="register.customer.Email">email add here</span></a></span>

                    <a ng-click="resetCustomer(register)" id="edit_customer" class="btn btn-edit btn-primary pull-right" title="Change Customer"><i class="ion-ios-compose-outline"></i></a>
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
            <div class="customer-action-buttons clearfix" ng-show="CustSelected && register.header.NetTotal>0 && register.header.IsMember==1">
                <a ng-click="toggle(true)" class="btn">
                    <i class="ion-android-radio-button-off" ng-hide="toggleCredits"></i>
                    <i class="ion-android-radio-button-on" ng-show="toggleCredits"></i>
                    Apply Credits</a>
                <a ng-click="toggle(false)" class="btn">
                    <i class="ion-android-radio-button-on" ng-show="togglePoints"></i>
                    <i class="ion-android-radio-button-off" ng-hide="togglePoints"></i>
                    Apply Points</a> 
            </div>
        </div>
        
        <div class="register-box register-summary paper-cut">
            <ul class="list-group">
                <li class="list-group-item global-discount-group" style="margin:15px 0 10px">
                    <div class="key">Discount all Items by %: </div>
                    <div class="value pull-right popover-wrapper">
                        <a editable-number='register.discount'
                           e-ng-disabled="register.rows.length==0"
                           e-step="0.0001"
                           e-min=0 e-max=100
                           e-ng-min=0 e-ng-max=100
                           e-title="Discount"
                           e-placeholder="Enter Discount"
                           onaftersave="AddDiscount($data)"
                           buttons="no">{{(register.discount | number:2) || 'Set Discount' }}%</a> 
                    </div>
                </li>
                <li class="sub-total list-group-item">
                    <span>Sub Total:</span>
                    <span class="value">{{register.header.TotalAfSub | peso:2}}</span>
                </li>
                <li class="list-group-item global-discount-group" ng-show="(register.SalesTax>0 && register.IsTaxable==1)">
                    <span class="key">{{register.SalesTax}}% Sales Tax:</span>
                    <span class="value pull-right">{{register.header.TotalAfSub * (register.SalesTax/100) | peso:2}}</span>
                </li>
                <li class="list-group-item global-discount-group" ng-show="(register.header.Discount>0)">
                    <span class="key">{{register.discount | number:2}}% Discount:</span>
                    <span class="value pull-right">{{register.header.Discount * -1 | peso:2}}</span>
                </li>
            </ul>
            <div class="amount-block">
                <div class="total amount">
                    <div class="side-heading">Sales Total </div>
                    <div class="amount total-amount">{{register.header.NetTotal | peso:2}}</div>
                </div>
                <div class="total amount-due">
                    <div class="side-heading">Amount Due </div>
                    <div class="amount">{{register.header.ShortOver | peso:2}}</div>
                </div>
            </div>
            <ul class="list-group payments" ng-show="(register.header.Payment>0)">
                <li class="list-group-item" ng-repeat="p in register.payments">
                    <span class="key">
                        <a ng-click="removePayment($index)" class="delete-payment remove" id="delete_payment_0">
                            <i class="icon ion-android-cancel"></i></a> 
                        {{FillerPayType(p.PaymentType)}}
                    </span>
                    <span class="value">{{p.Amount | peso:2}}</span>
                </li>
            </ul>
            <div class="add-payment" ng-show="(register.header.TotalBefSub>0)">
                <div class="side-heading">Add Payment</div>
                <div class="btn-group col-sm-12">
                    <label ng-repeat="pay in tbxConfig.payments" ng-if="pay.IsActive==1" style="margin-right:5px"
                           class="btn btn-pay select-payment"
                           btn-radio="pay.PaymentId" ng-model="register.PayType">{{pay.PaymentName}}</label>
                </div>
                <div class="form-group" ng-show="register.PayType!='2' && register.PayType!='5'">
                    <div class="input-group add-payment-form">
                        <input type="number" step="0.01" ng-keyup="Enter($event)"
                               ng-maxlength="18" placeholder="Enter Amount" ng-model="Payment.Amount"
                               class="add-input form-control" maxlength="18"/>
                        <span class="input-group-addon">
                            <a class="no-transfer" data-toggle="modal" data-target="#SendSales"
                               ng-show="(register.header.ShortOver<=0 && register.header.TotalBefSub>0)">Complete Sale</a>
                            <a class="no-transfer" ng-click="AddPayment(Payment.Amount)"
                               ng-hide="(register.header.ShortOver<=0 && register.header.TotalBefSub>0)">Add Payment</a>
                        </span>
                    </div>
                </div>
                <div class="form-group" ng-show="register.PayType=='2'">
                    <div class="input-group">
                        <span class="input-group-addon">Issued Card</span>
                        <select class="form-control" ng-model="Payment.IssuingBank" ng-options="t.BankID as t.BankName for t in terminals"></select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Terminal</span>
                        <select class="form-control" ng-model="Payment.Terminal" ng-options="t.BankID as t.BankName for t in terminals"></select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Ref No.</span>
                        <input class="form-control" type="text" placeholder="Ref. No."
                               ng-maxlength=20 maxlength=20 ng-model="Payment.RefNumber" />
                    </div>
                    <div class="input-group add-payment-form">
                        <input type="number" step="0.01" ng-keyup="Enter($event)"
                               ng-maxlength="18" placeholder="Enter Amount" ng-model="Payment.Amount"
                               class="add-input form-control" maxlength="18"/>
                        <span class="input-group-addon">
                            <a class="no-transfer" data-toggle="modal" data-target="#SendSales"
                               ng-show="(register.header.ShortOver<=0 && register.header.TotalBefSub>0)">Complete Sale</a>
                            <a class="no-transfer" ng-click="AddPayment(Payment.Amount)"
                               ng-hide="(register.header.ShortOver<=0 && register.header.TotalBefSub>0)">Add Payment</a>
                        </span>
                    </div>
                </div>
                <div class="form-group" ng-show="register.PayType=='5'">
                    <div class="input-group">
                        <span class="input-group-addon">Home Credit</span>
                        <input class="form-control" type="text" placeholder="Ref. No."
                               ng-maxlength=20 maxlength=20 ng-model="Payment.RefNumber" />
                    </div>
                    <div class="input-group add-payment-form">
                        <input type="number" step="0.01" ng-keyup="Enter($event)"
                               ng-maxlength="18" placeholder="Enter Amount" ng-model="Payment.Amount"
                               class="add-input form-control" maxlength="18"/>
                        <span class="input-group-addon">
                            <a class="no-transfer" data-toggle="modal" data-target="#SendSales"
                               ng-show="(register.header.ShortOver<=0 && register.header.TotalBefSub>0)">Complete Sale</a>
                            <a class="no-transfer" ng-click="AddPayment(Payment.Amount)"
                               ng-hide="(register.header.ShortOver<=0 && register.header.TotalBefSub>0)">Add Payment</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="comment-block clearfix">
                <div class="side-heading"><label id="comment_label" for="comment">Comments : </label></div>
                <textarea name="comment" cols="40" rows="3" maxlength="100"
                          ng-maxlength="100" ng-model="register.header.Comments"
                          id="comment" class="form-control"></textarea>
                <div class="pull-right"><small>Character {{register.header.Comments.length}} of 100</small></div>
            </div>
            <div id="finish_sale" class="finish-sale" ng-show="(register.header.ShortOver<=0 && register.header.TotalBefSub>0)">
                <button class="btn btn-success btn-large btn-block" 
                        data-toggle="modal" data-target="#SendSales"
                       id="finish_sale_button">Complete Sale</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="NewCustomer" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="wizard-container">
            <div class="card wizard-card ct-wizard-red" id="wizardProfile">
                <form ng-submit="addTempCustomer()" novalidate="novalidate">
                    <div class="wizard-header">
                        <div class="h3">
                            <b>CUSTOMER</b> INFORMATION
                        </div>
                    </div>
                    
                    <div class="tab-content">
                        <div class="row">                     
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="form-group col-sm-12">
                                    <label for="forFullName">Name <small>(required)</small></label>
                                    <input type="text" class="form-control" required="required" 
                                           id="forFullName" ng-maxlength=50
                                           ng-model="register.customer.Fullname" 
                                           placeholder="Reggie Dabu" />
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="forEmail">Email <small>(required)</small></label>
                                        <input type="email" class="form-control" required="required" 
                                               id="forEmail" ng-maxlength=50
                                               ng-model="register.customer.Email" 
                                               placeholder="email@company.com" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="forContract">Contact No. <small>(required)</small></label>
                                        <input type="number" class="form-control" required="required" ng-maxlength=12
                                               id="forContract" ng-model="register.customer.ContactNo" 
                                               placeholder="Mobile No." />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="form-group col-sm-12">
                                    <label for="forAddress">Address</label>
                                    <textarea class="form-control" ng-maxlength=100
                                              required="required" id="forAddress" 
                                              ng-model="register.customer.Address" 
                                              placeholder="Enter Address"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-footer">
                        <div class="pull-right">
                            <a data-dismiss="modal" ng-click="register.customer = {}" class="btn btn-default pull-right" style="margin-left:5px">
                                <i class="fa fa-times-circle fa-lg"></i> Cancel
                            </a>
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

<div class="modal fade" id="SendSales" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                <h4 class="modal-title"><span>Enter Invoice Number</span></h4>
            </div>
            <div class="modal-body">
                <form ng-submit="SubmitRegister(register)" novalidate="novalidate" name="SForm">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">SI/OR</span>
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

<script src="/resources/js/app/sales.js"></script>