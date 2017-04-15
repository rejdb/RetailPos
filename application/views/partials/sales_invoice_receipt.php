<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li><a href="/">Sales</a></li>
                <li class="active"><span>Invoice</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Sales Invoice</h1>
                
                <div class="pull-right top-page-ui">
                    <button class="btn btn-primary" ng-print print-element-id="printReceipts"><i class="fa fa-print"></i> Print</button>
                    <a href="#/sales/invoice/history" class="btn btn-success pull-right" 
                       style="margin-left:5px">
                        <i class="fa fa-history fa-lg"></i> Logs
                    </a>
                    <a href="#/sales/invoice" class="btn btn-primary pull-right" style="margin-left:5px">
                        <i class="fa fa-plus-circle fa-lg"></i> New Sales
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
								<strong>Ref No.</strong>
								<span class="pull-right">{{register.header.RefNo}}</span>
							</div>
							<div class="invoice-date clearfix">
								<strong>Date:</strong>
								<span class="pull-right">{{register.header.TransDate | date:'MM/dd/yyyy'}}</span>
							</div>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6 invoice-box">
						<div class="invoice-icon hidden-sm">
							<i class="fa fa-home"></i>Branch
						</div>
                        <div class="invoice-date clearfix">
							<h4>{{register.header.Description}}</h4>
							<div>{{register.header.Address}}</div>
                            <div>{{register.header.BranchEmail}}</div>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6 invoice-box">
						<div class="invoice-icon hidden-sm">
							<i class="fa fa-user"></i>Customer
						</div>
						<div class="invoice-date">
                            <div class="invoice-date clearfix">
								<h4>{{register.customer.Fullname}}</h4>
                                <div><small>Email: {{register.customer.Email}}</small></div>
                                <div><small>Mobile: {{register.customer.ContactNo}}</small></div>
                                <div><small>Address: {{register.customer.Address}}</small></div>
                                <div ng-show="(register.header.IsMember=='1')"><small>Available Points Balance: {{(register.customer.CustPoints-0) + (register.customer.CustCredits-0) || 0 | peso:2}}</small></div>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-center"><span>Item Code</span></th>
								<th><span>Description</span></th>
                                <th class="text-center"><span>Unit price</span></th>
								<th class="text-center"><span>Quantity</span></th>
								<th class="text-center"><span>Total</span></th>
                                <th><span>Serial</span></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="row in register.rows | orderBy:'+ProductDesc'">
								<td class="text-center">{{row.BarCode}}</td>
								<td>{{row.ProductDesc}}</td>
                                <td class="text-center">{{row.PriceAfSub | peso:2}}</td>
								<td class="text-center">{{row.Quantity}}</td>
								<td class="text-center">{{row.TotalAfSub | peso:2}}</td>
                                <td>{{row.Serial}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="invoice-box-total clearfix">
                    <div class="row">
                        <div class="col-sm-3" style="padding-left:20px">
                            <b><i>Remarks:</i></b> {{register.header.Comments}}
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-7 col-md-8 col-xs-4 text-right invoice-box-total-label">
                                    Subtotal
                                </div>
                                <div class="col-sm-5 col-md-4 col-xs-8 text-right invoice-box-total-value">
                                    {{register.header.TotalAfSub | peso:2}}
                                </div>
                            </div>
                            <div class="row" ng-show="(config.IsPurchaseTaxable=='1')">
                                <div class="col-sm-7 col-md-8 col-xs-4 text-right invoice-box-total-label">
                                    VAT ({{config.InputTax}}%)
                                </div>
                                <div class="col-sm-5 col-md-4 col-xs-8 text-right 
                                            invoice-box-total-value">
                                    {{register.header.SalesTax | peso:2}}
                                </div>
                            </div>
                            <div class="row" ng-show="(register.header.Discount>0)">
                                <div class="col-sm-7 col-md-8 col-xs-4 text-right invoice-box-total-label">
                                    Discount ({{(register.header.Discount/register.header.NetTotal) * 100 | number:2}}%)
                                </div>
                                <div class="col-sm-5 col-md-4 col-xs-8 text-right 
                                            invoice-box-total-value">
                                    {{(register.header.Discount) *-1 | peso:2}}
                                </div>
                            </div>
                            <div class="row grand-total">
                                <div class="col-sm-7 col-md-8 col-xs-4 text-right invoice-box-total-label">
                                    Grand total
                                </div>
                                <div class="col-sm-5 col-md-4 col-xs-8 text-right invoice-box-total-value">
                                    {{register.header.NetTotal | peso:2}}
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				
				<div class="invoice-summary row">
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Return No.</span>
							<div>{{register.header.TransID}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Salesman</span>
							<div>{{register.header.DisplayName}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Date</span>
							<div>{{register.header.TransDate | dateFilter:'MM/dd/yyyy'}}</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<span>Net Sales</span>
							<div>{{register.header.NetTotal | peso:2}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/resources/js/app/sales.js"></script>