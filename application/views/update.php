<div class="row">
<div class="card clearfix">
  <div class="header my-header">
     <h5><?php echo lang('updateIgniterAdmin'); ?> </h5>
  </div>
<div class="col-md-12">

<?php
if ($latest_version > $current_version) {?>
      <div class="col-md-6 text-center">
        <div class="alert alert-<?php if ($latest_version > $current_version) {echo 'danger';} else {echo 'info';}?>">
           <h4 class="bold"><?php echo lang('your_version'); ?></h4>
           <p class="font-medium bold"><?php echo wordwrap($current_version, 1, '.', true); ?></p>
        </div>
     </div>
     <div class="col-md-6 text-center">
        <div class="alert alert-<?php if ($latest_version > $current_version) {echo 'success';} else if ($latest_version == $current_version) {echo 'info';}?>">
           <h4 class="bold"><?php echo lang('latest_version'); ?></h4>
           <p class="font-medium bold"><?php echo wordwrap($latest_version, 1, '.', true); ?></p>
           <?php echo form_hidden('latest_version', $latest_version); ?>
           <?php echo form_hidden('download_url', $download_url); ?>
        </div>
     </div>
    <?php } else if ($latest_version == $current_version) {?>
      <div class="col-md-12 text-center">
        <div class="alert alert-<?php if ($latest_version > $current_version) {echo 'danger';} else {echo 'info';}?>">
           <h4 class="bold"><?php echo lang('your_version'); ?></h4>
           <p class="font-medium bold"><?php echo wordwrap($current_version, 1, '.', true); ?></p>
        </div>
        <span> <?php echo lang('no_update_available'); ?> </span>

     </div>

    <?php }
?>



     <!--  -->
     <div class="clearfix"></div>
     <hr />
     <div class="col-md-12 text-center">
        <?php if ($current_version != $latest_version && $latest_version > $current_version) {?>
        <div class="alert alert-warning">
           <?php echo lang('ia_upgrade_message'); ?>
        </div>
        <h3 class="bold text-center mbot20"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <!--i class="material-icons">exclamation_applications</i--><?php echo lang('update_available'); ?></h3>
        <div class="update_app_wrapper" data-wait-text="<?php echo lang('wait_text'); ?>" data-original-text="<?php echo lang('update_now'); ?>">
           <?php if (count($update_errors) == 0) {?>
           <a href="#" id="update_app" class="btn btn-success"><?php echo lang('update_now'); ?></a>
           <?php }?>
        </div>
        <div id="update_messages" class="mtop25 text-left">
        </div>
        <?php }?>

        <?php if (count($update_errors) > 0) {?>
        <p class="text-danger"><?php echo lang('please_fix_the_errors_listed_below'); ?>.</p>
        <?php foreach ($update_errors as $error) {?>
        <div class="alert alert-danger">
           <?php echo $error; ?>
        </div>
        <?php }?>
        <?php }?>
       <p class="text-info bold font-medium clearfix">
        <?php if (isset($update_info->additional_data)) {
    echo $update_info->additional_data;
}?>
       </p>
     </div>
</div>
</div>
</div>



<script type="text/javascript">
      $(function(){
     $('#update_app').on('click',function(e){
       e.preventDefault();
       var latest_version = $('input[name="latest_version"]').val();
       var download_url = $('input[name="download_url"]').val();
       var update_errors;
         var ubtn = $(this);
         var url = '<?php echo base_url(); ?>';
         ubtn.html('<?php echo lang('wait_text'); ?>');
         ubtn.addClass('disabled');
         $.post(url+'auto_update',{latest_version:latest_version,download_url:download_url,auto_update:true}).done(function(){
           $.post(url+'auto_update/database',{latest_version:latest_version,auto_update:true}).done(function(){
             window.location.reload();
           }).fail(function(){
             update_errors = JSON.parse(response.responseText);
             $('#update_messages .alert').append(update_errors[0]);
           });
         }).fail(function(response){
           update_errors = JSON.parse(response.responseText);
           $('#update_messages').html('<div class="alert alert-danger"></div>');
           for (var i in update_errors){
             $('#update_messages .alert').append('<p>'+update_errors[i]+'</p>');
           }
           ubtn.removeClass('disabled');
           ubtn.html($('.update_app_wrapper').data('original-text'));
         });

     });


   });

</script>