<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <title>Login - Title of website</title>
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

		<!-- All theme css -->
	    <link href="<?php echo iaBase(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />
	    <style>
	    	.logo b {
			    color: #555;
			}
	    </style>
	</head>
<?php
$this->load->helper('cookie');
$cookie = get_cookie('theme_color');
if ((!isset($cookie)) || (isset($cookie) && empty($cookie))) {$cookie = 'theme-blue';}
?>
	<body class="hold-transition login-page <?php echo $cookie; ?>1" style="background-color: <?php
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
		<div class="login-box">
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
	                <form action="<?php echo base_url() . 'user/authUser'; ?>" method="post" id="login-form">
	                    <div class="msg"><h2><?php echo lang('login'); ?></h2></div>
	                    <div class="input-group">
	                        <span class="input-group-addon">
	                            <i class="material-icons">person</i>
	                        </span>
	                        <div class="form-line">
	                        	<input type="text" name="email" class="form-control" id="" placeholder="<?php echo lang('email'); ?>" required value="" autofocus>
	                        </div>
	                    </div>
	                    <div class="input-group">
	                        <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                        </span>
	                        <div class="form-line">
	                            <input type="password" name="password" class="form-control" id="pwd" placeholder="<?php echo lang('password'); ?>" value="" required>
	                        </div>
	                    </div>
	                    <div class="row">
                            <div class="col-md-12">
                            	<button style="width: 100%" class="btn btn-primary bg-grey waves-effect" type="submit"><?php echo lang('SIGN_IN'); ?></button>
                            </div>
	                    </div>
	                    <div class="row m-t-15 m-b--20">
	                    	<?php if (getSetting('register_allowed') == 1) {?>
		                        <div class="col-xs-6">
		                            <a href="<?php echo base_url() . 'signup'; ?>"><?php echo lang('sing_up') ?>!</a>
		                        </div>
	                        <?php }?>
	                        <div class="col-xs-6 align-right">
	                            <a href="<?php echo base_url() . 'forgot_password' ?>"><?php echo lang('forgot_password') ?>?</a>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
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
	    <script src="<?php echo iaBase(); ?>assets/js/custom.js"></script>
	    <script src="<?php echo iaBase() ?>assets/plugins/bootstrap-notify/bootstrap-notify.js"></script>
	</body>

	<script>
        $(document).ready(function() {
            /**
             * $type may be success, danger, warning, info
             */
            <?php
if (isset($this->session->get_userdata()['alert_msg'])) {
    ?>
                $msg = '<?php echo $this->session->get_userdata()['alert_msg']['msg']; ?>';
                $type = '<?php echo $this->session->get_userdata()['alert_msg']['type']; ?>';
                showNotification($msg, $type);
            <?php
$this->session->unset_userdata('alert_msg');
}
?>

            $('#login-form').validate();
        });

    </script>

</html>

