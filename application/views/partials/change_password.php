<div class="row">
    <div class="col-xs-12">
        <div id="login-box">
            <div class="row">
                <div class="col-xs-12">
<!--
                    <header id="login-header">
                        <div id="login-logo">
                            <img src="img/logo.png" alt=""/>
                        </div>
                    </header>
-->
                    <div id="login-box-inner">
                        <div id="lock-screen-user">
                            <img ng-src="/resources/img/avatar/agent/{{userProfile.Avatar}}" alt="">
                            <div class="user-box">
                                <span class="name">
                                    {{userProfile.DisplayName}}
                                </span>
                            </div>
                        </div>
<!--                        <pre>{{userProfile | json}}</pre>-->
                        <form name="form" ng-submit="ChangePassword(password)" novalidate="novalidate">
                            <div class="form-group" ng-init="password.email=userProfile.Email">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" 
                                           ng-model="password.current" required
                                           placeholder="Current password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" 
                                           ng-minlength=8 ng-maxlength=20
                                           ng-model="password.new" required
                                           placeholder="New password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" 
                                           ng-minlength=8 ng-maxlength=20
                                           ng-model="password.confirm" required
                                           placeholder="Confirm password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-success col-xs-12">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>