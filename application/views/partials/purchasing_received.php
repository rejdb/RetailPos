<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Purchasing</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Purchase Received</h1>
                
                <div class="pull-right top-page-ui">
<!--                    <button class="btn btn-primary" ng-click="loadSerial('13','1')"><i class="fa fa-print"></i> Reload</button>-->
                    <a href="#/purchase/history" class="btn btn-success pull-right" style="margin-left:5px">
                        <i class="fa fa-list fa-lg"></i> Transaction History
                    </a>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row register">
    <div class="col-sm-9">
        <div class="register-box clearfix">
            <div class="table-responsive">
                <table class="table user-list table-hover">
                    <thead>
                        <tr>
                            <th><span>Item Name<small>/supplier</small></span></th>
                            <th class="text-center"><span>Warehouse</span></th>
                            <th class="text-center"><span>Received<small>/QTY</small></span></th>
                            <th class="text-center"><span>Enter <small>Quantity || Serial</small></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="b in filtered = po.rows">
                            <td>
                                <img src="/resources/img/avatar/products/default_product.jpeg" alt="{{user.Avatar}}"/>
                                <span class="user-link">{{b.ProductDesc}}</span>
                                <span class="user-subhead">
                                    Product Code: {{b.BarCode}}
                                </span>
                            </td>
                            <td class="text-center">{{b.WhsName}}</td>
                            <td class="text-center" ng-show="(b.IsSerialized=='0')">{{b.ReceivedQty | number:0}} /<small>{{b.Quantity || 0}}</small></td>
                            <td class="text-center" ng-show="(b.IsSerialized=='1')">{{b.Serials.length | number:0}} /<small>{{b.Quantity || 0}}</small></td>
                            <td class="text-center" >
                                <span ng-show="(b.IsSerialized=='0')" class="popover-wrapper">
                                    <a editable-number="b.ReceivedQty" buttons="no" e-min="0" onbeforesave="updateReceivedQty(b.PurRowID, $data-0, po, $index, b.ReceivedQty-0)"
                                       edit-disabled="po.header.Status=='2' || po.header.Status=='3'"
                                       e-title="Enter Item Quantity" e-max="{{b.Quantity}}">{{b.ReceivedQty-0 || 'Enter Quantity'}}</a>
                                </span>
                                <span ng-show="(b.IsSerialized=='1')">
                                    <a editable-tags-input="b.Serials" e-placeholder="Add Serial" e-max-length="20" e-max-tags="{{b.Quantity}}"
                                       edit-disabled="po.header.Status=='2' || po.header.Status=='3'"
                                       e-on-tag-adding="checkSerial($data, po, $tag, $index, true)"
                                       e-on-tag-removing="checkSerial($data, po, $tag, $index, false)"
                                       e-add-on-blur="false" buttons="no"
                                       e-ng-blur="addSerial($index, $data, b.ReceivedQty)"
                                       onbeforesave="countSerial(b, $data)">
                                      <ul style="list-style: none">
                                        <li ng-repeat="serial in b.Serials">{{serial.text || serial}}</li>  
                                      </ul> Add Serial
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
<!--        <pre>{{po | json}}</pre>-->
    </div>
    <div class="col-sm-3">
        <div class="register-box register-right">
            <div class="sale-buttons">
                <span ng-hide="po.header.Status=='2' || po.header.Status=='3'">
                    <span ng-show="((po.header.Quantity-0)!=(po.header.ReceivedQty-0))">
                        <a ng-click="updateStatus((po.header.ReceivedQty>0) ? 1:3, po.header)" 
                           class="btn btn-suspended" id="suspend_recv_button">
                            <i class="ion-pause"></i> {{(po.header.ReceivedQty>0) ? 'Mark as Partial':'Cancel P.O.'}} </a>
                    </span>
                    <span ng-show="(po.header.ReceivedQty>0)" ng-cloak>
                        <a ng-click="updateStatus(2, po.header)" class="btn btn-cancel" id="cancel_sale_button">
                        <i class="ion-close-circled"></i> Mark as {{((po.header.Quantity-0)==(po.header.ReceivedQty-0)) ? 'Completed':'Closed'}} </a>
                    </span>
                </span>
            </div>
            <div class="customer-badge">
                <div class="avatar">
                    <i class="fa fa-truck fa-4x"></i>
<!--                    <img src="/resources/img/avatar/store/tbx.png" alt="">-->
                </div>
                <div class="details">
                    <a class="name">{{po.header.Description}}</a>
                    <div class="email">{{po.header.BranchEmail}}</div>
                </div>
            </div>
            <div class="customer-badge">
                <div class="avatar">
                    <i class="fa fa-home fa-4x"></i>
<!--                    <img src="/resources/img/avatar/agent/default.png" alt="">-->
                </div>
                <div class="details">
                    <a class="name">{{po.header.CoyName}}</a>
                    <span class="email">{{po.header.SupplierEmail}}</span><br/>
                    <span class="email">{{po.header.ContactPerson}}</span>
                </div>
            </div>
            <div class="customer-action-buttons">
                <a href="" class="btn" id="toggle_email_receipt">
                    <!--i class="fa fa-envelope-o"></i--> {{'PO: ' +po.header.PONumber}}</a>
                <input type="checkbox" value="1" id="email_receipt" 
                       class="email_receipt_checkbox hidden">
                <a href="#/purchase/history" class="btn"><i class="fa fa-arrow-circle-left"></i> Back</a> 
            </div>
        </div>
        <div class="register-box register-summary paper-cut">
            <ul class="list-group">
                <li class="sub-total list-group-item">
                    <span>Total:</span>
                    <span class="value">{{po.header.GTotal | peso:2}}</span>
                </li>
            </ul>
            <div class="amount-block">
                <div class="total amount-due">
                    <div class="side-heading">Qty to Receive </div>
                    <div class="amount">{{po.header.Quantity | number:0}}</div>
                </div>
                <div class="total amount">
                    <div class="side-heading">Received Qty </div>
                    <div class="amount total-amount">{{po.header.ReceivedQty | number:0}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/purchase.js"></script>