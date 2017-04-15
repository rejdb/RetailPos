'use strict';

function genSetup($scope, curl, Auth, Inventory, 
                   $window, spinner, transact) {
    $('#page-wrapper').removeClass('nav-small');
    
    Auth.config(function(rsp) {
        var cnf =  rsp;
        $scope.Payments = cnf.payments;
        $scope.genSetup = {
            CompanyName: cnf.CompanyName,
            CompanyAddress: cnf.CompanyAddress,
            Website: cnf.Website,
            IsTaxInclude: (parseInt(cnf.IsTaxInclude)==1),
            SalesTax: parseInt(cnf.SalesTax),
            InputTax: parseInt(cnf.InputTax),
            DefPayment: parseInt(cnf.DefPayment),
            DefaultReturnPolicy: parseInt(cnf.DefaultReturnPolicy),
            ReceiptMessage: cnf.ReceiptMessage,
            UsedComputation: parseInt(cnf.UsedComputation),
            IsPurchaseTaxable: (parseInt(cnf.IsPurchaseTaxable)==1)
        };
    });
//    console.log(cnf);
    
    
    Inventory.getWarehouse(function(rsp) {$scope.warehouses = rsp;});
    $scope.updateWhs = function(id, field, data, type=false) { 
        spinner.show();
        var result;
        Inventory.updateField(id, field, data, function(rsp) {
            result = rsp;
        }, type); spinner.hide();
        return result;
    }

    transact.installment('all', function(r) {$scope.installments = r; });
    transact.terminal('all', function(r) {$scope.terminals = r; console.log(r); });
    curl.get('/Setup/Points', function(rsp) { $scope.points = rsp;});
    
    $scope.changePolicyDesc = function() {
        $scope.genSetup.ReceiptMessage = $scope.genSetup.DefaultReturnPolicy + ' Days return policy';
    }

    $scope.saveConfig = function() {
        spinner.on();
        var input = {
            'setup': $scope.genSetup,
            'payments': $scope.Payments
        };
         console.log(input)
        curl.post('/setup/config', input, function(rs) {
            spinner.off()
        });
    }
    
    $scope.addNewWhs = function() {
        if($scope.addiWhs.WhsName == undefined || $scope.addiWhs.WhsName.length ==0) {
            $window.alert('Please fill in the field!');
            return false;
        }
        
        spinner.on();
        Inventory.addWarehouse($scope.addiWhs, function(rsp) {
            $scope.addWhs = true;
            $scope.addiWhs.WhsName = '';
            Inventory.getWarehouse(function(rs) { 
                spinner.off();
                spinner.alert(rsp);
                $scope.warehouses = rs; 
            });
        });
    }
    
    $scope.addNewPoints = function() {
        spinner.show();
        curl.post('/setup/addPoints', $scope.addiPoints, function(rsp) {
            $scope.addPoints = true;
            $scope.pointer.$setPristine();
            $scope.addiPoints = {};
            spinner.hide();
            spinner.notif(rsp.message, 1000, rsp.status);
            if(rsp.status) {
                curl.get('/setup/Points', function(rsp) { 
                    $scope.points = rsp;
                });
            }
        });
    }
    
    $scope.removePoint = function(index, id) {
        var cnf = window.confirm("Are you sure you want to remove this row?");
        if(cnf) {
            $scope.points.splice(index, 1);   
            curl.get('/Setup/RemovePoint/' + id, function(r) {
                spinner.notif('Point has been removed',1000,true);
            });
        }
    }
    
    $scope.updatePoint = function(id, field, data, type=false) { 
        spinner.show();
        var postData = '{"PointID":' + id + ',"type": {"' + field + '":' + data + '}}';
        var result;
        curl.ajax('/Setup/updatePoint', JSON.parse(postData), function(rsp) { 
            result = rsp;
        }); spinner.hide();
        
        return result;
    }

    $scope.addNewBank = function() {
        if($scope.addiBank.BankName == undefined || $scope.addiBank.BankName.length ==0) {
            $window.alert('Please fill in the field!');
            return false;
        }
        
        $scope.addBank = true;
        spinner.show();
        curl.post('/Setup/AddTerminal', $scope.addiBank, function(r) {
            $scope.addiBank.BankName = '';
            spinner.hide();
            spinner.notif(r.message, 1500, r.status);
            if(r.status) {
                $scope.terminals = r.data;
            }
        });
        
    }
    
    $scope.updateBank = function(id, field, data, type=false) { 
        spinner.show();
        if(type) { var postData = '{"BankID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{var postData = '{"BankID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        var result;
        curl.ajax('/Setup/updateBank', JSON.parse(postData), function(rsp) { 
            result = rsp;
        }); spinner.hide();
        
        return result;
    }
    
    $scope.addNewInstallment = function() {
        $scope.addInst = true;
        spinner.show();
        curl.post('/Setup/AddInstallment', $scope.addiInst, function(r) {
            
            spinner.hide();
            spinner.notif(r.message, 1500, r.status);
            
            $scope.insts.$setPristine();
            $scope.addiInst = {};
            if(r.status) {
                $scope.installments = r.data;
            }
        });
        
    }
    
    $scope.updateInsts = function(id, field, data, type=false) { 
        spinner.show();
        if(type) { var postData = '{"InsId":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{var postData = '{"InsId":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        var result;
        curl.ajax('/Setup/updateInstallment', JSON.parse(postData), function(rsp) { 
            result = rsp;
        }); spinner.hide();
        
        return result;
    }
    
    $scope.newPaymentType = function(n) {
        if(n==undefined || n.length == 0) {
            return spinner.notif('Please fill input box!');}
        
        curl.post('/setup/addPaymentType', {PaymentName: n}, function(r) {
            spinner.notif(r.message, 1000, r.status);
            if(r.status) {
                $scope.Payments = r.data;
                $scope.addNewPaymentType=''; $scope.payform.$setPristine();
            }
        });
    }
}

app.controller("genSetup", genSetup);

$(document).ready(function() {
    $('#timeline-grid').gridalicious({
		gutter: 10,
		width: 500,
		animate: true,
		animationOptions: {
			speed: 150,
			duration: 500
		},
	});
});