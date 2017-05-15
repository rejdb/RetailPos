'use strict';

function purchaseCtrl($scope, Auth, spinner, $filter, $timeout, curl, $stateParams,
                    $location, ItemFact, Supplier, Inventory, BrnFact, transact) {
    console.log("Initializing Purchase Order Module!");
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    var tbxCnf;
    Auth.config(function(rsp) {
        tbxCnf = rsp;
        $scope.tbxConfig = tbxCnf;
    });
    
    var usr = Auth.currentUser();
    var notif = function(message,status=false) {
        spinner.alert({status: status, message: message});
        $timeout(function() {spinner.alert_off();}, 1500);
        return status;
    }
    
    $scope.purchase = {
        header: {
            PONumber: '',
            TransDate: $filter('date')(new Date(), 'MM/dd/yyyy'),
            DeliveryDate: $filter('date')(new Date(), 'MM/dd/yyyy'),
            ShipToBranch: 0,
            Supplier: 0,
            Quantity: 0,
            Total: 0,
            GTotal: 0,
            Comments: '',
            CreatedBy: usr.UID
        },
        rows: []
    }
    
    Inventory.getWarehouse(function(whs) { $scope.WhsList = whs; });
    BrnFact.getActive(1,function(brn) {$scope.branches = brn; $scope.brnLoader = false;});
    Supplier.all(function(supp) {$scope.suppliers = supp;});
    // ItemFact.activeProducts(1, function(itm) { $scope.productLists = itm; $scope.itemLoader = false;});
    
    $scope.updateValue = function() {
        $scope.purchase.header.Total = 0;
        $scope.purchase.header.GTotal = 0;
        $scope.purchase.header.Quantity = 0;
        
        spinner.show();
        $timeout(function() {
            angular.forEach($scope.purchase.rows, function(index) {
                $scope.purchase.header.Quantity += index.Quantity;
                $scope.purchase.header.Total += index.Total;
                $scope.purchase.header.GTotal += index.GTotal;
            });
            
            spinner.hide();
        },100);
    }
    
    $scope.removeItem = function(index) {
        $scope.purchase.rows.splice(index,1);
        $scope.updateValue();
    }
    
    //Search Products
    $scope.GetProduct = function() {
        var SearchProduct = $scope.SearchProduct;
        if(SearchProduct==undefined || SearchProduct.length==0) {
            return false; //spinner.notif("Please Scan Itemcode!", 1000);
        }

        $scope.itemLoader = true;
        ItemFact.search({
            IsActive: 1,
            BarCode: SearchProduct
        }, function(rsp){
            $scope.itemLoader = false;
            if(!rsp.status) {
                $scope.SearchProduct = null;
                spinner.notif(rsp.message, 1500);
            }else{
                $scope.SearchProduct = null;
                var data = rsp.data[0];
                $scope.purchase.header.Quantity += 1;
                $scope.purchase.header.Total += parseFloat(data.StdCost);
                $scope.purchase.header.GTotal += parseFloat(data.StdCost) * ((parseInt(tbxCnf.IsPurchaseTaxable)==1) ? 
                                                                             (1+(parseInt(tbxCnf.InputTax)/100)) : 1);
                
                var item = {
                    PID: parseInt(data.PID),
                    BarCode: data.BarCode,
                    ProductDesc: data.ProductDesc,
                    SKU: data.SKU,
                    StdCost: parseFloat(data.StdCost),
                    Quantity: 1, 
                    Discount: 0, 
                    Warehouse: '1',
                    InputVat: (parseInt(tbxCnf.IsPurchaseTaxable)==1) ? parseInt(tbxCnf.InputTax) : 0,
                    Total: parseFloat(data.StdCost),
                    GTotal: parseFloat(data.StdCost) * ((parseInt(tbxCnf.IsPurchaseTaxable)==1) ? (1+(parseInt(tbxCnf.InputTax)/100)) : 1)
                };
                
                $scope.purchase.rows.push(item);
            }
        });
    }
    
    $scope.Filler = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        return (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
    }
    
    $scope.GetShipToBranch = function(selected) {
        $scope.ShowBranchSelect = true;
        $scope.purchase.header.ShipToBranch = selected.originalObject.BranchID;
        $scope.DeliveryStore = selected.originalObject.Description;
        $scope.DelEmail = selected.originalObject.BranchEmail;
        $scope.DelAddress = selected.originalObject.Address;
    }
    
    $scope.GetSupplier = function(selected) {
        $scope.ShowSupplier = true;
        $scope.purchase.header.Supplier = selected.originalObject.SuppID;
        $scope.SuppName = selected.originalObject.CoyName;
        $scope.SuppEmail = selected.originalObject.Email;
        $scope.SuppContact = selected.originalObject.ContactPerson;
    }
    
    $scope.resetShipToBranch = function(hdr){
        hdr.ShipToBranch = 0;
        $scope.ShowBranchSelect = false;
    }
        
    $scope.resetSupplier = function(hdr){
        hdr.Supplier = 0;
        $scope.ShowSupplier = false;
    }
    
    $scope.SubmitPurchaseOrder = function(hdr,row) {
        var TransID = transact.TransID(hdr.ShipToBranch);
        $scope.purchase.header.TransID = TransID;
        $scope.purchase.header.TransDate = $filter('date')(Date.parse(hdr.TransDate), 'yyyy-MM-dd');
        $scope.purchase.header.DeliveryDate = $filter('date')(Date.parse(hdr.DeliveryDate), 'yyyy-MM-dd');
        
        var currentdate = $filter('date')(new Date(), 'yyyy-MM-dd');
        
        if(row.length == 0) {
            return notif('Please select a product to purchase');}
        
        if(hdr.PONumber.length == 0) {
            return notif('Please enter a Purchase Order Number.');}
        
        if(hdr.DeliveryDate < currentdate) {
            return notif('Delivery Date should be greater than the current date!');}
        
        if(hdr.ShipToBranch == 0 || hdr.Supplier ==0) {
            return notif('Please select Delivery Branch and Supplier');}
        
        spinner.show();
        curl.post('/transactions/SubmitPurchase', $scope.purchase, function(rsp) {
            spinner.hide();
            notif(rsp.message, rsp.status);
            if(rsp.status) {
                $location.path('/purchase/receipt/' + TransID);
            }
        });
    }
    
    
    console.log('Purhase Order Module has been initialized!');
}

function purchaseReceiptCtrl($scope, $stateParams, curl, Auth, transact, spinner) {
    Auth.config(function(rsp) {
        $scope.config = rsp;
    });
    
    spinner.show();
    curl.get('/transactions/PurchaseReceipt/' + $stateParams.TransID, function(rsp) {
        $scope.purchase = rsp;
        spinner.hide();
    });
}

function purchaseHistoryCtrl($scope, transact, Auth, spinner, filterFilter, $filter, BrnFact, $timeout) {
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Type: -1,
        ShipToBranch: parseInt(usr.Branch.BranchID),
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
    var params = (usr.Roles!=4) ? 'Status<2' : 'Status<2 and ShipToBranch =' +usr.Branch.BranchID;
    transact.history(params, 'view_purchase', function(rsp) {
        spinner.hide();
        $scope.pList = rsp;
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });

    $scope.ExportCSV = function(f) {
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var status = (f.Type==-1) ? '' : ' and Status =' + parseInt(f.Type);
        var branch = (f.AllBranch) ? '':' and ShipToBranch =' + ((usr.Roles !=4) ? parseInt(f.ShipToBranch) :parseInt(usr.Branch.BranchID));
        
        var params = 'TransDate <= "' + DateTo + '" and TransDate >= "' + DateFrom + '"' + status + branch;
        spinner.show();
        transact.history(params, 'report_purchase', function(rsp) {
            $scope.PurchaseList = rsp;

            $timeout(function() {
                spinner.hide(); 
                $('#HideExport').click();
            },1000);
        });

    }

    $scope.exportFields = {
        TransDate: 'Date',
        PONumber: 'Reference Number',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        BarCode: 'Item Code',
        ProductDesc: 'Item Name',
        SKU: 'SKU',
        WhsName: 'Warehouse',
        Cost: 'Dealers Price',
        InputVat: 'Input Vat',
        Quantity: 'Quantity',
        RowReceivedQty: 'Received Qty',
        RowTotal: 'Total',
        RowGTotal: 'Grand Total',
        StatusDesc: 'Status',
        CoyName: 'Supplier Name',
        ContactPerson: 'Contact Person',
        SupplierEmail: 'Email',
        BillTo: 'Bill To',
        DisplayName: 'Cashier'
    } 
    
    
    BrnFact.getActive(1, function(rsp) {$scope.branches = rsp});
    
    $scope.Po_filter = function(id) {
        spinner.show();
        var params = (usr.Roles!=4) ? {PONumber:id} : {PONumber:id, ShipToBranch: usr.Branch.BranchID};
        transact.history.purchase(params, function(rsp) {
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
        var status = (f.Type==-1) ? '' : ' and Status =' + parseInt(f.Type);
        var branch = (f.AllBranch) ? '':' and ShipToBranch =' + ((usr.Roles !=4) ? parseInt(f.ShipToBranch) :parseInt(usr.Branch.BranchID));
        
        var params = 'TransDate <= "' + DateTo + '" and TransDate >= "' + DateFrom + '"' + status + branch;
        
        spinner.show();
        transact.history(params, 'view_purchase', function(rsp) {
            spinner.hide();
            
            $scope.pList=rsp;
            $scope.collapse = true;
            $scope.find.Status = (f.Type==-1) ? '':f.Type;
            
            $scope.totalItems = $scope.pList.length; $scope.currentPage = 1;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);    
            
            if(rsp.length==0) {
                spinner.alert({status:false,message:"No Record Found!"}, 1000);
            }
        });
    }
    
    $scope.ClosedPurchase = function(p, indx) {
        var cls = (parseInt(p.ReceivedQty)!=0) ? 'closed' : 'cancel';
        var sts = (parseInt(p.ReceivedQty)!=0) ? 2 : 3;
        
        var cnf = window.confirm("Are you sure you want to " + cls + " this PO?");
        
        if(cnf){
            transact.update.purchase({
                id: {PurID:p.PurID}, fields:{Status:sts}, 
                table:'trx_purchase'}, function(rsp) {
                $scope.pList.splice(indx,1);
            });   
        }
    }
}

function purchaseReceivedCtrl($scope, transact, Auth, $location, curl, $q,
                    spinner, $state, $stateParams, $timeout, $filter) {
    console.log('Initializing PO Received Module!');
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.reload = function() {
        $state.reload();
    }
    
    $scope.po = {};
    
    if($stateParams.transid) {
        transact.receipt.purchase($stateParams.transid, function(rsp) {
            $scope.po = rsp;
            angular.forEach(rsp.rows, function(ind) {
                ind.Serials = [];
                if(parseInt(ind.IsSerialized)==1) {
                    transact.history('PurRowID=' + ind.PurRowID, 'trx_purchase_detail', function(serial) {
                        angular.forEach(serial, function(r) {
                            ind.Serials.push(r.Serial);
                        });
                    });
                }
            });
        });
    }
    
    /** Update Database Quantity **/
    function updateDBQty(id, data, po, indx, currentQty, smr) {
        po.header.ReceivedQty = 0;
        
        $timeout(function() {
            angular.forEach(po.rows, function(index) {
                po.header.ReceivedQty += parseInt(index.ReceivedQty);
            });
                
            transact.Update({PurRowID:id},{ReceivedQty:data}, 'trx_purchase_row', function(rsp){
                transact.Update({PurID:po.header.PurID},{ReceivedQty:parseInt(po.header.ReceivedQty)},'trx_purchase', function(rsp) {
                    var datas = {
                        Branch: parseInt(po.header.ShipToBranch),
                        Warehouse: parseInt(po.rows[indx].Warehouse),
                        Product: parseInt(po.rows[indx].ProductID),
                        InStocks: data - currentQty
                    }
                    
                    transact.Inventory(datas, function(rsp) {spinner.hide();});
                });
            });
        },100);
    }
    
    /** Update Purchase Quantity of non-serialized **/
    $scope.updateReceivedQty = function(id, data, po, indx, currentQty) {
        spinner.show();
        var q = data - currentQty;
        var row = po.rows[indx];
        
        var smr = [{
            TransID: po.header.TransID,
            Date: po.header.TransDate,
            RefNo: po.header.PONumber,
            Module: '/purchase',
            TransType: '',
            Product: parseInt(row.ProductID),
            Warehouse: parseInt(row.Warehouse),
            Branch: parseInt(po.header.ShipToBranch),
            Serial: '',
            MoveIn: (q>0) ? q:0,
            MoveOut: (q<0) ? q*-1:0,
        }];
        updateDBQty(id, data, po, indx, currentQty);
        transact.smr(smr);
    }
    
    /** Add / Update Purchase Serial and Quantity **/
    $scope.addSerial = function(index,data, currentQty) {
        $scope.po.header.ReceivedQty = 0;
        $scope.po.rows[index].Serials = [];
        
        var save = [];
        spinner.show();
        angular.forEach(data, function(i) {
            $scope.po.rows[index].Serials.push(i.text);
            save.push({PurRowID: parseInt($scope.po.rows[index].PurRowID), Serial: i.text})
        });
        
        $scope.po.rows[index].ReceivedQty = $scope.po.rows[index].Serials.length;

        angular.forEach($scope.po.rows, function(ind) {
            $scope.po.header.ReceivedQty += parseInt(ind.ReceivedQty);
        });
        
        curl.post('/transactions/InsertPurchaseSerial', {
            PurRowID: $scope.po.rows[index].PurRowID,
            data: save
        }, function(rsp) { 
            spinner.hide();
            updateDBQty(
                parseInt($scope.po.rows[index].PurRowID), 
                $scope.po.rows[index].Serials.length, 
                $scope.po, index, currentQty
            );
        });
    }
    
    $scope.updateStatus = function(status,hdr) {
        var cnf = window.confirm("Are you sure you want to mark this PO?");
        if(cnf) {
            spinner.show();
            transact.Update({PurID:hdr.PurID},{Status:status},'trx_purchase', function(rsp) {
                spinner.hide();
                $location.path('/purchase/history');
            });
        }
    }

    $scope.test = function(data) {
        console.log(data);
    }
    
    $scope.checkSerial = function(data, po, tag, index, type) {
        var incr = data.length + 1;
        if(type && incr > po.rows[index].Quantity) {
            spinner.notif('Serial exceeds quantity', 1000);
            return false;
        }
        var datas = {
            Branch: parseInt(po.header.ShipToBranch),
            Product: parseInt(po.rows[index].ProductID),
            Warehouse: parseInt(po.rows[index].Warehouse),
            Serial: tag.text
        }
        
        var row = po.rows[index];
        var smr = [{
            TransID: po.header.TransID,
            Date: po.header.TransDate,
            RefNo: po.header.PONumber,
            Module: '/purchase',
            TransType: '',
            Product: parseInt(row.ProductID),
            Warehouse: parseInt(row.Warehouse),
            Branch: parseInt(po.header.ShipToBranch),
            Serial: tag.text,
            MoveIn: (type) ? 1:0,
            MoveOut: (!type) ? 1:0,
        }];
        
        spinner.show();
        var result;
        curl.ajax('/inventories/InsertRemoveSerial', 
                  {datas: datas, type: type}, function(rsp) {
            spinner.hide();
            result = rsp.status;
            if(rsp.status) {
                transact.smr(smr);
            }else{
                spinner.notif(rsp.message, 1000);
            }
        });
        return result;
        
    }
    
    $scope.countSerial = function(b, data) {
        var r = data.length;
        var q = b.Quantity;
        if(r>q) {
            return 'Received exceeds purchase Quantity! Contact HO if it really exceed.';
        }
    }
    
    console.log("PO Received module has been successfully initialized!");
}

function purchaseReceivedReceiptCtrl($scope, $stateParams, curl, Auth, transact) {
    Auth.config(function(rsp) {
        $scope.config = rsp;
    });
    
    $scope.purchase = {};
    
    if($stateParams.transid) {
        transact.receipt.purchase($stateParams.transid, function(rsp) {
            $scope.purchase = rsp;
            angular.forEach(rsp.rows, function(ind) {
                ind.Serials = [];
                if(parseInt(ind.IsSerialized)==1) {
                    transact.history('PurRowID=' + ind.PurRowID, 'trx_purchase_detail', function(serial) {
                        angular.forEach(serial, function(r) {
                            ind.Serials.push(r.Serial);
                        });
                    });
                }
            });
        });
    }

    $scope.getReceivedTotal = function() {
        var totals = 0;
        angular.forEach($scope.purchase.rows, function(i) {
            totals += i.Cost * i.ReceivedQty;
        });

        return totals;
    }
}

app.controller('purchaseCtrl', purchaseCtrl);
app.controller('purchaseReceiptCtrl', purchaseReceiptCtrl);
app.controller('purchaseHistoryCtrl', purchaseHistoryCtrl);
app.controller('purchaseReceivedCtrl', purchaseReceivedCtrl);
app.controller('purchaseReceivedReceiptCtrl', purchaseReceivedReceiptCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('#PoBranch, #PoSupplier').select2();
});