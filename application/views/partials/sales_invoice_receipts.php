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
	<div class="col-xs-12">
		<div class="main-box clearfix" style="width:100%">
			<header class="main-box-header col-xs-12 clearfix">
				<div class="col-xs-8 col-sm-9">
                    <div class="col-xs-2 hidden-xs">
                        <img ng-src="/resources/img/avatar/store/{{config.Avatar}}" width="100%" height="75"/>
                    </div>
                    <div class="col-xs-10">
                        <span class="user-link"><h2 class="hidden-xs">{{config.CompanyName}}</h2></span>
                        <span class="col-xs-12 col-sm-7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <span class="col-xs-4 col-sm-3 text-center">
                    <h1><span class="hidden-xs">Sales Invoice</span></h1>
                    <h2><span class="hidden-xs">No. {{register.header.RefNo}}</span></h2>
                    {{register.header.TransDate | date:'MM/dd/yyyy'}}
                </span>
			</header>
			
			<div class="main-box-body col-xs-12 clearfix">
                <div class="row" style="margin-top:20px">
                    <div class="col-xs-2 col-sm-1 col-sm-offset-1"><span class="hidden-xs">Sold To:</span></div>
                    <div class="col-xs-5 col-sm-6 text-left">{{register.customer.Fullname}}</div>
                    <div class="col-xs-2 col-sm-2"><span class="hidden-xs">TIN/SC-TIN</span></div>
                    <div class="col-xs-2 col-sm-2"></div>
                </div>
                <div class="row">
                    <div class="col-xs-3 col-sm-2 col-sm-offset-1"><span class="hidden-xs">Business Name/Style:</span></div>
                    <div class="col-xs-4 col-sm-5 text-left">-</div>
                    <div class="col-xs-3 col-sm-2"><span class="hidden-xs">OSCA/PWD ID No.</span></div>
                    <div class="col-xs-2 col-sm-1"></div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-1 col-sm-offset-1"><span class="hidden-xs">Address:</span></div>
                    <div class="col-xs-5 col-sm-6 text-left">{{register.customer.Address || '-'}}</div>
                    <div class="col-xs-3 col-sm-2"><span class="hidden-xs">Senior Citizen TIN</span></div>
                    <div class="col-xs-1 col-sm-2"></div>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-sm-offset-1"><span class="hidden-xs">Amount In Words:</span></div>
                    <div class="col-xs-5 col-sm-5 text-left">{{toWords(register.header.NetTotal)}}</div>
                    <div class="col-xs-2 col-sm-2"><span class="hidden-xs">Signature:</span></div>
                    <div class="col-xs-2 col-sm-2"></div>
                </div>
                
				<div class="row" style="margin-top:40px">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="row" ng-repeat="row in register.rows | orderBy:'+ProductDesc'">
                            <div class="col-xs-1 col-sm-1 text-center">{{row.Quantity}}</div>
                            <div class="col-xs-2 col-sm-3 text-center">{{row.BarCode}}</div>
                            <div class="col-xs-4 col-sm-4">{{row.ProductDesc}} <br/><small>{{(row.IsSerialized=='1') ? 'IMEI: ' + row.Serial : ''}}</small></div>
                            <div class="col-xs-2 col-sm-2 text-center">{{row.PriceAfSub | peso:2}}</div>
                            <div class="col-xs-2 col-sm-2 text-center">{{row.TotalAfSub | peso:2}}</div>
                        </div>
                    </div>
				</div>
                
                <div class="row" style="margin-top:20px">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="row">
                            <div class="col-xs-6 col-sm-8">
                                <b><i>Return No.</i></b> {{register.header.TransID}} <br/>
                                <b><i>Remarks:</i></b> {{register.header.Comments}}
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="row">
                                    <div class="col-xs-6 text-right"><small class="hidden-xs">VATable Sales</small></div>
                                    <div class="col-xs-6 text-right">{{register.header.TotalAfSub | peso:2}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 text-right"><small class="hidden-xs">VAT-Exempt Sale</small></div>
                                    <div class="col-xs-6 text-right">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 text-right"><small class="hidden-xs">VAT Zero-Rated Sales</small></div>
                                    <div class="col-xs-6 text-right">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 text-right"><small class="hidden-xs">VAT - 12%</small></div>
                                    <div class="col-xs-6 text-right">{{register.header.SalesTax | peso:2}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 text-right"><small class="hidden-xs">Total Sales (VAT Inc)</small></div>
                                    <div class="col-xs-6 text-right">{{register.header.NetTotal | peso:2}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6  text-right"><small class="hidden-xs">Less VAT</small></div>
                                    <div class="col-xs-6 text-right">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 text-right"><span class="hidden-xs">Total</span></div>
                                    <div class="col-xs-6 text-right">{{register.header.NetTotal | peso:2}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<script src="/resources/js/app/sales.js"></script>