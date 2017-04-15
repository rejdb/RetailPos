<div class="row">
	<div class="col-lg-12">
		<div id="content-header" class="clearfix">
			<div class="pull-left">
				<ol class="breadcrumb">
					<li><a href="/">Home</a></li>
					<li class="active"><span>Dashboard</span></li>
				</ol>
				
				<h1>Dashboard</h1>
			</div>

			<div class="pull-right hidden-xs">
				<div class="xs-graph pull-left">
					<div class="graph-label">
						<b><i class="fa fa-shopping-cart"></i> 838</b> Orders
					</div>
					<div class="graph-content spark-orders"></div>
				</div>

				<div class="xs-graph pull-left mrg-l-lg mrg-r-sm">
					<div class="graph-label">
						<b>{{12338 | peso:2}}</b> Revenues
					</div>
					<div class="graph-content spark-revenues"></div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- this page specific scripts -->
<script src="/resources/js/dependencies/jquery.sparkline.min.js"></script>

<script>
$(document).ready(function() {

    /* SPARKLINE - graph in header */
	var orderValues = [10,8,5,7,4,4,3,8,0,7,10,6];

	$('.spark-orders').sparkline(orderValues, {
		type: 'bar', 
		barColor: '#ced9e2',
		height: 25,
		barWidth: 6
	}); 
    
    var revenuesValues = [8,3,2,6,4,9,1,10,8,2,5,8];

	$('.spark-revenues').sparkline(revenuesValues, {
		type: 'bar', 
		barColor: '#ced9e2',
		height: 25,
		barWidth: 9
	});
});
</script>