'use strict';

function salesCtrl($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location, Customer, UserFact) {
    console.log("Initializing Sales Module!");
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
    $scope.ShowFLSelect = true;
    var usr = Auth.currentUser();

    $scope.register = {
        BranchName: usr.Branch.Description,
        BranchCode: usr.Branch.BranchCode,
        CurrentSI: 0,
        CreatedBy: usr.DisplayName,
        Email: usr.Email,
        SelectedWhs: 'Good Stocks',
        SourceWhs: 1,
        Subsidy: 0,
        SelectedInst: 'Cash',
        Installment: 0,
        FreeWhs: 1,
        Backdating: parseInt(usr.Branch.IsBackdateAllowed) || 0,
        SalesTax: parseInt(usr.Branch.SalesTax) || 0,
        IsTaxable: parseInt(usr.Branch.IsTaxInclude) || 0,
        PayType: '1',
        Balance: 0,
        Points: 0,
        used_points: 0,
        used_credits: 0,
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
        payments: []
    };
    
    Inventory.getActiveWhs(1,function(whs) {$scope.WhsList = whs; $scope.itemLoader = false;});
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    UserFact.getBrnUser(usr.Branch.BranchID, function(fl) {$scope.frontliners = fl; $scope.flLoader=false;});
    Customer.active(1,function(cust) {$scope.customers = cust; $scope.custLoader = false;});
    transact.installment(1, function(r) {$scope.installments = r; });
    transact.terminal(1, function(r) {$scope.terminals = r; });
    
    $scope.CustomerSelected = function(selected) {
        var c = selected.originalObject;
        $scope.register.header.IsMember = 1;
        $scope.register.Balance = c.CustCredits;
        $scope.register.Points = c.CustPoints;
        
        $scope.register.customer = {
            CardNo: c.CardNo,
            Fullname: c.CustFirstName + ' ' + c.CustLastName,
            Email: c.CustEmail,
            ContactNo: c.ContactNo,
            Address: c.Address
        }
        
        $scope.updateValue(); $timeout(function() {updatePayment();},100);
        $scope.CustSelected = true;
    }
    
    $scope.addTempCustomer = function() {
        $scope.register.customer.CardNo = '5291988198828';
        $scope.register.customer.Fullname = $filter('uppercase')($scope.register.CustFirstName + ' ' + $scope.register.CustLastName);
        
        $scope.CustSelected = true;
        $('#NewCustomer').modal('hide');
    }
    
    $scope.resetCustomer = function(reg) {
        reg.Balance = 0;
        reg.Points = 0;
        reg.used_points = 0;
        reg.used_credits = 0;
        reg.discount = null;
        used_customer_points = 0;
        reg.customer = {};
        reg.payments = [];
        if(reg.header.IsMember==1) {
            reg.header.IsMember = 0;
            angular.forEach(reg.rows, function(i) {i.Discount=0});
            $scope.updateValue();   
        } $scope.CustSelected = false;
    }
    
    $scope.resetBranch = function(hdr){
        hdr.Branch = 0;
        $scope.Reset();
        $scope.ShowBranchSelect = false;
    }
    
    $scope.GetFl = function(selected) {
        $scope.register.header.CreatedBy = selected.originalObject.UID;
        $scope.register.CreatedBy = selected.originalObject.DisplayName;
        $scope.register.Email = selected.originalObject.Email;
        $scope.ShowFLSelect = true;
    }
    
    $scope.resetFL = function(hdr){
        $scope.ShowFLSelect = false;
    }
    
    $scope.GetBranch = function(selected) {
        UserFact.getBrnUser(parseInt(selected.originalObject.BranchID), function(fl) {$scope.frontliners = fl;});
        $scope.register.header.Branch = parseInt(selected.originalObject.BranchID);
        $scope.register.CurrentSI = selected.originalObject.Current;
        $scope.register.BranchCode = selected.originalObject.BranchCode;
        $scope.register.BranchName = selected.originalObject.Description;
        $scope.register.Backdating = parseInt(selected.originalObject.IsBackdateAllowed);
        $scope.register.SalesTax = parseInt(selected.originalObject.SalesTax);
        $scope.register.IsTaxable = parseInt(selected.originalObject.IsTaxInclude);
        $scope.ShowBranchSelect = true;
    }
    
    $scope.SelectWhs = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        
        $scope.register.SourceWhs = parseInt(WhsID);
        $scope.register.FreeWhs = (WhsID && selected.length) ? parseInt(selected[0].FreeWhs) : 0;
        $scope.register.SelectedWhs = (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
    }
    
    $scope.SelectInst = function(inst) {
        var selected = [];
        selected = $filter('filter')($scope.installments, {InsId: inst}, true);
        
        $scope.register.Installment = (inst && selected.length) ? parseInt(inst) : 0;
        $scope.register.Subsidy = (inst && selected.length) ? parseInt(selected[0].InstValue) : 0;
        $scope.register.SelectedInst = (inst && selected.length) ? selected[0].InstDesc : 'Cash';
        $scope.register.PayType = (inst && selected.length) ? '2' : '1';
        
        $timeout(function() {
            if($scope.register.header.IsMember==1 && used_customer_points>0) {
                var GTotals = 0; var value = $scope.register.header.Discount;
                angular.forEach($scope.register.rows, function(i) { 
                    if(i.GTotal>0) { GTotals+=i.PriceAfVat*i.Quantity;}});
                var disc = (value/GTotals) * 100;
                $scope.register.discount = disc;

                angular.forEach($scope.register.rows, function(i) {
                    if(i.GTotal>0) {
                        i.Discount = ((((i.PriceAfVat*i.Quantity)/GTotals) * value) / (i.PriceAfVat*i.Quantity)) * 100;
                    }
                });
            } $scope.updateValue(); $timeout(function() {updatePayment();},100);
        },100);
    }
    
    
    $scope.Reset = function() {
        $scope.register.rows = [];
        items = []; imei = [];
        $scope.register.header.Quantity = 0;
        $scope.register.header.SalesTax = 0;
        $scope.register.header.TotalBefSub = 0;
        $scope.register.header.TotalAfSub = 0;
        $scope.register.header.TotalAfVat = 0;
        $scope.register.header.NetTotal = 0;
        $scope.register.header.AmountDue = 0;
        $scope.register.discount = 0;
        used_customer_points = 0;
        $scope.register.used_credits = 0; 
        $scope.register.used_points = 0;
    }
    
    //Search Products
    var items = []; var imei = [];
    $scope.GetProduct = function(hdr) {
        if($scope.SearchProduct == undefined || $scope.SearchProduct.length == 0) {
            $('#GetProduct').parent().parent().parent().addClass('has-error');
            return false; }
        
        if(hdr.Branch == 0 || hdr.Branch == -1) {
            spinner.notif('Please select source branch!', 500);
            $scope.ShowBranchSelect = false;
            return false; }
        
        if($scope.register.SourceWhs == 0) {
            spinner.notif('Please select Warehouse Source!', 500);
            return false; }
        
        
        if(imei.indexOf($scope.SearchProduct.toLowerCase())>=0) {
            spinner.notif('Serial already exists in the row! please select another item.', 500);
            return false; }
        
        if(items.indexOf($scope.SearchProduct.toLowerCase()+$scope.register.SourceWhs)>=0) {
            spinner.notif('Product already exists in the row! please select another product', 500);
            return false; }
        
        var data = {
            'Branch': parseInt(hdr.Branch),
            'Warehouse': parseInt($scope.register.SourceWhs),
            'Search': $scope.SearchProduct
        }
        
        
        $scope.itemLoader = true;
        curl.post('/Inventories/SearchInventory', data, function(rsp) {
            $scope.SearchProduct = '';
            
            $scope.itemLoader = false;
            if(!rsp.status) {
                spinner.notif(rsp.message, 1000);
                return false;
            }else{
                var campaign = rsp.campaign;
                var data = rsp.result;
                var a = {
                    free: $scope.register.FreeWhs,
                    price: (campaign.status) ? parseFloat(campaign.price) : parseFloat(data.CurrentPrice),
                    cost: parseFloat(data.StdCost),
                    OutputVat: ($scope.register.IsTaxable==1) ? $scope.register.SalesTax : 0,
                    tax: ($scope.register.IsTaxable==1) ? (1+($scope.register.SalesTax/100)) : 1,
                    subsidy: ($scope.register.Subsidy==0) ? 1: (1+($scope.register.Subsidy/100)),
                    Campaign: (campaign.status) ? campaign.name : data.PriceListDesc
                }
                
                $scope.register.header.Quantity += 1;
                $scope.register.header.SalesTax += (((a.price * a.subsidy) * (a.OutputVat/100))).toFixed(2) * a.free;
                $scope.register.header.TotalBefSub += (a.price * a.subsidy) * a.free;
                $scope.register.header.TotalAfSub += (a.price * a.subsidy) * a.free;
                $scope.register.header.TotalAfVat += ((a.price * a.subsidy) * a.tax).toFixed(2) * a.free;
                $scope.register.header.NetTotal += ((a.price * a.subsidy) * a.tax).toFixed(2) * a.free;
                $scope.register.header.AmountDue += ((a.price * a.subsidy) * a.tax).toFixed(2) * a.free;
                $scope.register.header.ShortOver += ((a.price * a.subsidy) * a.tax).toFixed(2) * a.free;
                
                if(data.IsSerialized == 1) {
                    imei.push(data.Serial.toLowerCase());
                }else{ items.push(data.BarCode.toLowerCase() + $scope.register.SourceWhs); }
                
                var item = {
                    PID: parseInt(data.Product),
                    BarCode: data.BarCode,
                    ProductDesc: data.ProductDesc,
                    SKU: data.SKU,
                    Warehouse: data.Warehouse,
                    InStocks: parseInt(data.Available),
                    Quantity: 1,
                    Discount: 0,
                    DiscValue: 0,
                    Subsidy: 0,
                    OutputVat: a.OutputVat,
                    SalesTax: a.tax,
                    StdCost: a.cost,
                    Price: a.price * a.free,
                    PriceAfSub: a.price * a.free,
                    PriceAfVat: (a.price*a.tax) * a.free,
                    Total: a.price * a.free,
                    TotalAfSub: (a.price*a.tax) * a.free,
                    TotalAfVat: (a.price*a.tax) * a.free,
                    GTotal: (a.price*a.tax) * a.free,
                    AmountDue: (a.price*a.tax) * a.free,
                    IsSerialized: parseInt(data.IsSerialized),
                    InvSerID: data.InvSerID,
                    Serials: data.Serial,
                    Campaign: a.Campaign
                };
                $scope.register.rows.push(item);
                $timeout(function() {updatePayment();},100);
            }
        });
    }
    
    $scope.AddDiscount = function(discount) {
        var disc = 1-(discount/100);
        
        angular.forEach($scope.register.rows, function(index) {
            if(index.GTotal>0 || index.Discount==100) {
                index.Discount = discount || 0;
            }
        }); $scope.updateValue();
    }
    
    $scope.toggle = function(e) {
        $scope.npoints = '';
        if(e) {
            if($scope.toggleCredits) {
                $scope.toggleCredits = !$scope.toggleCredits;
                return false; }
            $scope.toggleCredits = true;
            $scope.togglePoints = false;
        }else{
            if($scope.togglePoints) {
                $scope.togglePoints = !$scope.togglePoints;
                return false; }
            $scope.togglePoints = true;
            $scope.toggleCredits = false;
        }
    }
    
    var used_customer_points = 0;
    $scope.ApplyCredits = function(opt, value, e) {
        var code = (e.which) ? e.which : e.keyCode;
        if(code==13) {
            if(opt==1) {
                $scope.togglePoints = false;
                if(value>$scope.register.Points) {
                    spinner.notif('Insufficient Points', 1000);
                    return false; }
                $scope.register.Points -= value;
                $scope.register.used_points += value;
            }else{
                $scope.toggleCredits = false;
                if(value>$scope.register.Balance) {
                    spinner.notif('Insufficient Balance', 1000);
                    return false; }
                $scope.register.Balance -= value;
                $scope.register.used_credits += value;
            } 
            var GTotals = 0; used_customer_points += value;
            angular.forEach($scope.register.rows, function(i) { 
                if(i.GTotal>0) { GTotals+=i.PriceAfVat*i.Quantity;}});
            var disc = (used_customer_points/GTotals) * 100;
            $scope.register.discount = disc;
            
            angular.forEach($scope.register.rows, function(i) {
                if(i.GTotal>0) {
                    i.Discount += ((((i.PriceAfVat*i.Quantity)/GTotals) * value) / (i.PriceAfVat*i.Quantity)) * 100;
                }
            }); $scope.updateValue();
            $timeout(function() {updatePayment();},100);
        }
    }
    
    $scope.removeItem = function(index) {
        var rw = $scope.register.rows[index];
        $scope.register.rows.splice(index,1);
        
        if(rw.IsSerialized==1) {
            var srl = imei.indexOf(rw.Serials.toString().toLowerCase());
            imei.splice(srl,1); }else{
            var itm = items.indexOf(rw.BarCode.toString().toLowerCase() + rw.Warehouse);
            items.splice(itm,1); } 
        
        if($scope.register.header.IsMember==1 && used_customer_points>0) {
            var GTotals = 0;
            angular.forEach($scope.register.rows, function(i) { 
                if(i.GTotal>0) { GTotals+=i.PriceAfVat*i.Quantity;}});
            var disc = (used_customer_points/GTotals) * 100;
            $scope.register.discount = disc;

            angular.forEach($scope.register.rows, function(i) {
                if(i.GTotal>0) {
                    i.Discount = ((((i.PriceAfVat*i.Quantity)/GTotals) * used_customer_points) / (i.PriceAfVat*i.Quantity)) * 100;
                }
            });
        } $scope.updateValue(); 
        $timeout(function() {updatePayment();},100);
    }
    
    $scope.Filler = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        return (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
    }
    
    $scope.FillerPayType = function(id) {
        var selected = [];
        selected = $filter('filter')(tbxCnf.payments, {PaymentId: id}, true);
        return (id && selected.length) ? selected[0].PaymentName : 'Not Found';
    }
    
    $scope.updateValue = function() {
        $scope.register.header.TotalBefSub = 0;
        $scope.register.header.TotalAfSub = 0;
        $scope.register.header.TotalAfVat = 0;
        $scope.register.header.NetTotal = 0;
        $scope.register.header.AmountDue = 0;
        $scope.register.header.Quantity = 0;
        $scope.register.header.Discount = 0;
        $scope.register.header.ShortOver = 0;
        $scope.register.header.SalesTax = 0;
        
        $timeout(function() {
            angular.forEach($scope.register.rows, function(index) {
                $scope.register.header.Quantity += index.Quantity;
                $scope.register.header.SalesTax += parseFloat((index.TotalAfSub * (index.OutputVat/100)).toFixed(2));
                $scope.register.header.TotalBefSub += parseFloat((index.Total).toFixed(2));
                $scope.register.header.TotalAfSub += parseFloat((index.TotalAfSub).toFixed(2));
                $scope.register.header.TotalAfVat += parseFloat((index.TotalAfVat).toFixed(2));
                $scope.register.header.NetTotal += parseFloat((index.GTotal).toFixed(2));
                $scope.register.header.AmountDue += parseFloat((index.AmountDue).toFixed(2));
                $scope.register.header.ShortOver += parseFloat((index.AmountDue).toFixed(2));
                $scope.register.header.Discount += (index.Quantity*index.PriceAfVat) * (index.Discount/100);
            });
        },100);
    }
    
    $scope.checkInventory = function(data, row) {    
        var data = parseInt(data);
        var InStocks = row.InStocks;
        
        if(data > InStocks) {
            return 'Quantity exceeds Available Quantity'   
        }
    }
    
    $scope.removePayment = function(index) {
        $scope.register.payments.splice(index,1);
        updatePayment();
    }
    
    var updatePayment = function() {
        $scope.register.header.Payment = 0;
        angular.forEach($scope.register.payments, function(i) {
            $scope.register.header.Payment += i.Amount;
        }); $scope.register.header.ShortOver = $scope.register.header.AmountDue - $scope.register.header.Payment;
        $scope.Payment.Amount = parseFloat($scope.register.header.ShortOver.toFixed(2));
    }
    
    $scope.Enter = function(e) {
        var code = (e.which) ? e.which : e.keyCode;
        if(code==13) {
            $scope.AddPayment($scope.Payment.Amount);
        }
    }
    
    $scope.AddPayment = function(amount) {
        if(amount==0 || amount==undefined) {
            spinner.notif("please enter amount!", 1000);
            return false; }
        if($scope.register.PayType=='2' && ($scope.Payment.IssuingBank==0 || $scope.Payment.IssuingBank==undefined)) {
            spinner.notif('Please select Cardholders Issuing Bank', 1000);
            return false; }
        if($scope.register.PayType=='2' && ($scope.Payment.Terminal==0 || $scope.Payment.Terminal==undefined)) {
            spinner.notif('Please select Terminal', 1000);
            return false; }
        if($scope.register.PayType=='2' && ($scope.Payment.RefNumber==undefined || $scope.Payment.RefNumber.length==0)) {
            return spinner.notif('Please input payment reference number', 1000);
        }
        if($scope.register.PayType=='2' && $scope.register.Installment==0) {
            var cnf = window.confirm('Are you sure this transaction is zero installment?');
            if(!cnf) { return false; }else{ $scope.register.Installment = 1; }
        }
        if($scope.register.PayType=='5' && ($scope.Payment.RefNumber==undefined || $scope.Payment.RefNumber.length==0)) {
            spinner.notif('Please Enter Home Credit Ref Number', 1000);
            return false;
        }
        
        $scope.register.payments.push({
            PaymentType: $scope.register.PayType,
            RefNumber: $scope.Payment.RefNumber || '',
            Terminal: $scope.Payment.Terminal || 0,
            IssuingBank: $scope.Payment.IssuingBank || 0,
            Installment: ($scope.register.PayType=='2') ? $scope.register.Installment : 0,
            Amount: amount,
            Branch: $scope.register.header.Branch
        }); $scope.Payment.RefNumber = '';
        $scope.Payment.IssuingBank = 0;
        $scope.Payment.Terminal = 0;
        $scope.register.PayType = '1';
        updatePayment();
    }
    
    $scope.SubmitRegister = function(r) {
        var TransID = transact.TransID(r.header.Branch);
        $scope.register.header.TransID = TransID;
        $scope.register.customer.TransID = TransID;
        $scope.register.header.TransDate = $filter('date')(Date.parse(r.header.TransDate), 'yyyy-MM-dd');
        
        var currentdate = $filter('date')(new Date(), 'yyyy-MM-dd');
        $('#SendSales').modal('hide');
        
        if(r.rows.length == 0) {
            return spinner.notif('Please select a product to sell',1000);}
        if(r.customer.CardNo == undefined) {
            $('#SendSales').modal('hide');
            $('#NewCustomer').modal('show');
            return false;}
        if(r.payments.length == 0) {
            return spinner.notif('Please enter your payment',1000);}
        if(r.header.ShortOver>0) {
            return spinner.notif('Insufficient Payment',1000); }
        if(r.header.RefNo.length == 0) {
            return spinner.notif('Please enter a Reference Number.',1000);}
        if(r.header.Branch == 0) {
            $scope.ShowBranchSelect = false;
            return spinner.notif('Please select Branch',1000);}
        
        var data = {
            header: r.header,
            rows: r.rows,
            customer: r.customer,
            payments: r.payments,
            used: {
                points: $scope.register.used_points,
                credits: $scope.register.used_credits,
                computation: parseInt(tbxCnf.UsedComputation)
            }
        };
        
        spinner.show();
        curl.post('/transactions/SubmitSales', data, function(rsp) {
            spinner.hide();
            spinner.notif(rsp.message, 1000, rsp.status);
            if(rsp.status) {
                $location.path('/sales/invoice/receipt/' + TransID);
            }
        });
    }
    
    console.log("Sales module has been initialized!");
}

function salesReceiptCtrl($scope, $stateParams, curl, Auth, $state,
                            spinner, $filter, transact, Inventory, BrnFact) {
    Auth.config(function(rsp) {
        $scope.config = rsp;
    });
    
    $scope.MyTax = 0;
    
    var usr = Auth.currentUser();
    // Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    // BrnFact.getActive(1,function(brn) {$scope.branches = brn;});

    $scope.Filler = function(id, type) {
        var selected = [];
        if(type==1) {
            selected = $filter('filter')($scope.WhsList, {WhsCode: id}, true);
        }else{
            selected = $filter('filter')($scope.branches, {BranchID: id}, true);
        }
        return (type==1) ? selected[0].WhsName : selected[0].Description;
    }
    
    spinner.show();
    curl.get('/transactions/SalesReceipt/' + $stateParams.TransID, function(rsp) {
        $scope.register = rsp;
        spinner.hide();
    });
    
    var th = ['','thousand','million', 'billion','trillion'];
    var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; 
    var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen'];
    var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety']; 


    $scope.toWords = function(s)
    {  
        s = s.toString(); 
        s = s.replace(/[\, ]/g,''); 
        if (s != parseFloat(s)) return 'not a number'; 
        var x = s.indexOf('.'); 
        if (x == -1) x = s.length; 
        if (x > 15) return 'too big'; 
        var n = s.split(''); 
        var str = ''; 
        var sk = 0; 
        for (var i=0; i < x; i++) 
        {
            if ((x-i)%3==2) 
            {
                if (n[i] == '1') 
                {
                    str += tn[Number(n[i+1])] + ' '; 
                    i++; 
                    sk=1;
                }
                else if (n[i]!=0) 
                {
                    str += tw[n[i]-2] + ' ';
                    sk=1;
                }
            }
            else if (n[i]!=0) 
            {
                str += dg[n[i]] +' '; 
                if ((x-i)%3==0) str += 'hundred ';
                sk=1;
            }


            if ((x-i)%3==1)
            {
                if (sk) str += th[(x-i-1)/3] + ' ';
                sk=0;
            }
        }
       if (x != s.length)
       {
           var y = s.length; 
           var decimal = parseInt(n[y-2]) + parseInt(n[y-1]);
           if(decimal === 0) {
                str += 'pesos only';
           }else{
                str += 'and '; 
                for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';
                str += 'pesos only';
           }
           
       }
        return str.replace(/\s+/g,' ');
    }
    
}

function salesHistoryCtrl($scope, transact, Auth, spinner, curl,
                        Inventory, filterFilter, $filter, BrnFact) {
    console.log('Initializing Sales History Module');
    
    spinner.show();
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
    
    var params = (usr.Roles!=4) ? 'TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'TransDate = "' + $filter('date')(new Date(), 'yyyy-MM-dd') + '" and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_sales', function(rsp) {
        spinner.hide();
        $scope.pList = rsp;
        
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    BrnFact.getActive(1,function(brn) {
        $scope.branches = brn;
    });
    
    $scope.filter = function(id) {
        spinner.show();
        var params = (usr.Roles!=4) ? 'RefNo like "%'+id+'%"' : 'RefNo like "%'+id + '%" and Branch =' + usr.Branch.BranchID;
        transact.history(params, 'view_sales', function(rsp) {
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
        transact.history(params, 'view_sales    ', function(rsp) {
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
    
    console.log('Sales History Module has been initialized');
}

app.controller('salesCtrl', salesCtrl);
app.controller('salesReceiptCtrl', salesReceiptCtrl);
app.controller('salesHistoryCtrl', salesHistoryCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('#PoBranch, #PoSupplier').select2();
    // $('#SendSales').modal('show');
});