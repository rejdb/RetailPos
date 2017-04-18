'use strict';

function returnCtrl($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location, Customer) {
    console.log("Initializing Return Module!");
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    var tbxCnf;
    $scope.WhsList = [];
    $scope.branches = [];
    $scope.Payment = {};
    
    Auth.config(function(rsp) {
        tbxCnf = rsp;
        $scope.tbxConfig = tbxCnf;
    });
    
    $scope.ShowBranchSelect = true;
    
    var usr = Auth.currentUser();
    $scope.register = {
        BranchName: usr.Branch.Description,
        CreatedBy: usr.DisplayName,
        Method: 0,
        MethodName: 'Sales Return',
        InvoiceRefNo: '',
        Points: 0,
        Balance: 0,
        header: {
            RefNo: '',
            TransDate: $filter('date')(new Date(), 'MM/dd/yyyy'),
            Branch: usr.Branch.BranchID,
            IsMember: 0,
            Quantity: 0,
            Discount: 0,
            SalesTax: 0,
            TotalBefSub: 0,
            TotalAfSub: 0,
            TotalAfVat: 0,
            NetTotal: 0,
            AmountDue: 0,
            Payment: 0,
            ShortOver: 0,
            Comments: '',
            CreatedBy: usr.UID
        },
        customer: {},
        rows: [],
        payments: {}
    }
    
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    $scope.ChangeMethod = function(m) {
        Reset();
        $scope.register.Method = m;
        $scope.register.MethodName = (m==0) ? 'Sales Return':'Sales Refund';
    }
    $scope.Filler = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        return (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
    }
    
    $scope.GetSalesTransID = function(TransID) {
        $scope.SalesTransID = '';
        if(TransID == undefined || TransID.length == 0) {
            return spinner.notif('Please enter return no.', 1000); }
        
        if($scope.register.header.Branch == 0 || $scope.register.header.Branch == -1) {
            spinner.notif('Please select source branch!', 500);
            $scope.ShowBranchSelect = false;
            return false; }
        
        spinner.show();
        curl.get('/transactions/GetSalesInvoice/' + TransID + '/' + $scope.register.header.Branch, function(rsp) {
            spinner.hide();
            if(rsp.status) {
                var m = $scope.register.Method;
                $scope.register.InvoiceRefNo = rsp.invoice.header.RefNo;
                $scope.register.header.IsMember = parseInt(rsp.invoice.header.IsMember);
                var c = rsp.invoice.customer;
                $scope.register.Balance = c.CustCredits;
                $scope.register.Points = c.CustPoints;
                $scope.register.customer = {
                    CardNo: c.CardNo,
                    Fullname: c.Fullname,
                    Email: c.Email,
                    ContactNo: c.ContactNo,
                    Address: c.Address
                }
                $scope.register.rows = [];
                angular.forEach(rsp.invoice.rows, function(i) {
                    var item = {
                        PID: parseInt(i.ProductID),
                        BarCode: i.BarCode,
                        ProductDesc: i.ProductDesc,
                        SKU: i.SKU,
                        Warehouse: i.Warehouse,
                        InStocks: parseInt(i.Quantity),
                        Quantity: parseInt(i.Quantity),
                        Discount: (i.Discount-0) * m,
                        DiscValue: (i.Discount-0) * m,
                        Subsidy: (i.Subsidy-0) * m,
                        OutputVat: i.OutputTax-0,
                        SalesTax: i.TaxAmount,
                        StdCost: i.Cost-0,
                        Price: i.Price-0,
                        IsSerialized: parseInt(i.IsSerialized),
                        Serials: i.Serial,
                        Campaign: i.Campaign
                    }; $scope.register.rows.push(item);
                }); $scope.updateValue();
                
            }else{ spinner.notif(rsp.message, rsp.timer);}
        });
    }
    
    $scope.resetBranch = function(hdr){
        hdr.Branch = 0;
        Reset();
        $scope.ShowBranchSelect = false;
    }
    
    $scope.GetBranch = function() {
        var id = $scope.register.header.Branch;
        var selected = $filter('filter')($scope.branches, {BranchID:id}, true);
        
        $scope.register.BranchName = selected[0].Description;
        $scope.ShowBranchSelect = true;
    }
    
    var Reset = function() {
        $scope.register.rows = [];
        $scope.register.customer = {};
        $scope.register.payments = {};
        $scope.register.header.Quantity = 0;
        $scope.register.header.SalesTax = 0;
        $scope.register.header.TotalBefSub = 0;
        $scope.register.header.TotalAfSub = 0;
        $scope.register.header.TotalAfVat = 0;
        $scope.register.header.NetTotal = 0;
    }
    
    $scope.removeItem = function(index) {
        $scope.register.rows.splice(index,1);
        $scope.updateValue(); 
    }
    
    $scope.updateValue = function() {
        $scope.register.header.TotalBefSub = 0;
        $scope.register.header.TotalAfSub = 0;
        $scope.register.header.TotalAfVat = 0;
        $scope.register.header.NetTotal = 0;
        $scope.register.header.AmountDue = 0;
        $scope.register.header.Payment = 0;
        $scope.register.header.Quantity = 0;
        $scope.register.header.Discount = 0;
        $scope.register.header.ShortOver = 0;
        $scope.register.header.SalesTax = 0;
        
        $timeout(function() {
            angular.forEach($scope.register.rows, function(index) {
                $scope.register.header.Quantity += index.Quantity * -1;
                $scope.register.header.SalesTax += (index.TotalAfSub * (index.OutputVat/100)) * -1;
                $scope.register.header.TotalBefSub += index.Total * -1;
                $scope.register.header.TotalAfSub += index.TotalAfSub * -1;
                $scope.register.header.TotalAfVat += index.TotalAfVat * -1;
                $scope.register.header.NetTotal += index.GTotal * -1;
                $scope.register.header.AmountDue += index.AmountDue * -1;
                $scope.register.header.Payment += index.AmountDue * -1;
                $scope.register.header.Discount += ((index.Quantity*index.PriceAfVat) * (index.Discount/100)) * -1;
            });
        },100);
        $timeout(function() {AddPayment($scope.register.header.NetTotal)},200);
    }
    
    $scope.checkInventory = function(data, row) {    
        var data = parseInt(data);
        var InStocks = row.InStocks;
        
        if(data > InStocks) {
            return 'Quantity exceeds Returning Quantity'   
        }
    }
    
    var AddPayment = function(amount) {
        $scope.register.payments = {
            PaymentType: 1,
            RefNumber: '',
            Terminal: 0,
            IssuingBank: 0,
            Installment: 0,
            Amount: amount
        };
    }
    
    $scope.SubmitRegister = function(r) {
        var TransID = transact.TransID(r.header.Branch);
        $scope.register.header.TransID = TransID;
        $scope.register.customer.TransID = TransID;
        $scope.register.payments.TransID = TransID;
        $scope.register.header.TransDate = $filter('date')(Date.parse(r.header.TransDate), 'yyyy-MM-dd');
        $scope.register.payments.TransDate = $filter('date')(Date.parse(r.header.TransDate), 'yyyy-MM-dd');
        $scope.register.payments.Branch = r.header.Branch;
        
        var currentdate = $filter('date')(new Date(), 'yyyy-MM-dd');
        $('#SendReturn').modal('hide');
        
        if(r.rows.length == 0) {
            return spinner.notif('Please select a product to sell',1000);}
        if(r.header.RefNo.length == 0) {
            return spinner.notif('Please enter a Reference Number.',1000);}
        if(r.header.Branch == 0) {
            $scope.ShowBranchSelect = false;
            return spinner.notif('Please select Branch',1000);}
        if(r.InvoiceRefNo!=r.header.RefNo) {
            return spinner.notif('Invalid Invoice Number! Not Match',1000);}
        
        
        var data = {
            header: r.header,
            rows: r.rows,
            customer: r.customer,
            payments: r.payments,
            used: {
                computation: parseInt(tbxCnf.UsedComputation)
            }
        };
        
        spinner.show();
        curl.post('/transactions/SubmitReturn', data, function(rsp) {
            spinner.hide();
            console.log(rsp)
            var m = $scope.register.Method;
            var msg = (m==0) ? 'You have to create sales replacement now!':rsp.message;
            var tmr = (m==0) ? 0:1000;
            spinner.notif(msg, tmr, rsp.status);
            if(rsp.status) {
                if(m==0) {
                    $location.path('/sales/invoice');
                }else{$location.path('/sales/return/receipt/' + TransID);}
            }
        });
    }
    
    console.log("Return module has been initialized!");
}

function returnReceiptCtrl($scope, $stateParams, curl, Auth, $state,
                            spinner, $filter, transact, Inventory, BrnFact) {
    Auth.config(function(rsp) {
        $scope.config = rsp;
    });
    
    var usr = Auth.currentUser();
    Inventory.getWarehouse(function(whs) { $scope.WhsList = whs; });
    BrnFact.getActive(1,function(brn) { $scope.branches = brn; });
    
    curl.get('/transactions/ReturnReceipt/' + $stateParams.TransID, function(rsp) {
        $scope.register = rsp; });
    
}

function returnHistoryCtrl($scope, transact, Auth, spinner, curl,
                        Inventory, filterFilter, $filter, BrnFact) {
    console.log('Initializing Return History Module');
    
    $scope.WhsList = [];
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Branch: usr.Branch.BranchID,
        DateFrom: $filter('date')(new Date(), 'MM/dd/yyyy'),
        DateTo: $filter('date')(new Date(), 'MM/dd/yyyy')
    }

    // $watch search to update pagination
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.pList, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.pList, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    spinner.show();
    var params = (usr.Roles!=4) ? 'TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'TransDate = "' + $filter('date')(new Date(), 'yyyy-MM-dd') + '" and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_return', function(rsp) {
        $scope.pList = rsp;
        spinner.hide();
        
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    BrnFact.getActive(1,function(brn) {
        $scope.branches = brn;
    });
    
    $scope.filter = function(id) {
        spinner.show();
        var params = (usr.Roles!=4) ? 'RefNo like "%'+id+'%"' : 'RefNo like "%'+id + '%" and Branch =' + usr.Branch.BranchID;
        transact.history(params, 'view_return', function(rsp) {
            spinner.hide();
            if(rsp.length==0) {
                spinner.alert({status:false,message:"No Record Found!"}, 1000);
            }else{
                $scope.collapse = true;
                $scope.sFormSingle.$setPristine();
                $scope.search.TransID='';
                $scope.pList=rsp;
            }
        });
    }
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        
        var params = 'TransDate <= "' + DateTo + '" and TransDate >= "' + DateFrom + '"' + branch;
        
        spinner.show();
        transact.history(params, 'view_return', function(rsp) {
            $scope.pList=rsp;
            spinner.hide();
            
            $scope.collapse = true;
            if($scope.pList.length==0) {
                spinner.notif('No Record Found!', 1000); }

            $scope.currentPage = 1;
            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
        });
    }
    
    $scope.exportFields = {
        TransDate: 'Date',
        RefNo: 'Invoice Number',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        Quantity: 'Quantity',
        TotalBefSub: 'Total',
        TotalAfSub: 'Total after Installment',
        SalesTax: 'VAT',
        TotalAfVat: 'Total after VAT',
        Discount: 'Discount',
        NetTotal: 'Total Net of Discount',
        ShortOver: 'Short / Over',
        DisplayName: 'Cashier'
    }
    
    console.log('Return History Module has been initialized');
}

app.controller('returnCtrl', returnCtrl);
app.controller('returnReceiptCtrl', returnReceiptCtrl);
app.controller('returnHistoryCtrl', returnHistoryCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('#PoBranch, #PoSupplier').select2();
});