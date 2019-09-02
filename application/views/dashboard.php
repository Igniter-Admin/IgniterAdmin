<!-- Content Wrapper. Contains page content -->
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
      		<h2 style="font-size: 18px;"><?php echo lang('dashboard'); ?></h2>
    	</div>
	  		<div class="row clearfix">
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=8945  data-deshbid_type=info_box style="background-color: #23d0ce !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-user"></span>
				            </div>
			            	<div class="content">
			            		<div class="text"><?php echo lang('total_users'); ?></div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($Total_Users_data[0]->ia) ? number_format($Total_Users_data[0]->ia) : '0'; ?></div>
			            	</div>
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div>
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=8946  data-deshbid_type=info_box style="background-color: #53a0ff !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-plus-sign"></span>
				            </div>
			            	<div class="content">
			            		<div class="text"><?php echo lang('registered_today'); ?></div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($Today_Registered_data[0]->ia) ? number_format($Today_Registered_data[0]->ia) : '0'; ?></div>
			            	</div>
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div>
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=8947  data-deshbid_type=info_box style="background-color: #8097ea !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-briefcase"></span>
				            </div>
			            	<div class="content">
			            		<div class="text"><?php echo lang('active_users') ?></div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($Active_Users_data[0]->ia) ? number_format($Active_Users_data[0]->ia) : '0'; ?></div>
			            	</div>
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div></div><div class="row  clearfix">
			        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <!-- BAR CHART -->
     <div class="card mka-das-table EditDeshbord" data-deshbid_type="bar_chart" data-deshbid_id="8949" style="display: none;">
      <div class="header">
        <h2><?php echo lang('monthly_registration'); ?></h2>
      </div>
      <div class="body">
        <div class="chart">
          <!-- <canvas class="bar_chart" style="height:230px"></canvas> -->
          <div class="tab-pane fade in" id="system-update-setting"></div>
        </div>
      </div>
    </div> 
</div>


<script>
  	$(function () {
	    for (var i = 0; i < $('.bar_chart').length; i++) {
	      new Chart(document.getElementsByClassName("bar_chart")[i].getContext("2d"), getChartJs('bar'));
	    }
	});

  function getChartJs(type) {
    var config = {
            type: 'bar',
            data: {
                labels: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
                datasets: [
							{
								label : "Bar 1",
								data : [<?php echo $Bar_1 ?>],
								backgroundColor : '#039ae4'
							},
							]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    return config;
  }
</script></div></div>
</section>
