<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Purchasing</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Purchase Received with Serial</h1>
                
                <div class="pull-right top-page-ui">
                    <button class="btn btn-primary" ng-print print-element-id="printReceipts"><i class="fa fa-print"></i> Print</button>
                    <a href="#/purchase/history" class="btn btn-success pull-right" style="margin-left:5px">
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
					<div class="col-sm-4 col-xs-6 invoice-box">
						<div class="invoice-icon hidden-sm">
							<i class="fa fa-home"></i> Supplier
						</div>
						<div class="invoice-company">
                            <h4>{{purchase.header.CoyName}}</h4>
							<p>{{purchase.header.BillTo}}</p>
							<p>{{purchase.header.ContactPerson}}</p>
							<p>{{purchase.header.SupplierEmail}}</p>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6 invoice-box">
						<div class="invoice-icon hidden-sm">
							<i class="fa fa-truck"></i> Deliver To
						</div>
						<div class="invoice-date">
							<h4>{{purchase.header.Description}}</h4>
							<p>{{purchase.header.Address}}</p>
                            <p>{{purchase.header.BranchEmail}}</p>
						</div>
					</div>
					<div class="col-sm-4 col-xs-12 invoice-box invoice-box-dates">
						<div class="invoice-dates">
							<div class="invoice-number clearfix">
								<strong>Purchase no.</strong>
								<span class="pull-right">{{purchase.header.PONumber}}</span>
							</div>
							<div class="invoice-date clearfix">
								<strong>PO date:</strong>
								<span class="pull-right">{{purchase.header.TransDate | date:'MM/dd/yyyy'}}</span>
							</div>
							<div class="invoice-date invoice-due-date clearfix">
								<strong>Delivery date:</strong>
								<span class="pull-right">{{purchase.header.DeliveryDate | date:'MM/dd/yyyy'}}</span>
							</div>
                            <div class="invoice-date invoice-due-date clearfix">
								<strong>Trans No:</strong>
								<span class="pull-right">{{purchase.header.TransID}}</span>
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
								<th class="text-center"><span>Received <small>/Quantity</small></span></th>
								<th class="text-center"><span>Unit price</span></th>
								<th class="text-center"><span>Total</span></th>
								<th class="text-center"><span>Serial</span></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="row in purchase.rows">
								<td class="text-center">{{row.BarCode}}</td>
								<td>{{row.ProductDesc}}</td>
								<td class="text-center">{{row.ReceivedQty}} <small>/{{row.Quantity}}</small></td>
								<td class="text-center">{{row.Cost | peso:2}}</td>
								<td class="text-center">{{row.Total | peso:2}}</td>
								<td class="text-center">
                                    <ul>
                                        <li ng-repeat="serial in row.Serials">{{serial}}</li>
                                    </ul>
                                </td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="invoice-box-total clearfix">
                    <div class="row" ng-show="(config.IsPurchaseTaxable=='1')">
                        <div class="col-sm-9 col-md-10 col-xs-6 text-right invoice-box-total-label">
                            Subtotal
                        </div>
                        <div class="col-sm-3 col-md-2 col-xs-6 text-right invoice-box-total-value">
                            {{purchase.header.Total | peso:2}}
                        </div>
                    </div>
                    <div class="row" ng-show="(config.IsPurchaseTaxable=='1')">
                        <div class="col-sm-9 col-md-10 col-xs-6 text-right invoice-box-total-label">
                            VAT ({{config.InputTax}}%)
                        </div>
                        <div class="col-sm-3 col-md-2 col-xs-6 text-right 
                                    invoice-box-total-value">
                            {{purchase.header.GTotal - purchase.header.Total | peso:2}}
                        </div>
                    </div>
                    <div class="row grand-total">
                        <div class="col-sm-9 col-md-10 col-xs-6 text-right invoice-box-total-label">
                            Total
                        </div>
                        <div class="col-sm-3 col-md-2 col-xs-6 text-right invoice-box-total-value">
                            {{purchase.header.GTotal | peso:2}}
                        </div>
                    </div>
				</div>
                
                <div class="invoice-box-total" style="padding-left:50px">
                    <b><i>Remarks:</i></b> {{purchase.header.Comments}}
                </div>
				
				<div class="invoice-summary row">
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<div>{{purchase.header.DisplayName}}</div>
                            <span>Created By</span>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<div>Ken Hisada</div>
                            <span>Noted</span>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<div>Maricel Santos</div>
                            <span>Approved</span>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<div>Mitsuru Kikunaga</div>
                            <span>&nbsp;</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/resources/js/app/purchase.js"></script>