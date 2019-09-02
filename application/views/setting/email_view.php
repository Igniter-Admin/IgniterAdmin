<div class="card clearfix" style="margin-top: -50px;">
  <div class="header">
    <h5 style="margin: 0;font-size: 18px;font-weight: normal;color: #111111c7;"><?php echo lang('emailServerSetting'); ?> </h5>
  </div>
  <form method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'setting/editMailSetting' ?>" data-parsley-validate class="form-horizontal form-label-left demo-form2">
    <div class="col-md-12">
      <div class="col-md-12">

        <div class="form-group form-float m-t-20">
            <input type="radio" id="php_mailer" name="mail_setting" value="php_mailer" <?php if (isset($result['mail_setting']) && $result['mail_setting'] == 'php_mailer') {echo "checked";}?> >
            <label for="php_mailer" class="thfont"> <?php echo lang('smtp'); ?> </label>
            <input type="radio" id="simple_mail" name="mail_setting" value="simple_mail"  <?php if (isset($result['mail_setting']) && $result['mail_setting'] == 'simple_mail') {echo "checked";}?>>
            <label for="simple_mail" class="thfont"> <?php echo lang('server_default'); ?> </label>
        </div>

        <div class="form-group form-float m-t-20">
            <div class="form-line">
              <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo isset($result['company_name']) ? $result['company_name'] : ''; ?>">
              <label class="form-label" for=""><?php echo lang('company_name'); ?></label>
            </div>
        </div>
        <div id="phpmailer" style="display:<?php if (isset($result['mail_setting']) && $result['mail_setting'] == 'php_mailer') {echo "block";} else {echo 'none';}?>;" >

          <div class="form-group form-float m-t-20">
            <div class="form-line">
              <input type="email" class="form-control" name="SMTP_EMAIL" id="SMTP_EMAIL" value="<?php echo isset($result['SMTP_EMAIL']) ? $result['SMTP_EMAIL'] : ''; ?>">
              <label class="form-label" for="SMTP_EMAIL"><?php echo lang('smtp_email'); ?>:</label>
            </div>
          </div>

          <div class="form-group form-float m-t-20">
              <div class="form-line">
                <input type="text" class="form-control" name="HOST" id="HOST" value="<?php echo isset($result['HOST']) ? $result['HOST'] : ''; ?>">
                <label class="form-label" for="HOST"><?php echo lang('smtp_host'); ?>:</label>
              </div>
          </div>

          <div class="form-group form-float m-t-20">
            <div class="form-line">
              <input type="text" class="form-control" name="PORT" id="PORT" value="<?php echo isset($result['PORT']) ? $result['PORT'] : ''; ?>">
              <label class="form-label" for="PORT"><?php echo lang('smtp_port') ?>:</label>
            </div>
          </div>

          <div class="form-group form-float m-t-20">
            <div class="form-line">
              <input type="text" class="form-control" name="SMTP_SECURE" id="SMTP_SECURE" value="<?php echo isset($result['SMTP_SECURE']) ? $result['SMTP_SECURE'] : ''; ?>">
              <label class="form-label" for="SMTP_SECURE"><?php echo lang('smtp_secure'); ?>:</label>
            </div>
          </div>

          <div class="form-group form-float m-t-20 ">
              <div class="form-line">
                <input type="text" style="display: none;">
                <input type="password" class="form-control showpassword" name="SMTP_PASSWORD" id="test1" value="<?php echo isset($result['SMTP_PASSWORD']) ? $result['SMTP_PASSWORD'] : ''; ?>">
                <label class="form-label" for="SMTP_PASSWORD"><?php echo lang('smtp_password'); ?>:</label>
              </div>
          </div>
        </div>
        <div id="simplemail"  style="display:<?php if (isset($result['mail_setting']) && $result['mail_setting'] == 'simple_mail') {echo "block";} else {echo 'none';}?>;">

          <div class="form-group form-float m-t-20">
            <div class="form-line">
              <input type="email" class="form-control" name="EMAIL" id="EMAIL" value="<?php echo isset($result['EMAIL']) ? $result['EMAIL'] : ''; ?>">
              <label class="form-label" for="EMAIL"><?php echo lang('email'); ?>:</label>
            </div>
          </div>

        </div>
        <div class="row m-t-20">
          <div class="col-md-4 col-md-offset-4">
            <div class="form-group sub-btn-wdt">
              <input name="register_allowed" type="hidden" value="<?php if (isset($result['register_allowed']) && $result['register_allowed'] == 1) {echo '1';} else {echo '0';}?>" >
              <input style="width: 100%" type="submit" value="Save" class="btn btn-primary waves-effect">
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>