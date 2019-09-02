<section class="content">
  <div class="container-fluid">
    <div class="row clearfix">
      <form method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'user/addEdit' ?>" class="form-label-left">
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
              <div class="header">
                <h2>
                  <?php echo lang('profile_picture'); ?>
                </h2>
              </div>
              <div class="body align-center">
                <center>
                  <div class="pic_size" id="image-holder">
                  <?php
if (file_exists('assets/images/' . $user_data[0]->profile_pic) && isset($user_data[0]->profile_pic)) {
    $profile_pic = $user_data[0]->profile_pic;
} else {
    $profile_pic = 'user.png';}?>
                    <center> <img class="thumb-image setpropileam" src="<?php echo iaBase(); ?>/assets/images/<?php echo isset($profile_pic) ? $profile_pic : 'user.png'; ?>" alt="User profile picture"></center>
                  </div>
                </center>
                <br>
                <div class="fileUpload btn btn-primary btn-lg m-t-15 waves-effect">
                    <span><?php echo lang('change_picture'); ?></span>
                    <input id="fileUpload" class="upload" name="profile_pic" type="file" accept="image/*" /><br />
                    <input type="hidden" name="fileOld" value="<?php echo isset($user_data[0]->profile_pic) ? $user_data[0]->profile_pic : ''; ?>" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
              <div class="header">
                <h2>
                  <?php echo lang('profile'); ?>
                </h2>
              </div>
              <div class="body">
                <h5 class="m-b-20"><?php echo lang('personal_information'); ?></h5>

					<p><?php echo lang('status') ?></p>
					<div class="form-group form-float">
		              <div class="form-line">
		              	<select name="status" id="status" class="form-control" required>
      			        			<option value="active" <?php echo (isset($user_data[0]->status) && $user_data[0]->status == 'active' ? 'selected="selected"' : ''); ?> >Active</option>

      			        			<option value="deleted" <?php echo (isset($user_data[0]->status) && $user_data[0]->status == 'deleted' ? 'selected="selected"' : ''); ?> >Deleted</option>

		              	</select>
		              </div>
		            </div>



						<div class="form-group form-float">
							<div class="form-line">
				              <input type="text" id="name" name="name" value="<?php echo (isset($user_data[0]->name) ? $user_data[0]->name : ''); ?>" required class="form-control">
				              <label for="exampleInputname" class="form-label"><?php echo lang('name') ?>:</label>
							</div>
			            </div>



						<div class="form-group form-float">
							<div class="form-line">
				              <input type="text" id="email" name="email" value="<?php echo (isset($user_data[0]->email) ? $user_data[0]->email : ''); ?>" required class="form-control">
				              <label for="exampleInputemail" class="form-label"><?php echo lang('email') ?>:</label>
							</div>
			            </div>



                <h5 class="m-b-30"><?php echo lang('ChangePassword'); ?></h5>
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" class="form-control" name="currentpassword" id="pass11">
                        <label class="form-label"><?php echo lang('current_password'); ?></label>
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" class="form-control validate-equalTo-blur" name="password" id="password">
                        <label class="form-label"><?php echo lang('NewPassword'); ?></label>
                    </div>
                </div>

                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" class="form-control" id="confirm_password" name="confirmPassword"  onkeyup="return Validate()">
                        <label class="form-label"><?php echo lang('confirm_new_password'); ?></label>
                        <span id="divCheckPasswordMatch"></span>
                    </div>
                </div>

                <?php getCustomFields('user', isset($user_data[0]->ia_users_id) ? $user_data[0]->ia_users_id : null);?>


                <br>


                <div class="form-group form-float form-group-lg sub-btn-wdt" >
                    <input type="hidden" name="ia_users_id" value="<?php echo isset($user_data[0]->ia_users_id) ? $user_data[0]->ia_users_id : ''; ?>">
                    <input type="hidden" name="user_type" value="<?php echo isset($user_data[0]->user_type) ? $user_data[0]->user_type : ''; ?>">
                    <button  class="btn btn-primary btn-lg m-t-15 waves-effect" id="saveformbutton" type="submit"><?php echo lang('Save'); ?></button>
                </div>
              </div>
            </div>

          </div>
         <!-- /.box-body -->

      </form>
      <!-- /.box -->
    </div>
    <!-- /.content -->
  </div>
</section>
<!-- /.content-wrapper -->