<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Stock Management</a></li>
                <li class="active"><span>Transfer</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Transfer Receipt</h1>
                
                <div class="pull-right top-page-ui">
                    <div class="btn-group">
                        <a href="#/stocks/transfer/history" class="btn btn-success" 
                           style="margin-left:5px">
                            <i class="fa fa-history fa-lg"></i> History
                        </a>
                        <button type="button" class="btn btn-success dropdown-toggle" 
                                data-toggle="dropdown">
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu sales-dropdown" role="menu">
                            <li permission="[1,5]" ng-show="(register.header.Status==1)">
                                <a class="none suspended_sales_btn" 
                                   title="Approved Transfer"
                                   ng-click="TransferStatus(register.header.TransID, 2, register.header.InvTo)">
                                    <i class="ion-ios-checkmark-outline"></i> 
                                    Approved Transfer</a> 
                            </li>
                            <li permission="[1,5]" ng-show="(register.header.Status==1)">
                                <a class="none suspended_sales_btn"
                                   ng-click="TransferStatus(register.header.TransID, 4, register.header.InvTo)"
                                   title="Cancel Transfer"><i class="ion-ios-close"></i> Cancel Transfer</a> </li>
                            <li permission="[1,5]" ng-show="(register.header.Status==1)" class="divider"></li>
                            
                            <li ng-show="(register.header.Status==2 && register.header.InvTo==userProfile.Branch.BranchID)">
                                <a class="none suspended_sales_btn" 
                                   ng-click="TransferStatus(register.header.TransID, 3, register.header.InvTo)"
                                   title="Received Transfer"><i class="ion-ios-checkmark-outline"></i> Received Transfer</a> </li>
                            <li ng-show="(register.header.Status==2 && register.header.InvTo==userProfile.Branch.BranchID)">
                                <a class="none suspended_sales_btn" 
                                   ng-click="TransferStatus(register.header.TransID, 4, register.header.InvTo)"
                                   title="Cancel Transfer"><i class="ion-ios-close"></i> Cancel Transfer</a> </li>
                            <li ng-show="(register.header.Status==2 && register.header.InvTo==userProfile.Branch.BranchID)" class="divider"></li>
                            <li><a href="#/stocks/transfer"><i class="ion-ios-compose-outline"></i> Create Transfer</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary" ng-print print-element-id="printReceipts"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </div>
	</div>
</div>

<div class="row" id="printReceipts">
	<div class="col-lg-12">
		<div class="main-box clearfix">
			<header class="main-box-header clearfix">
				<div style="padding:20px 0 0 0">
                    <div class="pull-left col-xs-4 col-sm-2">
                        <img ng-src="/resources/img/avatar/store/{{config.Avatar}}" width="100%" height="75"/>
                    </div>
                    <div class="col-xs-8 col-sm-10 pull-left">
                        <span class="user-link"><h2>{{config.CompanyName}}</h2></span>
                        <span class="user-subhead col-xs-12 col-sm-7">{{config.CompanyAddress}}</span>
                    </div>
                </div>
			</header>
			
			<div class="main-box-body clearfix">
				<div id="invoice-companies" class="row">
<!--                    <div class="invoice-box hidden-sm"></div>-->
                    <div class="col-sm-4 col-xs-12 invoice-box">
                        <div class="invoice-icon col-xs-1 hidden-sm">
							<i class="ion-clipboard"></i>
						</div>
						<div class="invoice-dates col-xs-10">
							<div class="invoice-number clearfix">
								<strong>Ref No.</strong>
								<span class="pull-right">{{register.header.TransferNo}}</span>
							</div>
							<div class="invoice-date clearfix">
								<strong>Date:</strong>
								<span class="pull-right">{{register.header.TransDate | date:'MM/dd/yyyy'}}</span>
							</div>
                            <div class="clearfix">
								<strong><small>Type:</small></strong>
								<span class="pull-right"><small>{{(register.header.TransferType==1) ? 'Warehouse':'Branch'}} Transfer</small></span>
							</div>
                            <div class="clearfix">
								<strong><small>Status:</small></strong>
								<span class="pull-right label" ng-class="{'label-warning':(register.header.Status=='1'), 'label-success':(register.header.Status=='2'),
                                          'label-info':(register.header.Status=='3'), 'label-danger':(register.header.Status=='4')}">
                                    <small>{{register.header.Status-0 | transferStatus}}</small></span>
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6 invoice-box">
						<div class="invoice-icon hidden-sm">
							<i class="fa fa-home"></i> Branch
						</div>
                        <div class="invoice-company">
							<h4>{{register.header.Description}}</h4>
							<p>{{register.header.Address}}</p>
                            <p>{{register.header.BranchEmail}}</p>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6 invoice-box">
						<div class="invoice-icon col-xs-1 hidden-sm">
							<i class="ion-code-working"></i>
						</div>
						<div class="invoice-date col-xs-10 clearfix">
                            <div class="invoice-number clearfix" ng-hide="(register.header.TransferType==0 && register.header.Status!=3)">
								<strong>From: </strong>
								<span class="pull-right">{{Filler(register.header.InvFrom, register.header.TransferType)}}</span>
							</div>
                            <div class="invoice-date clearfix">
								<strong>To: </strong>
								<span class="pull-right">{{Filler(register.header.InvTo, register.header.TransferType)}}</span>
							</div>
                            <div class="invoice-date clearfix" ng-show="(register.header.TransferType==0)">
								<strong>Warehouse: </strong>
								<span class="pull-right">{{register.rows[0].WhsName}}</span>
							</div>
						</div>
					</div>
				</div>
<!--				<div id="invoice-companies" class="row">-->
                    <div>
                        Remarks: {{register.header.Comments}}
                    </div><br/>
<!--                </div>-->
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-center"><span>Item Code</span></th>
								<th><span>Description</span></th>
								<th><span>Warehouse</span></th>
								<th class="text-center"><span>Quantity</span></th>
								<th class="text-center"><span>Unit price</span></th>
								<th class="text-center"><span>Total</span></th>
                                <th><span>Serial</span></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="row in register.rows">
								<td class="text-center">{{row.BarCode}}</td>
								<td>{{row.ProductDesc}}</td>
								<td>{{row.WhsName}}</td>
								<td class="text-center">{{row.Quantity}}</td>
								<td class="text-center">{{row.Cost | peso:2}}</td>
								<td class="text-center">{{row.Total | peso:2}}</td>
                                <td>{{row.Serial}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="invoice-box-total clearfix">
					<div class="row">
						<div class="col-sm-9 col-md-10 col-xs-6 text-right invoice-box-total-label">
							Subtotal
						</div>
						<div class="col-sm-3 col-md-2 col-xs-6 text-right invoice-box-total-value">
							{{register.header.Total | peso:2}}
						</div>
					</div>
					<div class="row" ng-show="(config.IsPurchaseTaxable=='1')">
						<div class="col-sm-9 col-md-10 col-xs-6 text-right invoice-box-total-label">
							VAT ({{config.InputTax}}%)
						</div>
						<div class="col-sm-3 col-md-2 col-xs-6 text-right 
                                    invoice-box-total-value">
						</div>
					</div>
					<div class="row grand-total">
						<div class="col-sm-9 col-md-10 col-xs-6 text-right invoice-box-total-label">
							Grand total
						</div>
						<div class="col-sm-3 col-md-2 col-xs-6 text-right invoice-box-total-value">
							{{register.header.Total | peso:2}}
						</div>
					</div>
				</div>
				
				<div class="invoice-summary row">
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Transaction No.</span>
							<div>{{register.header.TransID}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Requested By</span>
							<div>{{register.header.DisplayName}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Approved / Canceled By</span>
							<div>{{register.header.ApprovedBy || '&nbsp;'}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Received By</span>
							<div>{{register.header.ReceivedBy || '&nbsp;'}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/resources/js/app/transfer.js"></script>