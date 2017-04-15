<form ng-submit="addStore()" novalidate="novalidate" name="myForm">
<div class="row">
	<div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="active"><span>Branch</span></li>
            </ol>
            
            <div class="clearfix">
                <h1 class="pull-left">Branches <small>setup and manage store</small></h1>
                
                <div class="pull-right top-page-ui">
                    <a href="#/Branch/List" class="btn btn-success pull-right" style="margin-left:5px">
                        <i class="fa fa-plus-circle fa-lg"></i> Branch Lists
                    </a>
                    <button class="btn btn-primary pull-right">
                        <i class="fa fa-plus-circle fa-lg"></i> Add Branch
                    </button>
                </div>
            </div>
        </div>
	</div>
</div>


<div ng-show="notify" class="alert" ng-class="{'alert-danger': !success, 'alert-success': success}">
    <i class="fa fa-times-circle fa-fw fa-lg"></i>
    <strong>Opppsss!</strong> {{err_msg}}.
</div>    

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-sm-6 col-xs-12 clearfix">
                <div class="main-box">
                    <header class="main-box-header clearfix">
                        <h2>Store Information</h2>
                    </header>
                    <div class="main-box-body clearfix">
                        <div class="form-group col-xs-3">
                            <label for="BrnCode">Code</label>
                            <input type="text" class="form-control text-uppercase"
                                   ng-model="branch.BranchCode"
                                   id="BrnCode" required="required"
                                   placeholder="Store ID"  ng-maxlength="15">
                        </div>
                        <div class="form-group col-xs-9">
                            <label for="BrnDescription">Name</label>
                            <input type="text" class="form-control text-capitalize" 
                                   ng-model="branch.Description"
                                   id="BrnDescription" required="required"
                                   placeholder="Store Name" ng-maxlength=50>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="BrnBranchEmail">Email</label>
                            <input type="email" class="form-control" 
                                   ng-model="branch.BranchEmail"
                                   id="BrnBranchEmail" required="required"
                                   placeholder="Store Email" ng-maxlength=50>
                        </div>
                        <div class="form-group col-xs-2">
                            <label for="BrnBranchSize">Size (SQM)</label>
                            <input type="number" step="0.01" class="form-control" 
                                   ng-model="branch.BranchSize"
                                   id="BrnBranchSize" required="required"
                                   placeholder="Size" ng-maxlength=5>
                        </div>
                        <div class="form-group col-xs-4">
                            <label for="BrnExpiry">Contract Expiration</label>
                            <input type="date" class="form-control" 
                                   ng-model="branch.Expiry"
                                   id="BrnExpiry" required="required"
                                   placeholder="Expiration">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="BrnAddress">Address</label>
                            <textarea class="form-control" 
                                      ng-model="branch.Address"
                                      id="BrnAddress" required="required"
                                      rows="1" ng-maxlength="150"></textarea>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="BrnCity">What City?</label>
                            <select class="form-control"
                                    id="BrnCity"
                                    ng-model="branch.City"
                                    required="required">
                                <option ng-repeat="city in lnk.cities"
                                        value="{{city.CityID}}">
                                        {{city.City}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="BrnManager">Store Manager</label>
                            <select class="form-control"
                                    id="BrnManager"
                                    ng-model="branch.Manager"
                                    required="required">
                                <option ng-repeat="p in lnk.managers"
                                        value="{{p.UID}}">
                                        {{p.DisplayName}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 clearfix">
                <div class="main-box">
                    <header class="main-box-header clearfix">
                        <h2>Settings</h2>
                    </header>
                    <div class="main-box-body clearfix">
                        <div class="form-horizontal" role="form">
                            <div class="form-group col-sm-12">
                                <label for="inputEmail1" class="col-sm-3 control-label">Store Type</label>
                                <div class="col-sm-9">
                                    <div class="btn-group">
                                        <label class="btn btn-primary" ng-repeat="type in lnk.types"
                                               btn-radio="{{type.TypeID}}" ng-model="branch.Type">
                                            {{type.TypeDesc}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="inputEmail1" class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-9">
                                    <div class="btn-group">
                                        <label class="btn btn-primary" ng-repeat="c in lnk.categories"
                                               btn-radio="{{c.CatID}}" ng-model="branch.Category">
                                            {{c.Category}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="inputEmail1" class="col-sm-3 control-label">Store Group</label>
                                <div class="col-sm-9">
                                    <select class="form-control"
                                            cast-to-integer="true"
                                            ng-model="branch.Groups"
                                            required="required">
                                        <option ng-repeat="c in lnk.groups"
                                                value="{{c.GroupID}}">
                                            {{c.Description}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="inputEmail1" class="col-sm-3 control-label">Store Channel</label>
                                <div class="col-sm-9">
                                    <select class="form-control"
                                            cast-to-integer="true"
                                            ng-model="branch.Channel"
                                            required="required">
                                        <option ng-repeat="c in lnk.channels"
                                                value="{{c.ChannelID}}">
                                            {{c.Channel}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail1" class="col-sm-7 control-label">Price Include Tax?:</label>
                                <div class="col-sm-5">
                                    <switch ng-model="branch.IsTaxInclude" on="Yes" off="No" class="medium"></switch>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail1" class="col-sm-7 control-label">Allow Backdating?:</label>
                                <div class="col-sm-5">
                                    <switch ng-model="branch.IsBackdateAllowed" on="Yes" off="No" class="medium"></switch>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="inputEmail1" class="col-sm-3 control-label">Sales Tax:</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="number" class="form-control"
                                               ng-model="branch.SalesTax"
                                               id="BrnSalesTax" required="required"
                                               placeholder="Tax" min=0 max=15>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="number" class="form-control"
                                               ng-model="branch.DefaultReturnPolicy"
                                               id="BrnDefaultReturnPolicy" required="required"
                                               placeholder="Return Policy" min=7 max=15>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<!--<pre>{{ branch | json }}</pre>-->
<script src="/resources/js/app/branches.js"></script>