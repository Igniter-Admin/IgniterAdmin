<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url() . 'user/addEdit' ?>" method="post">
  <div class="box-body">
    <div class="row">

						<!-- <div class="col-md-6">
				          <div class="form-group form-float">
				            <div class="form-line">
				            	<select name="status" id="" class="form-control" required >
        			        			<option value="active" <?php //echo (isset($userData->status) && $userData->status == 'active') ? 'selected' : ''; ?> >Active</option>

        			        			<option value="deleted" <?php //echo (isset($userData->status) && $userData->status == 'deleted') ? 'selected' : ''; ?> >Deleted</option>

				            	</select>
				            	<label class="form-label" for="status"> <?php //echo lang('status') ?></label>
				            </div>
				          </div> 
				        </div>-->

						<div class="col-md-6">
						  <div class="form-group form-float">
						  	<div class="form-line">
							    <input type="text" name="name" value="<?php echo isset($userData->name) ? $userData->name : ''; ?>" required class="form-control">
							    <label class="form-label"><?php echo lang('name') ?></label>
						    </div>
						  </div>
						</div>

						<div class="col-md-6">
						  <div class="form-group form-float">
						  	<div class="form-line">
							    <input type="text" name="email" value="<?php echo isset($userData->email) ? $userData->email : ''; ?>" required class="form-control">
							    <label class="form-label"><?php echo lang('email') ?></label>
						    </div>
						  </div>
						</div>

          <div class="col-md-6">
          <div class="form-group form-float">
            <?php $u_type = isset($userData->user_type) ? $userData->user_type : '';
$user_type = getAllDataByTable('ia_permission');
?>
            <div class="form-line">
              <select name="user_type" class="form-control" required>
              <?php foreach ($user_type as $option) {
    $sel = '';if (strtolower($option->user_type) == strtolower($u_type)) {$sel = "selected";}
    if (strtolower($option->user_type) != 'admin') {
        ?>
                <option  value="<?php echo $option->user_type; ?>" <?php echo $sel; ?> ><?php echo ucfirst($option->user_type); ?> </option>
                <label for="" class="form-label"><?php echo lang('user_type'); ?></label>

              <?php }}?>
              </select>
            </div>
          </div>
        </div>
        <?php if (isset($userData)) {?>
        <div class="col-md-12">
          <div class="form-group form-float">
            <div class="form-line">
              <input type="text" style="display: none">
              <input type="Password" name="currentpassword" class="form-control" value="">
              <label for="" class="form-label"><?php echo lang('current_password'); ?></label>
            </div>
          </div>
        </div>
        <?php } else {?>
        <div class="col-md-12">
          <div class="form-group form-float">
            <div class="form-line">
              <input type="text" style="display: none">
              <input type="Password" name="password" class="form-control" value="" required>
              <label for="" class="form-label"><?php echo lang('Password'); ?></label>
            </div>
          </div>
        </div>
        <?php }if (isset($userData)) {?>
          <div class="col-md-6">
            <div class="form-group form-float">
              <div class="form-line">
                <input type="Password" name="password" class="form-control" value="">
                <label for="" class="form-label"><?php echo lang('NewPassword'); ?></label>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group form-float">
              <div class="form-line">
                <input type="Password" name="confirmPassword" class="form-control" value="">
                <label for="" class="form-label"><?php echo lang('ConfirmPassword'); ?></label>
              </div>
            </div>
          </div>
          <?php }?>

          <div class="col-md-12">
            <div class="form-group imsize">
              <label for="exampleInputFile"><?php echo lang('image_upload'); ?></label>
              <div class="pic_size" id="image-holder">
                <?php if (isset($userData->profile_pic) && file_exists('assets/images/' . $userData->profile_pic)) {
    $profile_pic = $userData->profile_pic;
} else {
    $profile_pic = 'user.png';
}?>
                <left> <img class="thumb-image setpropileam" src="<?php echo iaBase(); ?>/assets/images/<?php echo isset($profile_pic) ? $profile_pic : 'user.png'; ?>" alt="User profile picture"></left>
              </div> <input type="file" name="profile_pic" id="exampleInputFile">
            </div>
          </div>
        </div>
        <?php getCustomFields('user', isset($userData->ia_users_id) ? $userData->ia_users_id : null);?>
        <?php if (!empty($userData->ia_users_id)) {?>
        <input type="hidden"  name="ia_users_id" value="<?php echo isset($userData->ia_users_id) ? $userData->ia_users_id : ''; ?>">
        <input type="hidden" name="fileOld" value="<?php echo isset($userData->profile_pic) ? $userData->profile_pic : ''; ?>">
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="edit" value="edit" class="btn btn-primary wdt-bg"><?php echo lang('Update'); ?></button>
        </div>
              <!-- /.box-body -->
        <?php } else {?>
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="add" class="btn btn-primary wdt-bg"><?php echo lang('Add'); ?></button>
        </div>
        <?php }?>
      </form>
<script>
  $.AdminBSB.input.activate();
</script>