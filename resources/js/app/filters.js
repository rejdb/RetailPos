app.filter('DataFilter', function() {
    return function(data, start) {
        start = +start;
        return data.slice(start);
    }
});

app.filter('userRoles', function() {
    return function(input) {
        switch(input) {
            case 1: return 'Administrator';
            case 2: return 'HO Personnel';
            case 3: return 'Store Manager';
            case 4: return 'Frontliner';
        }
    }
});

app.filter('dateFilter', function($filter) {
    return function(date, format) {
        return $filter('date')(new Date(date), format);
    }
});

app.filter('ageing', function($filter) {
    return function(date, format) {
        var current = new Date().getTime();
        var ageDate = new Date(date);
        return (Math.ceil((current - ageDate) / 86400000))
    }
});

app.filter('peso', function($filter) {
    return function(input, decimal) {
        return '₱ ' + $filter('number')(input,decimal);
    }
});

app.filter('purchaseStatus', function($filter) {
    return function(input) {
         switch(input) {
            case 0: return 'Open';
            case 1: return 'Partial';
            case 2: return 'Closed';
            case 3: return 'Canceled';
        }
    }
});

app.filter('transferStatus', function($filter) {
    return function(input) {
         switch(input) {
            case 1: return 'For Approval';
            case 2: return 'Approved';
            case 3: return 'Received';
            case 4: return 'Canceled';
        }
    }
});

app.filter('pulloutStatus', function($filter) {
    return function(input) {
         switch(input) {
            case 1: return 'For Approval';
            case 2: return 'Approved';
            case 3: return 'Confirmed';
            case 4: return 'Canceled';
        }
    }
});

app.filter('serialStatus', function($filter) {
    return function(input) {
         switch(input) {
            case 0: return 'Available';
            case 1: return 'Sold';
            case 2: return 'For Transfer';
            case 3: return 'For Pullout';
        }
    }
});

app.filter('postpaidStatus', function($filter) {
    return function(input) {
         switch(input) {
            case 0: return 'For Activation';
            case 1: return 'Activated';
            case 2: return 'Cancelled';
        }
    }
});

app.filter('expiry', function($filter) {
    return function(input) {
        var current = new Date().getTime();
        var xpry = new Date(input).getTime();
        
        var days = Math.ceil((xpry-current)/86400000);
        if(days<=30 && days>0) {
            return days.toString() + ' days before expiration';
        }else if(days<0) {
            return 'Contract Expired!';
        }else{
            return input;
        }
    }
});

app.filter('xpry_day', function($filter) {
    return function(input) {
        var current = new Date().getTime();
        var xpry = new Date(input).getTime();
        
        var days = Math.ceil((xpry-current)/86400000);
        return days;
    }
});

app.filter('padZero', function($filter) {
    return function(input) {
        Number.prototype.pad = function(size) {
          var s = String(this);
          while (s.length < (size || 2)) {s = "0" + s;}
          return s;
        }

        return input.pad(5);
    }
});