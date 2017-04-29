<!--<form ng-submit="saveConfig()" novalidate="novalidate">-->
<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><span>General Setting</span></li>
                <li class="active"><span>Configuration</span></li>
            </ol>

            <div class="clearfix">
                <h1 class="pull-left">Store Configuration <small>default store settings</small></h1>
                
                <div class="pull-right top-page-ui">
                    <button class="btn btn-primary pull-right" ng-click="saveConfig()">
                        <i class="fa fa-plus-circle fa-lg"></i> Save Config
                    </button>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class="main-box">
                <header class="main-box-header clearfix">
                    <h2>Company Information</h2>
                </header>
                <div class="main-box-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Company Name</label>
                            <div class="col-lg-10 input-group">
                                <input type="text" 
                                    class="form-control" 
                                    id="CompanyName" 
                                    ng-model="genSetup.CompanyName"
                                    required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Company Address</label>
                            <div class="col-lg-10 input-group">
                                <input type="text" 
                                    class="form-control" 
                                    id="CompanyAddress" 
                                    ng-model="genSetup.CompanyAddress"
                                    required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Website</label>
                            <div class="col-lg-10  input-group">
                                <input type="text" class="form-control" id="CompanyWebsite" ng-model="genSetup.Website" required="required" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="timeline-grid">
            <div class="item">
                <div class="col-sm-12 col-xs-12">
                    <div class="main-box">
                        <header class="main-box-header clearfix">
                            <h2>Tax &amp; Currency</h2>
                        </header>
                        <div class="main-box-body clearfix">
                            <div class="form-horizontal" role="form">
                                <div class="clearfix col-sm-12">
                                    <div class="form-group pull-left col-sm-6">
                                        <label class="control-label col-lg-6">Price Include Tax?:</label>
                                        <div class="checkbox-nice checkbox-inline">
                                            <input ng-model="genSetup.IsTaxInclude" type="checkbox" id="coyIncludeTax" />
                                            <label for="coyIncludeTax"></label>
                                        </div>
                                    </div>
                                    <div class="form-group pull-left col-sm-6">
                                        <label class="control-label col-lg-7">Purchase Include Tax?:</label>
                                        <div class="checkbox-nice checkbox-inline">
                                            <input ng-model="genSetup.IsPurchaseTaxable" type="checkbox" id="coyIncludePurTax" />
                                            <label for="coyIncludePurTax"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="CompanySaleTax" class="col-lg-3 control-label">Sales Tax</label>
                                    <div class="col-lg-7 input-group">
                                        <input type="number" 
                                            class="form-control" 
                                            id="CompanySaleTax" 
                                            ng-model="genSetup.SalesTax" 
                                            min=0 
                                            max=15
                                            required="required">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="CompanyInputTax" class="col-lg-3 control-label">Purchase Tax</label>
                                    <div class="col-lg-7 input-group">
                                        <input type="number" 
                                            class="form-control" 
                                            id="CompanyInputTax" 
                                            ng-model="genSetup.InputTax"  
                                            min=0 
                                            max=15
                                            required="required">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="col-sm-12 col-xs-12">
                    <div class="main-box">
                        <header class="main-box-header clearfix">
                            <h2>Sales &amp; Receipt</h2>
                        </header>
                        <div class="main-box-body clearfix">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-lg-3">Payment Types:</div>
                                    <div class="col-lg-9">
                                        <div class="btn-group">
                                            <label 
                                                class="btn btn-primary" 
                                                ng-repeat="payment in Payments"
                                                btn-checkbox-true="'1'" btn-checkbox-false="'0'"
                                                ng-model="payment.IsActive"
                                                btn-checkbox>{{ payment.PaymentName }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
<!--                                <pre>{{Payments | json}}</pre>-->
                                <form name="payform" ng-submit="newPaymentType(addNewPaymentType)" novalidate="novalidate"><br/>
                                    <div class="form-group col-sm-offset-3">
                                        <div class="input-group col-sm-10">
                                            <span class="input-group-addon">New</span>
                                            <input type="text" class="form-control" 
                                                   ng-model="addNewPaymentType"
                                                   placeholder="Add payment type" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <!--<div class="col-lg-3">Default Payment: </div>-->
                                    <label for="DefPayment" class="col-lg-3 control-label">Default Payment:</label>
                                    <div class="col-lg-7">
                                        <select id="DefPayment" class="form-control" required="required" ng-model="genSetup.DefPayment">
                                            <option 
                                                ng-repeat="payment in Payments" 
                                                ng-selected="{{genSetup.DefPayment == payment.PaymentId}}"
                                                value="{{ payment.PaymentId }}">{{ payment.PaymentName }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group"><br/>
                                    <label for="CompanyReturnPolicy" class="col-lg-3 control-label">Return Policy</label>
                                    <div class="col-lg-7">
                                        <input type="number" 
                                            class="form-control" 
                                            id="CompanyReturnPolicy" 
                                            ng-change="changePolicyDesc()"
                                            ng-model="genSetup.DefaultReturnPolicy" 
                                            min=0 
                                            max=90
                                            required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group"><br/>
                                    <label for="CompanyReturnDesc" class="col-lg-3 control-label">Receipt Policy Desc.:</label>
                                    <div class="col-lg-7">
                                        <input type="text" 
                                            class="form-control" 
                                            id="CompanyReturnDesc" 
                                            ng-model="genSetup.ReceiptMessage" 
                                            required="required">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item main-box">
                <header class="main-box-header clearfix">
                    <div class="pull-left"><h2>Loyalty Points</h2></div>
                    <a class="btn pull-right" 
                       ng-init="addPoints=true" 
                       ng-class="{'btn-primary': addPoints, 'btn-default': !addPoints}"
                       ng-click="addPoints = !addPoints">
                        <i class="fa fa-plus-circle fa-lg"></i></a>
                </header>
                <div class="main-box-body clearfix" style="padding:0px 70px;">
                    <div class="form-group">
                        <label>Points Computation: </label>
                        <div class="btn-group">
                            <label class="btn btn-primary" btn-radio="1" ng-model="genSetup.UsedComputation">Percentage</label>
                            <label class="btn btn-primary" btn-radio="0" ng-model="genSetup.UsedComputation">Peso Value</label>
                        </div>
                    </div>
                    <div collapse="addPoints">
                        <form ng-submit="addNewPoints()" novalidate="novalidate" name="pointer">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" 
                                           ng-min=0 min=0 required
                                           ng-maxlength="10" placeholder="Minimum Purchase"
                                           ng-model="addiPoints.Amount">
                                    <span class="input-group-addon">Pts.</span>
                                    <input type="number" class="form-control" 
                                           ng-min=0 min=0 ng-max=100 max=100 required
                                           ng-maxlength="10" placeholder="Point Equivalent"
                                           ng-model="addiPoints.Percent">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fa fa-check fa-lg"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Purchace Value</th>
                            <th class="text-center">Points / Percent</th>
                            <th></th>
                        </tr>
                        <tr ng-repeat="p in points">
                            <td><a editable-number="p.Amount"
                                   onbeforesave="updatePoint(p.PointID, 'Amount', $data)">
                                {{p.Amount | peso:2}}</a></td>
                            <td class="text-center">
                                <span class="popover-wrapper">
                                <a editable-number="p.Percent" buttons="no"
                                   onaftersave="updatePoint(p.PointID, 'Percent', $data-0)">
                                    {{p.Percent | number:0}}{{(genSetup.UsedComputation==1) ? '%':' pesos'}}
                                </a>
                                </span>
                            </td>
                            <td><a ng-click="removePoint($index, p.PointID)"><i class="fa fa-times-circle fa-lg"></i></a></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="item main-box">
                <header class="main-box-header clearfix">
                    <div class="pull-left"><h2>Inventory Warehouse</h2></div>
                    <a class="btn pull-right" 
                       ng-init="addWhs=true" 
                       ng-class="{'btn-primary': addWhs, 'btn-default': !addWhs}"
                       ng-click="addWhs = !addWhs">
                        <i class="fa fa-plus-circle fa-lg"></i></a>
                </header>
                <div class="main-box-body clearfix" style="padding:0px 70px;">
                    <div collapse="addWhs">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" 
                                       ng-maxlength="50" placeholder="Enter Warehouse Name"
                                       ng-model="addiWhs.WhsName">
                                <span class="input-group-btn">
                                    <button ng-click="addNewWhs()" class="btn btn-primary"><i class="fa fa-check fa-lg"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th class="text-center">No Price</th>
                            <th class="text-center">Active</th>
                        </tr>
                        <tr ng-repeat="whs in warehouses">
                            <td><a editable-text="whs.WhsName"
                                   onbeforesave="updateWhs(whs.WhsCode, 'WhsName', $data)">{{whs.WhsName}}</a></td>
                            <td class="text-center">
                                <span class="popover-wrapper">
                                <a editable-checkbox="whs.FreeWhs" buttons="no"
                                   class="label" style="color:white"
                                   onaftersave="updateWhs(whs.WhsCode, 'FreeWhs', $data-0, true)"
                                   ng-class="{'label-warning':(whs.FreeWhs=='1'),'label-info':(whs.FreeWhs=='0')}"
                                   e-ng-true-value="1" e-ng-false-value="0"
                                   e-title="Regular Warehouse?">{{(whs.FreeWhs=='1') ? 'No':'Yes'}}</a>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="popover-wrapper">
                                <a editable-checkbox="whs.IsActive" buttons="no"
                                   class="label" style="color:white"
                                   onaftersave="updateWhs(whs.WhsCode, 'IsActive', $data-0, true)"
                                   ng-class="{'label-success':(whs.IsActive=='1'),'label-danger':(whs.IsActive=='0')}"
                                   e-ng-true-value="1" e-ng-false-value="0"
                                   e-title="{{(whs.IsActive=='0') ? 'Activate':'Deactivate'}} this Warehouse?">{{(whs.IsActive=='0') ? 'No':'Yes'}}</a>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="item main-box">
                <header class="main-box-header clearfix">
                    <div class="pull-left"><h2>Credit Card Terminal</h2></div>
                    <a class="btn pull-right" 
                       ng-init="addBank=true" 
                       ng-class="{'btn-primary': addBank, 'btn-default': !addBank}"
                       ng-click="addBank = !addBank">
                        <i class="fa fa-plus-circle fa-lg"></i></a>
                </header>
                <div class="main-box-body clearfix" style="padding:0px 70px;">
                    <div collapse="addBank">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" 
                                       ng-maxlength="50" placeholder="Enter Bank Name"
                                       ng-model="addiBank.BankName">
                                <span class="input-group-btn">
                                    <Button ng-click="addNewBank()" class="btn btn-primary"><i class="fa fa-check fa-lg"></i></Button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Bank Name</th>
                            <th class="text-center">Active</th>
                        </tr>
                        <tr ng-repeat="t in terminals">
                            <td><a editable-text="t.BankName"
                                   onbeforesave="updateBank(t.BankID, 'BankName', $data)">{{t.BankName}}</a></td>
                            <td class="text-center">
                                <span class="popover-wrapper">
                                <a editable-checkbox="t.IsActive" buttons="no"
                                   class="label" style="color:white"
                                   onaftersave="updateBank(t.BankID, 'IsActive', $data-0, true)"
                                   ng-class="{'label-success':(t.IsActive=='1'),'label-danger':(t.IsActive=='0')}"
                                   e-ng-true-value="1" e-ng-false-value="0"
                                   e-title="{{(t.IsActive=='0') ? 'Activate':'Deactivate'}} this Terminal?">{{(t.IsActive=='0') ? 'No':'Yes'}}</a>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="item main-box">
                <header class="main-box-header clearfix">
                    <div class="pull-left"><h2>Installments</h2></div>
                    <a class="btn pull-right" 
                       ng-init="addInst=true" 
                       ng-class="{'btn-primary': addInst, 'btn-default': !addInst}"
                       ng-click="addInst = !addInst">
                        <i class="fa fa-plus-circle fa-lg"></i></a>
                </header>
                <div class="main-box-body clearfix" style="padding:0px 70px;">
                    <div collapse="addInst">
                        <form ng-submit="addNewInstallment()" novalidate="novalidate" name="insts">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" 
                                           ng-min=0 min=0 required
                                           ng-maxlength="30" placeholder="Description"
                                           ng-model="addiInst.InstDesc">
                                    <span class="input-group-addon">%</span>
                                    <input type="number" class="form-control" 
                                           ng-min=0 min=0 ng-max=100 max=100 required
                                           ng-maxlength="10" placeholder="Percent"
                                           ng-model="addiInst.InstValue">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fa fa-check fa-lg"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Description</th>
                            <th class="text-center">Percent</th>
                            <th class="text-center">Active</th>
                        </tr>
                        <tr ng-repeat="p in installments">
                            <td><a editable-text="p.InstDesc"
                                   onbeforesave="updateInsts(p.InsId, 'InstDesc', $data)">
                                {{p.InstDesc | uppercase}}</a></td>
                            <td class="text-center">
                                <span class="popover-wrapper">
                                <a editable-number="p.InstValue" buttons="no"
                                   onaftersave="updateInsts(p.InsId, 'InstValue', $data-0, true)">
                                    {{p.InstValue | number:0}}%
                                </a>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="popover-wrapper">
                                <a editable-checkbox="p.IsActive" buttons="no"
                                   class="label" style="color:white"
                                   onaftersave="updateInsts(p.InsId, 'IsActive', $data-0, true)"
                                   ng-class="{'label-success':(p.IsActive=='1'),'label-danger':(p.IsActive=='0')}"
                                   e-ng-true-value="1" e-ng-false-value="0"
                                   e-title="{{(p.IsActive=='0') ? 'Activate':'Deactivate'}} this Installment Rate?">{{(p.IsActive=='0') ? 'No':'Yes'}}</a>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>  
        </div>
    </div>
</div>
<!--</form>-->

<!--<pre>{{ Payments | json }}</pre>-->
<script src="/resources/js/app/gen_config.js"></script>