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
                    <a href="#/Purchase/List" class="btn btn-success pull-right" style="margin-left:5px">
                        <i class="fa fa-plus-circle fa-lg"></i> Purchase Order
                    </a>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row register">
    <div class="col-sm-8 clearfix">
        <div class="register-box register-items-form">
            <div class="item-form">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-pencil-square"></i></a>
                        <ul ng-init="search.type=1" class="dropdown-menu sales-dropdown" role="menu" style="cursor:pointer;">
                            <li><a ng-click='search.type=0'>Search by SERIAL</a></li>
                            <li><a ng-click='search.type=1'>Search by Product Code</a></li>
                            <li><a ng-click='search.type=2'>Search by Kit Barcode</a></li>
                        </ul>
                    </span>
                    <input type="text" class="form-control add-item-input" 
                           placeholder="Enter {{(search.type==0) ? 'Item IMEI / Serial No.' : (search.type==1) ? 'Product Code' : 'Kit Barcode'}}">
                    <span class="input-group-addon register-mode purchase_order-mode dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Purchase Order
                            <span class="sr-only">Toggle Dropdown</span>
                         </a>
                         <ul class="dropdown-menu sales-dropdown" role="menu" style="cursor:pointer;">
                            <li><a href="/return">RETURN</a></li>
                            <li><a href="/transaction">TRANSACTION HISTORY</a></li>
                         </ul>
                    </span>
                    <span class="input-group-addon grid-buttons">
                        <a><i class="fa fa-search fa-lg"></i></a>
                    </span>
                </div>
            </div>
            </div>
        </div>
        <div class="register-box register-items paper-cut">
            <div class="register-items-holder">
                <table id="register" class="table table-hover">
                    <thead>
                        <tr class="register-items-header">
                            <th></th>
                            <th class="item_name_heading">Item Name</th>
                            <th class="sales_price">Cost</th>
                            <th class="sales_quantity">Qty.</th>
                            <th class="sales_discount">Disc %</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="register-item-content">
                        <tr class="register-item-details">
                            <td class="text-center"> 
                                <a class="delete-item"><i class="fa fa-times-circle"></i></a> 
                            </td>
                            <td>
                                <span class="register-item-name">{{register.items.name || 'Select Item'}}</span>
                            </td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-number="register.items.cost"
                                       buttons="no" e-title="Edit Cost">{{register.items.cost || 0.00 | number:2}}</a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-number='register.items.Quantity'
                                       buttons="no" e-title="Edit Price">{{register.items.Quantity || 0 | number:0}}</a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="popover-wrapper">
                                    <a editable-number='register.items.Discount'
                                       buttons="no" e-title="Edit Discount">{{register.items.Discount || 0 | number:0}}%</a>
                                </div>
                            </td>
                            <td class="text-center">{{(register.items.cost * register.items.Quantity) * (1 - ((register.items.Discount||0)/100)) || 0.00 | number:2}}</td>
                        </tr>
                        <tr class="register-item-bottom">
                            <td>&nbsp;</td>
                            <td colspan="5">
                                <dl class="register-item-extra-details dl-horizontal">
                                    <dt>Product Code</dt><dd>7</dd>
                                    <dt>Warehouse</dt><dd>None</dd>
                                    <dt class="visible-lg">Serial Number</dt>
                                    <dd class="visible-lg"></dd>
                                </dl>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-4 clearfix">
        <div class="register-box register-right">
            <div class="sale-buttons">
                <div class="btn-group">
                    <button type="button" class="btn btn-more dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu sales-dropdown" role="menu">
                        <li>
                            <a class="none suspended_sales_btn" title="Suspended Receivings"><i class="ion-ios-list-outline"></i> Suspended Receivings And <br> Purchase orders</a> </li>
                        <li>
                            <a class="none suspended_sales_btn" title="Create Purchase Order"><i class="ion-ios-paper"></i> Create Purchase Order</a> </li>
                        <li>
                            <a class="none suspended_sales_btn" title="Batch receiving"><i class="ion-bag"></i> Batch receiving</a> </li>
                    </ul>
                </div>
<!--                <form action="https://demo.phppointofsale.com/index.php/receivings/cancel_receiving" id="cancel_sale_form" autocomplete="off" method="post" accept-charset="utf-8">-->
                    <a href="" class="btn btn-suspended" id="suspend_recv_button">
                        <i class="ion-pause"></i>
                        Suspend </a>
                    <a href="" class="btn btn-cancel" id="cancel_sale_button">
                        <i class="ion-close-circled"></i>
                        Cancel Recv. </a>
<!--                </form>-->
            </div>
            <div class="customer-form" ng-show="false">
                <form>
                    <div class="input-group contacts">
                        <span class="input-group-addon">
                            <a class="none" title="New Supplier" id="new-customer"><i class="fa fa-search"></i></a> </span>
                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                        <input type="text" id="supplier" class="add-customer-input ui-autocomplete-input" 
                               placeholder="Type supplier's name..." />
                    </div>
                </form>
            </div> 
            <div class="customer-badge">
                <div class="avatar">
                    <img src="https://demo.phppointofsale.com/assets/img/user.png" alt="">
                </div>
                <div class="details">
                    <a tabindex="-1" href="https://demo.phppointofsale.com/index.php/suppliers/view/2/1" class="name">
                        Mdf (c g)</a>
                    <span class="email">g@g.com </span>
                    <a id="edit_supplier" class="btn btn-edit btn-primary pull-right" title="Update Supplier"><i class="fa fa-external-link"></i></a>
                </div>
            </div>
            <div class="customer-action-buttons">
                <a href="#" class="btn" id="toggle_email_receipt">
                    <i class="fa fa-envelope-o"></i> E-Mail PO?</a>
                <input type="checkbox" value="1" id="email_receipt" 
                       class="email_receipt_checkbox hidden">
                <a  class="btn"><i class="fa fa-times-circle"></i> Detach</a> 
            </div>
        </div>
        <div class="register-box register-summary paper-cut">
            <ul class="list-group">
                <li class="list-group-item global-discount-group" style="margin:15px 0 10px">
                    <div class="key">Discount all Items by %: </div>
                    <div class="value pull-right popover-wrapper">
                        <a editable-number='register.discount'
                           buttons="no">Set Discount</a> 
                    </div>
                </li>
                <li class="sub-total list-group-item">
                    <span>Sub Total:</span>
                    <span class="value">10</span>
                </li>
            </ul>
            <div class="amount-block">
                <div class="total amount-due">
                    <div class="side-heading">Items In Cart </div>
                    <div class="amount">1</div>
                </div>
                <div class="total amount">
                    <div class="side-heading">Total </div>
                    <div class="amount total-amount">$3.00 </div>
                </div>
            </div>
            <ul class="list-group payments">
                <li class="list-group-item">
                    <span class="key">
                        <a><i class="fa fa-times-circle"></i></a> Check</span>
                    <span class="value">$2.00 </span>
                </li>
            </ul>
            <div class="add-payment">
                <div class="side-heading">Add Payment</div>
                    <a tabindex="-1" href="#" class="btn btn-pay select-payment active" data-payment="Cash">
                    Cash </a>
                    <a tabindex="-1" href="#" class="btn btn-pay select-payment " data-payment="Check">
                    Check </a>
                    <a tabindex="-1" href="#" class="btn btn-pay select-payment " data-payment="Debit Card">
                    Debit Card </a>
                    <a tabindex="-1" href="#" class="btn btn-pay select-payment " data-payment="Credit Card">
                    Credit Card </a>
            </div>
            <div class="change-date">
                <input type="checkbox" value="1" id="change_receiving_date_enable" />
                <label for="change_receiving_date_enable">
                    <span></span>Change receiving date
                </label> 
                
                <div id="change_receiving_date_picker" class="input-group date datepicker" 
                     style="display: none;">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" value="03/01/2017 11:04 am" size="8" class="form-control" />
                </div>
                
                <div id="finish_sale" class="receivings-finish-sale">
                    <div class="input-group add-payment-form">
                        <select name="payment_type" class="input-medium hidden" id="payment_type">
                            <option value="Cash" selected="selected">Cash</option>
                            <option value="Check">Check</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                        <input type="text" placeholder="PO No." 
                               class="add-input form-control" maxlength="15"/>
                        <span class="input-group-addon">
                            <a class="no-transfer">Send Purchase Order</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="comment-block clearfix">
                <div class="side-heading"><label id="comment_label" for="comment">Comments : </label></div>
                <textarea name="comment" cols="40" rows="3" maxlength="100"
                          ng-maxlength="100" ng-model="register.Comments"
                          id="comment" class="form-control"></textarea>
                <div class="pull-right"><small>Character {{register.Comments.length}} of 100</small></div>
            </div>
            <div id="finish_sale" class="finish-sale">
                <input type="button" class="btn btn-success btn-large btn-block" 
                       id="finish_sale_button" value="Complete Sale">
            </div>
        </div>
    </div>
</div>