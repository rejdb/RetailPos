function postpaidCtrl($scope, transact, Auth, spinner, curl, $timeout,
                        Inventory, filterFilter, $filter, BrnFact, $state) {
    console.log('Initializing Sales Postpaid Module');
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    $scope.PostpaidDate = $filter('date')(new Date(), 'yyyy-MM-dd');
    
    var usr = Auth.currentUser();
    
    $scope.ValidSI = false;
    $scope.ValidateSI = false;
    $scope.ValidICC = false;
    $scope.ValidateICC = false;
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Status: -1,
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
    var params = (usr.Roles!=4) ? '(DepositSlip is Null or DepositSlip="") and Status!=2' : 'Status!=2 and (DepositSlip is Null or DepositSlip="") and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_sales_postpaid', function(rsp) {
        spinner.hide();
        $scope.pList = rsp;
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    
    $scope.checkSI = function(refno) {
        if($scope.ValidSI==false) {
            $scope.ValidateSI = true;
            if(refno == undefined || refno.length == 0) {
                $scope.response = {status:false, message: 'Please enter customer SI!'};
                $scope.show_notif = true;
                $timeout(function() {$scope.show_notif = false;},1000);
                $scope.ValidateSI = false;
                return false;
            }

            curl.get('/transactions/CheckSI/' + refno, function(r) {
                $scope.response = r;
                $scope.ValidSI = r.status;
                $scope.ValidateSI = false;
                $scope.show_notif = true;
                $timeout(function() {$scope.show_notif = false;},1000);
            });
        }else{
            $scope.ValidSI=false;
            $scope.ValidICC=false;
            $scope.postpaid.RefNo = '';
            $scope.postpaid.ICCID = '';
        }
    }
    
    $scope.checkICC = function(iccid) {
        if($scope.ValidICC==false) {
            $scope.ValidateICC = true;
            if(iccid == undefined || iccid.length == 0) {
                $scope.response = {status:false, message: 'Please enter icc no.!'};
                $scope.show_notif = true;
                $timeout(function() {$scope.show_notif = false;},1000);
                $scope.ValidateICC = false;
                return false;
            }
            
            if(usr.Branch.BranchID == 0) {
                $scope.response = {status:false, message: 'Please log in to Store to proceed!'};
                $scope.show_notif = true;
                $timeout(function() {$scope.show_notif = false;},1000);
                $scope.ValidateICC = false;
                return false;
            }

            curl.get('/transactions/CheckICC/' + iccid + '/' + usr.Branch.BranchID, function(r) {
                $scope.response = r;
                $scope.ValidICC = r.status;
                $scope.ValidateICC = false;
                $scope.show_notif = true;
                $timeout(function() {$scope.show_notif = false;},1000);
            });
        }else{
            $scope.ValidICC=false;
            $scope.postpaid.ICCID = '';
        }
    }
    
    /* Add New Postpaid */
    $scope.addNewPostpaid = function() {
        $scope.saving = true;
        
        angular.extend($scope.postpaid, {
            TransDate: $filter('date')($scope.PostpaidDate, 'yyyy-MM-dd'),
            CreateDate: $filter('date')(new Date(), 'yyyy-MM-dd'),
            Branch: usr.Branch.BranchID,
            CreatedBy: usr.UID
        });
        // console.log($scope.postpaid);
        curl.post('/transactions/addPostpaid', $scope.postpaid, function(r) {
            console.log(r);
            $scope.saving = false;
            $scope.response = {status: r.status, message: r.message};
            $scope.show_notif = true;
            $timeout(function() {$scope.show_notif = false;},1000);
            
            if(r.status) {
                $scope.pList.push(r.data);
                $scope.postpaid = {};
                $scope.formAddPostpaid.$setPristine();
                $scope.ValidSI = false;
                $scope.ValidICC = false;
            }
        });
    }
    
    $scope.updateField = function(id, field, data, type=false) {
        if(type) { var postData = '{"PostpaidID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{var postData = '{"PostpaidID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.post('/transactions/updatePostpaid', postData, function(rsp) { 
            spinner.notif(rsp.message, 1000, rsp.status);
        }); 
    }
    
    $scope.CancelPostpaid = function(row) {
        var cnf = window.confirm("Are you sure you want to cancel this transaction?");
        if(cnf) {
            curl.post('/transactions/cancelPostpaid', row, function(rsp) {
                row.Status = '2';
            });
        }
    }
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        var status = (f.Status==-1) ? '':' and Status=' + parseInt(f.Status);
        
        var params = '(TransDate between "' + DateFrom + '" and "' + DateTo + '")' + branch + status;
        
        spinner.show();
        transact.history(params, 'view_sales_postpaid', function(rsp) {
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
        BranchDesc: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        LastName: 'Last Name',
        FirstName: 'First Name',
        MiddleName: 'Middle Name',
        ContactNo: 'Contact No',
        Email: 'Email',
        IccID: 'ICC ID',
        SimNo: 'SIM Card No.',
        DepositSlip: 'Deposit Slip',
        DepositAmount: 'Deposit Amount',
        Comments: 'Comments',
        ActivationDate: 'Activation Date',
        StatusDesc: 'Status',
        SoldBy: 'Sold By',
    }
    
    console.log('Sales Postpaid Module has been initialized');
}

app.controller('postpaidCtrl', postpaidCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('.select').select2({width:"100%"});
//    $('#myPostpaid').modal('show');
});