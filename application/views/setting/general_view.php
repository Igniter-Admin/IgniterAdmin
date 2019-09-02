
<form method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'setting/editSetting' ?>" data-parsley-validate class="form-horizontal form-label-left demo-form2">


    <div class="card clearfix" style="margin-top: -50px;">
        <div class="header">
          <h5 class="box-title" style="margin: 0;font-size: 18px;font-weight: normal;color: #111111c7;"><?php echo lang('generalSetting'); ?> </h5>
        </div>


        <div class="col-md-12 m-t-20">
          <div class="col-md-12">
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" id="" class="form-control" name="website" required="" value="<?php echo isset($result['website']) ? $result['website'] : ''; ?>">
                    <label class="form-label"><?php echo lang("title"); ?> *</label>
                </div>
            </div>
          </div>
        </div>

          <div class="col-md-12 m-b-20">
            <div class="col-md-12">
              <div class="form-group">
                <span for="exampleInputFile" class="l-color"><?php echo lang('logo'); ?> </span>
              </div>
              <div class="form-group pic_size col-sm-4 col-xs-4 text-center m-t-10" id="logo-holder">


                <?php (isset($result['logo']) && $result['logo'] != '' ? $logo_src = iaBase() . 'assets/images/' . $result['logo'] : $logo_src = iaBase() . 'assets/images/logo.png');?>

                  <img class="thumb-image logo setpropileam ia-sel-image" title="Click to change logo" src="<?php echo $logo_src; ?>"  alt="logoSite">

              </div>
              <button class="btn btn-xs btn-warning rm-logo-img" type="button"><i class="material-icons">close</i></button>
              <div class="blind">
                <input type="file" class="upload" name="logo" id="logoSite" value="" accept="image/*">
                <input type="hidden" name="fileOldlogo" value="<?php echo isset($result['logo']) ? $result['logo'] : ""; ?>">
              </div>
            </div>
          </div>

    <div class="row">
      <div class="col-md-12 ">
          <div class="sub-btn-wdt col-md-4 col-md-offset-4 m-t-5">
            <input type="submit" value="<?php echo lang('save'); ?>" style="width: 100%" class="btn btn-primary btn-lg waves-effect">
          </div>
        </div>
      </div>
    </div>


</form>
