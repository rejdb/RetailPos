'use scrict';

app.service('spinner', ['$rootScope', '$timeout', function($rootScope, $timeout) {
    this.on = function() { $rootScope.loadSpinner = true; }
    this.off = function() { $rootScope.loadSpinner = false; }
    this.show = function() { $rootScope.loadSpinner = true; }
    this.hide = function() { $rootScope.loadSpinner = false; }
    this.alert = function(alert_me, timer=0) { 
        $rootScope.notify = true;
        $rootScope.successfully = alert_me.status;
        $rootScope.alert_message = alert_me.message;
        if(timer!=0) {
            $timeout(function() {
                $rootScope.notify = false;
            }, timer);
        }
    } 
    
    this.notif = function(message, timer=0, status=false) {
        $rootScope.notify = true;
        $rootScope.successfully = status;
        $rootScope.alert_message = message;
        if(timer!=0) {
            $timeout(function() {
                $rootScope.notify = false;
            }, timer);
        }
    }
    this.alert_off = function() { $rootScope.notify = false; }
}]);
app.service('curl', ['$http', function($http) {
    var api = {Url: '/api',Token: '3acf5c7b740d6e2538f3a7b88cf069b3'};
    this.get = function(url, callback) {
        $http({
            url: api.Url + url,
            method: 'GET',
            headers: { 'x-api-key' : api.Token }
        }).then(function(response){
            callback(response.data);
        }, function(error) {
            console.log(error);
        });
    }

    this.post = function(url, postData, callback) {
        $http({
            url: api.Url + url,
            method: 'POST',
            data: postData,
            headers: { 'x-api-key' : api.Token }
        }).then(function(response){
            callback(response.data);
        }, function(error) {
            console.log(error);
        });
    }
    
    this.ajax = function(url, postData, callback, asynch=false) {
        $.ajax({
            type: 'POST',
            url: api.Url + url,
            data: postData,
            headers: { 'x-api-key' : api.Token },
            async: asynch,
            success: function(rsp) {
                callback(rsp);
            }
        });
    }
    
    this.ajaxG = function(url, callback, asynch=false) {
        $.ajax({
            type: 'GET',
            url: api.Url + url,
            headers: { 'x-api-key' : api.Token },
            async: asynch,
            success: function(rsp) {
                callback(rsp);
            }
        });
    }
}]);
app.service('cookie', ['$cookieStore', function($cookieStore) {
    this.get = function(cookie_name) {
        return $cookieStore.get(cookie_name);}
    
    this.put = function(cookie_name, cookie_value) {
        $cookieStore.put(cookie_name, cookie_value); }
    
    this.remove = function(cookie_name) {
        $cookieStore.remove(cookie_name);}
}]);


//User CRUD
app.factory('Auth', ['curl','cookie', '$rootScope', 
    function(curl,cookie, $rootScope) {
    var auth = {};
    
    /**
     *  Saves the current user in the root scope
     *  Call this in the app run() method
     */
    auth.init = function(){
        if (auth.isLoggedIn()){
            $rootScope.userProfile = auth.currentUser();
        } var c=new Date().getTime();var x=new Date(2017, 3, 12).getTime();
        // if(Math.ceil((x-c)/86400000)<0){window.location.href="/home/payment"};
    };
        
    auth.MainPage = function() {
        curl.get('/transactions/MainPage/' + auth.currentUser().Branch.BranchID, function(rsp) {
            $rootScope.MainPage = rsp;
        });
    }
        
    auth.config = function(callback) {
        curl.get('/setup/config', function(rsp) {
            callback(rsp.config);
        });
    }
    
    auth.login = function(username, password, callback) {
        curl.post('/users/login', {
            Email: username,
            Password: password
        }, function(rsp) {
            if(rsp.success) {
                cookie.put('profile', rsp.user);}
            callback(rsp);
        });
    }
    
    auth.logout = function() {
        cookie.remove('profile')
        $rootScope.userProfile = '';
    };
        
    auth.checkPermissionForView = function(view) {
        if (!view.authenticate) {
            return true;
        }
         
        return userHasPermissionForView(view);
    };
        
    var userHasPermissionForView = function(view){
        if(!auth.isLoggedIn()){
            return false;
        }
         
        if(!view.permissions || !view.permissions.length){
            return true;
        }
         
        return auth.userHasPermission(view.permissions);
    };
        
    auth.userHasPermission = function(permissions){
        if(!auth.isLoggedIn()){
            return false;
        }
         
        var found = false;
        angular.forEach(permissions, function(permission, index){
            if (auth.currentUser().Roles.indexOf(permission) >= 0){
                found = true;
                return;
            }                        
        });
         
        return found;
    };
    
    auth.currentUser = function(){
        return cookie.get('profile');
    };
     
     
    auth.isLoggedIn = function(){
        return cookie.get('profile') != null;
    };
    
    return auth;
}]);
app.factory('UserFact', ['curl', function(curl) {
    var usr = {};
    
    usr.getUsers = function(role, callback) {
        curl.get("/setup/users/" + role, function(rsp) {
           callback(rsp); 
        });
    };
    
    
    usr.getBrnUser = function(brn, callback) {
        curl.get("/users/BranchFL/" + brn, function(r) {
            callback(r);
        })
    }
    
    usr.addUser = function(uri, data, callback) {
        curl.post(uri, data, function(rsp) {
            callback(rsp);
        });
    }
    
    usr.update = function(id, field, data, callback, type) {
        if(type) {
            var postData = '{"UID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{
            var postData = '{"UID":' + id + ',"type": {"' + field + '":"' + data + '"}}';
        }
        
        //callback(postData);
        curl.post('/users/update', postData, function(rsp) {
            callback(rsp);
        });
    }
    
    usr.resetPwd = function(uid, callback) {
        var def = 'd8578edf8458ce06fbc5bb76a58c5ca4';
        curl.post('/users/resetPwd', {UID: uid, Data:{Password: def}}, function(rsp) {
            callback(rsp);
        });
    }
    
    usr.deActivate = function(uid, callback) {
        curl.get('/setup/useractivate/' + uid, function(rsp) {
            callback(rsp);
        });
    }
    
    return usr;
}]);
app.factory('ItemFact', ['curl', function(curl) {
    var itm = {};
    
    //get all products
    itm.products = function(callback) {
        curl.get('/items/all', function(rsp) {
            callback(rsp);
        });
    }
    
    //get product by status
    itm.activeProducts = function(IsActive, callback) {
        curl.get('/items/active/' + IsActive, function(rsp) {
            callback(rsp.data);
        });
    }
    
    //search Item master data
    itm.search = function(postData, callback) {
        curl.post('/items/search', postData, function(rst) {callback(rst);});}
    
    //update item master by field
    itm.update = function(id, field, data, callback, type) {
        if(type) { var postData = '{"PID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{ var postData = '{"PID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.post('/items/update', postData, function(rsp) { callback(rsp); });
    }
    
    //get all item table reference
    itm.tableReference = function(callback) {
        curl.get('/items/links', function(rsp) { callback(rsp); });
    }
    
    //add item to table reference
    itm.addReference = function(type, data, callback) {
        var post = {table:type, data: {Description: data}};
        curl.post('/items/addReference', post, function(rsp) { callback(rsp); }); }

    //add item to table reference
    itm.updateReference = function(id, table, data, callback) {
        var post = {table:table, id:id, data: {Description: data}};
        curl.post('/items/updateReference', post, function(rsp) { callback(rsp); }); }
    
    //add new product to the database
    itm.addNewProductDB = function(postData, callback) {
        curl.post('/items/addNewProduct', postData, function(i) { callback(i); }); }
    
    //update Price
    itm.updateCurrentSRP = function(id, field, data, callback) {
        var postData = '{"PDID":' + id + ',"type":{"' + field + '":' + data + '}}';
        curl.post('/items/updatePrice', postData, function(r) {callback(r);});
    }
    
    itm.addCampaign = function(postData, callback) {
        curl.post('/items/addCampaign', postData, function(result) {
            callback(result);
        });
    }
    
    itm.getAllCampaign = function(callback) {
        curl.get('/items/getCampaign', function(result) { callback(result); });
    }
    
    itm.deleteCampaign = function(CampaignID, callback) {
        curl.get('/items/deleteCampaign/' + CampaignID, function(result) {callback(result);});
    }
    
    return itm;
}]);
app.factory('BrnFact', ['curl', function(curl) {
    var brn = {};
    
    brn.getReferences = function(callback) {
        curl.get('/branches/links', function(result) {
            callback(result);
        });
    }
    
    brn.getBranches = function(callback) {
        curl.get('/branches/lists', function(result) {
            callback(result);
        });
    }
    
    brn.getActive = function(status,callback) {
        curl.get('/branches/status/' + status, function(result) { callback(result); });
    }
    
    brn.getTarget = function(BranchID, callback) {
        curl.get('/branches/getTarget/'+BranchID, function(result) {
            callback(result);
        });
    }
    
    brn.addTarget = function(data) {
        curl.post('/branches/saveTarget', data, function(rsp) {
            console.log(rsp);
        });
    }
    
    //update Branches by field
    brn.updateField = function(id, field, data, callback, type) {
        if(type) { var postData = '{"BranchID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{ var postData = '{"BranchID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.post('/branches/setVal', postData, function(rsp) { callback(rsp); });
    }
    return brn;
}]);
app.factory('Inventory', ['curl', function(curl) {
    var inv = {};
    
    /* Warehouse Related Script **
     *** Get all warehouses */
    inv.getWarehouse = function(callback) { 
        curl.get('/Inventories/warehouse', function(rsp) {callback(rsp);});}
    
    inv.getActiveWhs = function(status, callback) {
        curl.get('/Inventories/activeWhs/' + status, function(rsp) {
            callback(rsp);});
    }
    /*** Add New Warehouse */
    inv.addWarehouse = function(whsName, callback) {
        curl.post('/Inventories/addWarehouse', whsName, function(rsp) {
            callback(rsp);
        });
    }
    
    //update Warehouse by field
    inv.updateField = function(id, field, data, callback, type) {
        if(type) { var postData = '{"WhsCode":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{ var postData = '{"WhsCode":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.ajax('/inventories/updateWarehouse', JSON.parse(postData), function(rsp) { callback(rsp); });
    }
    
    /* End of Warehouse Related Scripts */
    
    /* BoM Related Scripts 
     * Get all BoM *********/
    inv.getBoM = function(callback) {
        curl.get('/Inventories/allBoM', function(rsp) {
            callback(rsp);
        });
    }
    
    /* Update BoM Fields */
    inv.updateBoM = function(id, field, data, callback, type) {
        if(type) { var postData = '{"BoMID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{ var postData = '{"BoMID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.post('/Inventories/updateBoM/Main', postData, function(rsp) { callback(rsp); });
    }
    
    /* Update BoM Item Fields */
    inv.updateBoMItem = function(id, field, data, callback, type) {
        if(type) { var postData = '{"BoMSID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{ var postData = '{"BoMSID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.post('/Inventories/updateBoM/Item', postData, function(rsp) { callback(rsp); });
    }
    
    /* Insert BoM to Database */
    inv.addBoM = function(postData, callback) {
        curl.post('/Inventories/InsertBoM', postData, function(rst) {callback(rst);});
    }
    
    /* End of BoM Related Scripts */
    
    inv.search = function(search, callback) {
        curl.get('/Inventories/search/' + search, function(rsp) {
            callback(rsp);
        });
    }
    return inv;
}]);
app.factory('Supplier',['curl', function(curl) {
    var sp = {};
    
    /* Get all Suppliers */
    sp.all = function(callback) {
        curl.get('/suppliers/all', function(rsp) {callback(rsp)});}
    
    /* Add new Supplier */
    sp.add = function(postData, callback) {
        curl.post('/suppliers/add', postData, function(rst) {callback(rst)});}
    
    /* Update Supplier Fields */
    sp.updateField = function(id, field, data, callback, type) {
        if(type) { var postData = '{"SuppID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{ var postData = '{"SuppID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.post('/suppliers/update', postData, function(rsp) { callback(rsp); });
    }
    
    return sp;
}]);
app.factory('Customer',['curl', function(curl) {
    var c = {};
    
    c.all = function(callback) {
        curl.get('/customers/all', function(rsp) {callback(rsp);});}
    
    c.active = function(status, callback) {
        curl.get('/customers/status/' + status, function(rsp) {callback(rsp);});}
    
    c.add = function(postData, callback) {
        curl.post('/customers/add', postData, function(rsp){callback(rsp);});}
    
    c.updateField = function(id, field, data, callback, type) {
        if(type) { var postData = '{"CustID":' + id + ',"type": {"' + field + '":' + data + '}}';
        }else{ var postData = '{"CustID":' + id + ',"type": {"' + field + '":"' + data + '"}}';}
        
        curl.post('/customers/update', postData, function(rsp) { callback(rsp); });
    }
    return c;
}]);
app.factory('transact',['curl','$filter','$window', function(curl, $filter,$window) {
    var trx = {};
    
    trx.TransID = function(StoreID) {
        Number.prototype.pad = function(size) {
          var s = String(this);
          while (s.length < (size || 2)) {s = "0" + s;}
          return s;
        }
        var current = new Date().getTime();
        var first_day = new Date(new Date().getFullYear(), 0, 1);
        
        var dayOfYear = (Math.ceil((current - first_day + 1) / 86400000)).pad(3);
        var dt = $filter('date')(new Date(), 'yyHHmm');
        var rnd = Math.ceil(Math.random()*999);
        
        var TransID = dt + dayOfYear + parseInt(StoreID).pad(3) + rnd;
        return TransID;
    }
    
    trx.installment = function(status,callback) {
        curl.get('/Setup/Installment/' + status, function(r) {
            callback(r);
        });
    }
    
    trx.terminal = function(status,callback) {
        curl.get('/Setup/Terminal/' + status, function(r) {
            callback(r);
        });
    }
    
    
    
    trx.receipt = {
        purchase: function(params, callback) {
            curl.get('/transactions/PurchaseReceipt/' + params, function(rsp) {
                callback(rsp);
            });
        }
    }
    
    trx.history = function(params, table, callback) {
        curl.post('/transactions/History', {params: params, table:table}, function(rsp) {
            callback(rsp);
        });
    }
    
    
    /** Parameter Setting ******************
     ** id:{Table_PrimaryKey: value}, ******
     ** fields: {All For Update Fields},****
     ** table: 'Table Name' ****************/
    trx.Update = function(id, fields, table, callback) {
        curl.post('/transactions/Update', {id: id, fields:fields, table:table}, function(rsp) {
            callback(rsp);
        });
    }
    
    trx.smr = function(datas) {
        curl.post('/transactions/InsertSMR', datas, function(r) { console.log(r);});
    }
    
    trx.update = { // field = {id:{}, fields:{}, table:''}
        purchase: function(field, callback) {
            curl.post('/transactions/PurchaseUpdate', field, function(rsp) {
                callback(rsp);
            });},
        invoice: {}
    }
    
    /** Insert / Update Inventory Record **/
    trx.Inventory = function(params, callback) {
        curl.post('/inventories', params, function(rec) {
            callback(rec);
        });
    }
    
    /** Check Serial if exists **/
    trx.CheckSerial = function(serial, callback) {
        curl.get('/inventories/CheckSerial/', + serial, function(rsp) {
            callback(rsp);
        });
    }
    
    trx.ChangeTransferStatus = function(TransID, status, store, userid, params, usr, callback) {
        var m = (status==2) ? 'Approved': (status==3) ? 'Received' : 'Cancel';
        var cnf = window.confirm('Are you sure do you want to '+m+' this transaction?');
        if(cnf) {
            var data = {
                type: status,
                TransID: TransID,
                Approver: userid,
                NewID: trx.TransID(store)
            }
            
            curl.post('/transactions/ChangeTransferStatus', data, function(r) {
                if(r.status) {
                    trx.history(params, 'view_transfer', function(rsp) {
                        var pList = rsp;
                        trx.history('TransferType=0 and Status=2 and InvTo =' + usr.Branch.BranchID, 'view_transfer', function(li) {
                            if(li.length) {
                                angular.extend(pList, li); }
                            
                            callback({
                                status: r.status,
                                message: r.message,
                                myList: pList
                            });
                        });
                    });
                }else{
                    callback({
                        status: r.status,
                        message: r.message
                    });
                }
            });
        }else{
            callback({
                status: false,
                message: 'Confirmation dialog was canceled'
            });
        }
    }
    
    trx.ChangePulloutStatus = function(TransID, status, userid, params, usr, callback) {
        var m = (status==2) ? 'Approved': (status==3) ? 'Confirmed' : 'Cancel';
        var cnf = window.confirm('Are you sure do you want to '+m+' this transaction?');
        if(cnf) {
            var data = {
                type: status,
                TransID: TransID,
                Approver: userid
            }
            
            curl.post('/transactions/ChangePulloutStatus', data, function(r) {
                if(r.status) {
                    trx.history(params, 'view_pullout', function(rsp) {
                        callback({
                            status: r.status,
                            message: r.message,
                            myList: rsp
                        });
                    });
                }else{
                    callback({
                        status: r.status,
                        message: r.message
                    });
                }
            });
        }else{
            callback({
                status: false,
                message: 'Confirmation dialog was canceled'
            });
        }
    }
    
    return trx;
}]);