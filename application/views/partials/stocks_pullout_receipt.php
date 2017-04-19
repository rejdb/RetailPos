<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Stock Management</a></li>
                <li class="active"><span>Pull-out</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Pull-out Receipt</h1>
                
                <div class="pull-right top-page-ui">
                    <div class="btn-group">
                        <a href="#/stocks/pullout/history" class="btn btn-success" 
                           style="margin-left:5px">
                            <i class="fa fa-history fa-lg"></i> History
                        </a>
                        <button type="button" class="btn btn-success dropdown-toggle" 
                                data-toggle="dropdown">
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu sales-dropdown" role="menu">
                            <li permission="[1,5]" ng-show="(register.header.Status==1)">
                                <a class="none suspended_sales_btn" 
                                   title="Approved Pullout"
                                   ng-click="PulloutStatus(register.header.TransID, 2)">
                                    <i class="ion-ios-checkmark-outline"></i> 
                                    Approved Pullout</a> 
                            </li>
                            <li permission="[1,5]" ng-show="(register.header.Status==1)">
                                <a class="none suspended_sales_btn"
                                   ng-click="PulloutStatus(register.header.TransID, 4)"
                                   title="Cancel Pullout"><i class="ion-ios-close"></i> Cancel Pullout</a> </li>
                            <li permission="[1,5]" ng-show="(register.header.Status==1)" class="divider"></li>
                            
                            <li ng-show="(register.header.Status==2 && register.header.Branch==userProfile.Branch.BranchID)">
                                <a class="none suspended_sales_btn" 
                                   ng-click="PulloutStatus(register.header.TransID, 3)"
                                   title="Confirmed Pullout"><i class="ion-ios-checkmark-outline"></i> Confirmed Pullout</a> </li>
                            <li ng-show="(register.header.Status<=2 && register.header.Branch==userProfile.Branch.BranchID)">
                                <a class="none suspended_sales_btn" 
                                   ng-click="PulloutStatus(register.header.TransID, 4)"
                                   title="Cancel Pullout"><i class="ion-ios-close"></i> Cancel Pullout</a> </li>
                            <li ng-show="(register.header.Status==2 && register.header.Branch==userProfile.Branch.BranchID)" class="divider"></li>
                            <li><a href="#/stocks/pullout"><i class="ion-ios-compose-outline"></i> Create Pullout</a></li>
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
                    <div class="col-sm-4 col-xs-4 invoice-box">
						<div class="invoice-dates col-xs-12">
							<div class="invoice-number clearfix">
								<strong>Ref No.</strong>
								<span class="pull-right">{{register.header.RefNo}}</span>
							</div>
							<div class="invoice-date clearfix">
								<strong>Date:</strong>
								<span class="pull-right">{{register.header.TransDate | date:'MM/dd/yyyy'}}</span>
							</div>
                            <div class="clearfix">
								<strong><small>Status:</small></strong>
								<span class="pull-right label" ng-class="{'label-warning':(register.header.Status=='1'), 
                                     'label-success':(register.header.Status=='2'),
                                     'label-info':(register.header.Status=='3'), 
                                     'label-danger':(register.header.Status=='4')}">
                                    <small>{{register.header.Status-0 | pulloutStatus}}</small>
                                </span>
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-xs-4 invoice-box">
                        <div class="invoice-company">
							<h4>{{register.header.Description}}</h4>
							<p>{{register.header.Address}}</p>
                            <p>{{register.header.BranchEmail}}</p>
						</div>
					</div>
					<div class="col-sm-4 col-xs-4 invoice-box">
						<div class="invoice-icon col-xs-1 hidden-sm">
							<i class="fa fa-comments"></i>Remarks
						</div>
						<div class="invoice-date col-xs-10 clearfix">
                            <div class="invoice-date clearfix">
								<span>{{register.header.Comments}}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th><span>Item Code</span></th>
								<th><span>Description</span></th>
								<th><span>Warehouse</span></th>
								<th class="text-center"><span>Quantity</span></th>
								<th class="text-center"><span>Unit price</span></th>
								<th class="text-center"><span>Total</span></th>
                                <th><span>Serial</span></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="row in register.rows | orderBy:'+ProductDesc'">
								<td><small>{{row.BarCode}}</small></td>
								<td>{{row.ProductDesc}}</td>
								<td>{{row.WhsName}}</td>
								<td class="text-center">{{row.Quantity}}</td>
								<td class="text-center">{{row.Cost | peso:2}}</td>
								<td class="text-center">{{row.Total | peso:2}}</td>
                                <td>{{row.Serial}}</td>
							</tr>
							<tr>
								<td colspan=3 class="text-right"><b>Total Quantity</b></td>
								<td class="text-center">{{register.header.Quantity | number:0}}</td>
								<td colspan=3 class="text-center">&nbsp;</td>
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
							<span>Confirmed By</span>
							<div>{{register.header.ConfirmedBy || '&nbsp;'}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/resources/js/app/pullout.js"></script>