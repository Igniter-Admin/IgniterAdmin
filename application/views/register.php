<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <title>Sign In | Igniter Admin</title>
      <!-- Favicon-->
      <link rel="icon" href="<?php echo iaBase(); ?>assets/images/logo_clr.png" type="image/x-icon">

      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

      <!-- Bootstrap Core Css -->
      <link href="<?php echo iaBase(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

      <!-- Waves Effect Css -->
      <link href="<?php echo iaBase(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

      <!-- Animation Css -->
      <link href="<?php echo iaBase(); ?>assets/plugins/animate-css/animate.min.css" rel="stylesheet" />

      <!-- Custom Css -->
      <link href="<?php echo iaBase(); ?>assets/css/style.css" rel="stylesheet">
  </head>
<?php
$this->load->helper('cookie');
$cookie = get_cookie('theme_color');
if ((!isset($cookie)) || (isset($cookie) && empty($cookie))) {$cookie = 'theme-blue';}
?>
  <body class="hold-transition signup-page <?php echo $cookie; ?>1" style="background-color: <?php
               if($cookie == 'theme-blue') {
                echo '#2196F3';
               } elseif($cookie == 'theme-red') {
                echo '#F44336';
               } elseif($cookie == 'theme-pink') {
                echo '#E91E63';
               } elseif($cookie == 'theme-purple') {
                echo '#9C27B0';
               } elseif($cookie == 'theme-deep-purple') {
                echo '#673AB7';
               } elseif($cookie == 'theme-indigo') {
                echo '#3F51B5';
               } elseif($cookie == 'theme-light-blue') {
                echo '#03A9F4';
               } elseif($cookie == 'theme-cyan') {
                echo '#00BCD4';
               } elseif($cookie == 'theme-teal') {
                echo '#009688';
               } elseif($cookie == 'theme-green') {
                echo '#4CAF50';
               } elseif($cookie == 'theme-light-green') {
                echo '#8BC34A';
               } elseif($cookie == 'theme-lime') {
                echo '#CDDC39';
               } elseif($cookie == 'theme-yellow') {
                echo '#FFEB3B';
               } elseif($cookie == 'theme-amber') {
                echo '#FFC107';
               } elseif($cookie == 'theme-orange') {
                echo '#FF9800';
               } elseif($cookie == 'theme-deep-orange') {
                echo '#FF5722';
               } elseif($cookie == 'theme-brown') {
                echo '#795548';
               } elseif ($cookie == 'theme-grey') {
                echo "#9E9E9E";
               } elseif ($cookie == 'theme-blue-grey') {
                echo "#607D8B";
               } else {
                echo "#000";
               }
              ?>">
    <div class="signup-box">
      <div class="logo ia-front-logo">
<?php
$logo = getSetting('logo');
if ($logo != '') {
    ?>
        <img src="<?php echo iaBase() . 'assets/images/' . $logo; ?>" id="logo">
<?php } else {?>
        <h2>
          <strong>  <?php echo getSetting('website'); ?> </strong>
        </h2>
<?php }?>
      </div>
      <div class="card">
        <div class="body">
          <div class="msg"><h3><?php echo lang('sign_up');?></h3></div>
          <form action="<?php echo base_url() . 'user/registration'; ?>" method="post" id="register-form">

			        <div class="input-group">
              			<span class="input-group-addon">
                			<i class="material-icons">person</i>
              			</span>
              			<div class="form-line">
                			<input type="text" name="name" class="form-control" required  placeholder="Name">
              			</div>
            		</div>

			        <div class="input-group">
              			<span class="input-group-addon">
                			<i class="material-icons">email</i>
              			</span>
              			<div class="form-line">
                			<input type="text" name="email" class="form-control" required  placeholder="Email">
              			</div>
            		</div>


            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">lock</i>
              </span>
              <div class="form-line">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" data-validation="required">
              </div>
            </div>

            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">lock</i>
              </span>
              <div class="form-line">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" data-validation="confirmation">
              </div>
            </div>

            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">shuffle</i>
              </span>
              <div class="form-line">
                <?php $type = $this->db->get('ia_permission')->result(); 
                // print_r($type);die(); ?>
                <select name="user_type" id="" class="form-control">
                  <option value=""><?php echo lang('select_type') ?></option>
                  <?php
foreach ($type as $value) {
    if ($value->user_type != 'admin') {
        echo '<option value="' . $value->user_type . '">' . ucfirst($value->user_type) . '</option>';
    }
}
?>
                </select>
              </div>
            </div>

            <?php getCustomFields('user');?>

            <div class="row">
              <div class="col-xs-12">
                  <input type="hidden" name="call_from" value="reg_page">
                  <button type="submit" name="submit" style="width: 100%" class="btn btn-primary btn-lg bg-grey waves-effect"><?php echo lang('register'); ?></button>
                </div>
              </div>
          </form>
          <br>
          <a href="<?php echo base_url('login'); ?>" class="text-center"><?php echo lang('already_hav_an_account?_Login'); ?></a>
        </div>
      </div>
      <!-- /.form-box -->
    </div>
    <!-- Jquery Core Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo iaBase(); ?>assets/js/admin.js"></script>
    <script src="<?php echo iaBase(); ?>assets/js/pages/examples/sign-in.js"></script>
  </body>
<script>
$(document).ready(function(){
  <?php if ($this->input->get('invited') && $this->input->get('invited') != '') {?>
    $burl = '<?php echo base_url() ?>';
    $.ajax({
      url: $burl+'user/chekInvitation',
      method:'post',
      data:{
        code: '<?php echo $this->input->get('invited'); ?>'
      },
      dataType: 'json'
    }).done(function(data){
      console.log(data);
      if(data.result == 'success') {
        $('[name="email"]').val(data.email);
        $('form').attr('action', $burl + 'user/registerInvited/' + data.ia_users_id);
      } else{
        window.location.href= $burl + 'user/login';
      }
    });
  <?php }?>

  $('#register-form').validate({

    rules: {
        password: {
            required: true,
        },
        password_confirmation: {
            required: true,
            equalTo: "#password"
        }
    }
  });
});
</script>
</html>
