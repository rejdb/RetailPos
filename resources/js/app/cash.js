function cashHistoryCtrl($scope, transact, Auth, spinner, curl, 
                        Inventory, filterFilter, $filter, BrnFact) {
    console.log('Initializing Cash Register Module');
    
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        IsDeposited: 0,
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
    
    var params = (usr.Roles!=4) ? 'IsDeposited="0"' : 'IsDeposited = "0" and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'report_cash_register', function(rsp) {
        $scope.pList = rsp;
        console.log(rsp);
        
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        var IsDeposited = (f.IsDeposited==-1) ? '':' and IsDeposited =' + parseInt(f.IsDeposited);
        
        var params = 'PaymentType=1 and (TransDate between "' + DateFrom + '" and "' + DateTo + '")' + branch + IsDeposited;
        
        spinner.show();
        transact.history(params, 'report_cash_register    ', function(rsp) {
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
    
    $scope.updateDepositSlip = function(row, index, data) {
        var data = {
            TransDate: row.TransDate,
            IsDeposited: 1,
            DepositSlip: data,
            Branch: row.Branch
        }
        
//        console.log(data);
        curl.post('/setup/updateDepositSlip', data, function(r) {
            spinner.notif(r.message, 1000, r.status);
            if(r.status) {
                row.IsDeposited = '1';
            }
        });
        
    } 
    
    $scope.exportFields = {
        TransDate: 'Date',
        BranchCode: 'Store Code',
        BranchDesc: 'Store Name',
        IsDeposited: 'Deposited?',
        PaymentName: 'Payment Type',
        Amount: 'Total Amount',
        DepositSlip: 'Deposit Slip No.',
    }
    
    console.log('Cash Register Module has been initialized');
}

function cardHistoryCtrl($scope, transact, Auth, spinner, curl, 
                        Inventory, filterFilter, $filter, BrnFact) {
    console.log('Initializing Cash Register Module');
    
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        // IsDeposited: 0,
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
    
    var params = (usr.Roles!=4) ? 'PaymentType!="1" and TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'PaymentType != "1" and Branch =' +usr.Branch.BranchID + ' and TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"';
    transact.history(params, 'view_sales_payments', function(rsp) {
        $scope.pList = rsp;
        console.log(rsp);
        
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
//        var IsDeposited = (f.IsDeposited==-1) ? '':' and IsDeposited =' + parseInt(f.IsDeposited);
        
        var params = 'PaymentType!=1 and (TransDate between "' + DateFrom + '" and "' + DateTo + '")' + branch;
        
        spinner.show();
        transact.history(params, 'view_sales_payments', function(rsp) {
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
    
    $scope.updateDepositSlip = function(row, index, data) {
        var data = {
            TransDate: row.TransDate,
            IsDeposited: 1,
            DepositSlip: data,
            Branch: row.Branch
        }
        
//        console.log(data);
        curl.post('/setup/updateDepositSlip', data, function(r) {
            spinner.notif(r.message, 1000, r.status);
            if(r.status) {
                row.IsDeposited = '1';
            }
        });
        
    } 
    
    $scope.exportFields = {
        TransDate: 'Date',
        InvoiceRef: 'SI Ref No.',
        BranchCode: 'Store Code',
        BranchDesc: 'Store Name',
        PaymentName: 'Payment Type',
        RefNumber: 'Reference Number',
        IssuingBankName: 'Issuing Bank',
        BankName: 'Terminal',
        InstDesc: 'Installment',
        Amount: 'Total Amount',
    }
    
    console.log('Cash Register Module has been initialized');
}

app.controller('cashHistoryCtrl', cashHistoryCtrl);
app.controller('cardHistoryCtrl', cardHistoryCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('.select').select2();
});