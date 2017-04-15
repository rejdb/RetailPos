<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Stock Management</a></li>
                <li class="active"><span>Receiving</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Receiving Receipt</h1>
                
                <div class="pull-right top-page-ui">
                    <button class="btn btn-primary" ng-print print-element-id="printReceipts"><i class="fa fa-print"></i> Print</button>
                    <a href="#/stocks/receiving/history" class="btn btn-success pull-right" style="margin-left:5px">
                        <i class="fa fa-history"></i> Logs
                    </a>
                    <a href="#/stocks/receiving" class="btn btn-primary pull-right" style="margin-left:5px">
                        <i class="fa fa-plus-circle fa-lg"></i> New Receiving
                    </a>
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
								<strong>Invoice no.</strong>
								<span class="pull-right">{{register.header.InvoiceNo}}</span>
							</div>
							<div class="invoice-date clearfix">
								<strong>Date:</strong>
								<span class="pull-right">{{register.header.TransDate | date:'MM/dd/yyyy'}}</span>
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
						<div class="invoice-icon hidden-sm">
							<i class="ion-android-chat"></i> Remarks
						</div>
						<div class="invoice-company">
							<p>{{register.header.Comments}}</p>
						</div>
					</div>
				</div>
				
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
							{{register.header.GTotal - register.header.Total | peso:2}}
						</div>
					</div>
					<div class="row grand-total">
						<div class="col-sm-9 col-md-10 col-xs-6 text-right invoice-box-total-label">
							Grand total
						</div>
						<div class="col-sm-3 col-md-2 col-xs-6 text-right invoice-box-total-value">
							{{register.header.GTotal | peso:2}}
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
							<span>Received By</span>
							<div>{{register.header.DisplayName}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Transaction Date</span>
							<div>{{register.header.TransDate | date:'MM/dd/yyyy'}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Total</span>
							<div>{{register.header.GTotal | peso:2}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/resources/js/app/receiving.js"></script>