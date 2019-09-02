<section class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="">
                <div class="header">
                    <h2 style="font-size: 19px;font-weight: 400;margin: 0 !important;padding-bottom: 28px;">
                        <?php echo lang("settings"); ?>
                    </h2>
                </div>
                <div class="body">
                  <div class="row">
              <div class="col-lg-12">
                <div class="tabbable">
                  <div class="left_content">
                    <ul id="myTab4" class="nav nav-tabs" style="background-color: #E5E9EC;">
                      <li class="active">
                        <a href="#general-setting" data-toggle="tab">
                          <i class="fa fa-cogs"></i>
                          <span style="color: #454545;"><?php echo lang("general"); ?></span>
                        </a>
                      </li>
                      <li>
                        <a href="#email-setting" data-toggle="tab">
                          <i class="fa fa-envelope-o" aria-hidden="true"></i>
                          <span style="color: #454545;"><?php echo lang("email"); ?></span>
                        </a>
                      </li>
                      <li id="permis">
                        <a href="#permission-setting" data-toggle="tab">
                          <i class="fa fa-indent" aria-hidden="true"></i>
                          <span style="color: #454545;"><?php echo lang("permission"); ?></span>
                        </a>
                      </li>
                      <li>
                        <a href="#registration-setting" data-toggle="tab">
                          <i class="fa fa-indent" aria-hidden="true"></i>
                          <span style="color: #454545;"><?php echo "Registration"; ?></span>
                        </a>
                      </li>
                      <li id="templates">
                        <a href="#templates-setting" data-toggle="tab">
                          <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                          <span style="color: #454545;"><?php echo 'Email '.lang('templates'); ?></span>
                        </a>
                      </li>
                      <li>
                        <a href="#custom-fields-setting" data-toggle="tab">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                          <span style="color: #454545;"><?php echo lang('custom_fields'); ?></span>
                        </a>
                      </li>
                      <li id="system_update">
                        <a href="#system-update-setting" data-toggle="tab">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                          <span style="color: #454545;"><?php echo lang('system_update'); ?></span>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="right_content">
                    <div class="tab-content">
                      <div class="tab-pane fade in" id="system-update-setting">

                      </div>
                      <div class="tab-pane fade in" id="templates-setting">



                        <?php $this->load->view('templates/index');?>
                       <?php //echo CI_VERSION; ?><br>
                       <?php //echo phpinfo();?>

                      </div>
                      <div class="tab-pane fade in" id="custom-fields-setting">
                        <?php $this->load->view('setting/cf_view');?>
                      </div>
                      <div class="tab-pane fade active in" id="general-setting">
                        <?php $this->load->view('setting/general_view');?>
                      </div>
                      <div class="tab-pane fade in" id="registration-setting">
                        <?php $this->load->view('setting/registration_setting');?>
                      </div>
                      <div class="tab-pane fade" id="email-setting">
                        <?php $this->load->view('setting/email_view');?>
                      </div>
                      <div class="tab-pane " id="permission-setting">
                        <?php $this->load->view('setting/permissions_view');?>
                      </div>
                            <!-- /.panel -->
                          </div>
                  </div>
                      </div>
                    </div>
            </div>
                </div>
              </div>
          </div>
      </div>


      <!-- /.content-wrapper -->
<script type="text/javascript">
$('document').ready(function(){

	$('input[type="radio"]').click(function(){
       if($(this).attr('id') == 'simple_mail') {$('#simplemail').show();$('#phpmailer').hide();}else{$('#phpmailer').show();$('#simplemail').hide();}
   });
	if('simple_mail'=='<?php echo isset($result['mail_setting']) ? $result['mail_setting'] : ''; ?>'){$('#phpmailer').hide();}else{$('#simplemail').hide();}
});
(function ($) {
    $.toggleShowPassword = function (options) {
        var settings = $.extend({ field: "#password", control: "#toggle_show_password",}, options);
        var control = $(settings.control);
        var field = $(settings.field);
        control.bind('click',function(){if(control.is(':checked')){ field.attr('type', 'text');}else{ field.attr('type', 'password');} })
    };
}(jQuery));
$.toggleShowPassword({  field: '#test1', control: '#test2'});
</script>
<script>
$(document).ready(function() {
  $('#rolesAdd').prop('disabled', true);
     $('#roles').keyup(function() {
        if($(this).val() != '') {
          $('#rolesAdd').prop('disabled', false);
        }
        else{
          $('#rolesAdd').prop('disabled', true);
        }
  });
	$('#addmoreRolesShow').hide();
    $('#addmoreRoles').on('click', function(){
       $('#addmoreRolesShow').slideToggle();
    });
  $('#rolesAdd').on('click',function(event){
    var roles = $('#roles').val();
    if(roles != ''){
      var url_page = '<?php echo base_url() . 'setting/addUserType'; ?>';
      event.preventDefault();
      $.ajax({
          type: "POST",
          url: url_page,
          data:{ action: 'ADDACTION',rolesName:roles},
          success: function (data) {
        if(data=='<?php echo lang("this_user_type") ?> ('+ roles +') <?php echo lang("is_already_exist_in_this_project_please_enter_another_name"); ?>'){$("#showRolesMSG").html(data);}
        else{
          $('#addmoreRolesShow').hide();
            location.reload();
          }
        }
      });
    } else {
      $('#roles').focus();
    }
  });

  // Javascript to enable link to tab
  var url = document.location.toString();
  if (url.match('#')) {
      var tag = url.split('#')[1];
      if(tag == 'templates-setting'){
        $('#templates').click();
      }
      $('.nav-tabs a[href="#' + tag + '"]').tab('show');
  }

  // Change hash for page-reload
  $('.nav-tabs a').on('shown.bs.tab', function (e) {
      window.location.hash = e.target.hash;
      $(window).scrollTop(0);
  });

  if($('li#system_update').hasClass('active')) {
    setTimeout(function() {
      $('li#system_update').trigger('click');
    }, 500);
  }

})
</script>
<!-- /page content -->