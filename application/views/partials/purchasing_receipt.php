<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Purchasing</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Purchase Receipt</h1>
                
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
			<div class="main-box-body clearfix" style="padding:30px">
				<div class="row">
					<div class="container">
						<div class="col-sm-1 col-xs-2">
							<img ng-src="/resources/img/avatar/store/{{config.Avatar}}" width="100%" height="65"/>
						</div>
						<div class="col-sm-5 col-xs-6">
							<h2>{{config.CompanyName}}</h2>
							<p>{{config.CompanyAddress}}</p>
						</div>
						<div class="col-sm-6 col-xs-4">&nbsp;</div>
					</div>
				</div>

				<div class="row" style="margin-top:20px">
					<div class="container">
						<div class="col-sm-6 col-xs-4">
							<h2>{{purchase.header.CoyName}}</h2>
							<p style="margin-bottom:0">Address: {{purchase.header.BillTo}}</p>
							<p style="margin-bottom:0">Contact: {{purchase.header.ContactPerson}}</p>
							<p style="margin-bottom:0">Email: {{purchase.header.SupplierEmail}}</p>
						</div>
						<div class="col-sm-2 col-xs-3">&nbsp;</div>
						<div class="col-sm-4 col-xs-5">
							<h1 style="padding-left:0">PURCHASE ORDER</h1>
							<p style="margin-bottom:0">Date: {{purchase.header.TransDate | date:'MM/dd/yyyy'}}</p>
							<p style="margin-bottom:0">P.O Number: {{purchase.header.PONumber}}</p>
							<p>Ref: {{purchase.header.TransID}}</p>
						</div>
					</div>
				</div>
				
				<div class="table-responsive" style="margin-top:20px">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th><span>Item Code</span></th>
								<th><span>Description</span></th>
								<th class="text-center"><span>DP</span></th>
								<th class="text-center"><span>Order QTY</span></th>
								<th class="text-center"><span>Amoount</span></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="row in purchase.rows">
								<td><small>{{row.BarCode}}</small></td>
								<td>{{row.ProductDesc}}</td>
								<td class="text-center">{{row.Cost | peso:2}}</td>
								<td class="text-center">{{row.Quantity | number:0}}</td>
								<td class="text-center">{{row.GTotal | peso:2}}</td>
							</tr>
							<tr>
								<td colspan=3 class="text-right">&nbsp;</td>
								<td class="text-center">{{purchase.header.Quantity | number:0}}</td>
								<td class="text-center">{{purchase.header.GTotal | peso:2}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				
                
                <div class="invoice-box-total">
                    <b><i>Remarks:</i></b> {{purchase.header.Comments}}
					<p style="margin-bottom:0">Delivery Date {{purchase.header.DeliveryDate | date:'MM/dd/yyyy'}}</p>
					<p style="margin-bottom:0">Delivery to {{purchase.header.Description}}</p>
					<p>Address: {{purchase.header.Address}}</p>
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
                            <span>Noted By</span>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<div>Maricel Santos</div>
                            <span>Approved By</span>
						</div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-3">
						<div class="invoice-summary-item">
							<div>Mitsuru Kikunaga</div>
                            <span>Approved By</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/resources/js/app/purchase.js"></script>