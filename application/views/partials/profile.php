<div class="row">
	<div class="col-lg-12">
		<div id="content-header" class="clearfix">
			<ol class="breadcrumb">
				<li><a href="">Home</a></li>
				<li><span>Users</span></li>
				<li class="active"><span>My Profile</span></li>
			</ol>
		
			<div class="clearfix">
				<h1 class="pull-left">My Profile</h1>
				
				<div class="pull-right top-page-ui">
					<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#mySuperUser">
						<i class="fa fa-plus-circle fa-lg"></i> Update Profile
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row" id="user-profile">
    <div class="col-lg-3 col-md-4 col-sm-4">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
				<h2>{{ profile.name }}</h2>
			</header>
            <div class="main-box-body clearfix">
                <div class="profile-status">
					<i class="fa fa-circle"></i> Online
				</div>
                <img ng-src="/resources/img/avatar/agent/{{profile.avatar}}" alt="" class="profile-img img-responsive center-block" />
                
                <div class="profile-label">
					<span class="label label-danger">{{profile.roles-0 | userRoles}}</span>
				</div><br/>
                
                <div class="profile-since">
					Member since: {{profile.createdate | date:'MMM yyyy'}}
				</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-9 col-md-8 col-sm-8">
        <div class="main-box clearfix">
            <div class="tabs-wrapper profile-tabs">
                <ul class="nav nav-tabs">
					<li class="active"><a showtab="" data-target="#tab-PeronalInfo" data-toggle="tab">Personal Info</a></li>
					<li><a showtab="" data-target="#tab-activity" data-toggle="tab">Activity</a></li>
					<li><a showtab="" data-target="#tab-friends" data-toggle="tab">Friends</a></li>
					<li><a showtab="" data-target="#tab-chat" data-toggle="tab">Chat</a></li>
				</ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab-PeronalInfo">
                        testing lang kung meron
                    </div>
                
                    <div class="tab-pane fade" id="tab-activity">
                        testing lang kung meron????
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/app/profile.js"></script>