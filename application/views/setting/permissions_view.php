<div class="row card" style="margin-top: -50px;">
  <div class="header">
  <h5 style="margin: 0;font-size: 18px;font-weight: normal;color: #111111c7;"><?php echo lang('permissionSetting'); ?></h5>
  </div>
  <div class="col-md-12">
    <div class="col-md-4">
      <div class="box-header my-header">
        <h5 class="box-title">
          <p style="font-size: 20px;font-weight: 400;"><?php echo "Roles"; ?>
          <span class="pull-right" style="margin:-3px;">
             <button class="btn ad-u-type-btn" type="button" title="<?php echo lang('add_new'); ?>" style="border: 1px solid #a5a4a4;background-color: white;border-radius: 2px;"><i class="material-icons">add_circle</i>Add role</button>
          </span>
          </p>
        </h5>
        <hr>
      </div>
      <form method="post" action="<?php echo base_url(); ?>setting/updateRole">


      <div class="form-group form-float m-t-30 ia_user_role_div">
        <?php
$permissiona = getAllDataByTable('ia_permission');
krsort($permissiona);
$i = 0;
foreach ($permissiona as $perkey => $value) {
    $user_type = isset($value->user_type) ? $value->user_type : '';
    if ($user_type != 'admin') {
        ?>
        <div class="row" style="margin-left: 0px;">

          <div class="col-md-7 ia-sel-role <?php if ($i <= 0) {echo "active";}?>" rel="<?php echo str_replace(' ', '-', $user_type); ?>">
            <span class="role-span"><?php echo ucfirst($user_type); ?></span>
            <div class="form-line blind">
              <input type="text" class="form-control inp-field" data-old-id="<?php echo $value->id; ?>" name="user_type_name[<?php echo $value->id; ?>]" value="<?php echo $user_type; ?>">
            </div>
          </div>
          <div class="col-md-5">
            <button class="btn ia-edit-btn btn-xs" type="button" data-toggle="tooltip" title="<?php echo lang('edit'); ?>" style="border: 1px solid #a5a4a4;background-color: white;border-radius: 2px;"><i class="material-icons">edit</i></button>
            <button class="btn rm-u-type-btn btn-xs" type="button" data-toggle="tooltip" title="<?php echo lang('remove'); ?>" style="border: 1px solid #a5a4a4;background-color: white;border-radius: 2px;"><i class="material-icons">remove_circle</i></button>
          </div>
          <br>
          <hr>
        </div>
        
    <?php
$i++;}}
?>
        <button class="btn btn-primary" style=""><?php echo lang('save_role'); ?></button>
      </div>
    </form>
    </div>
    <div class="col-md-8">
      <div class="box-header my-header">
    <h5 class="box-title" style="font-size: 20px;font-weight: 400;"><?php echo lang('permissionSetting'); ?> </h5>
    <hr>
    </div>
    <form class="form-horizontal" action="<?php echo base_url() . 'setting/permission' ?>" method="post">
    <?php
$permission = getAllDataByTable('ia_permission');
krsort($permission);
$setPermission = array();
$own_create = '';
$own_read = '';
$own_update = '';
$own_delete = '';
$all_create = '';
$all_read = '';
$all_update = '';
$all_delete = '';
$i = 0;
$permission = isset($permission) && is_array($permission) && !empty($permission) ? $permission : array();
if (isset($permission[1])) {
    foreach ($permission as $perkey => $value) {
        $id = isset($value->id) ? $value->id : '';
        $user_type = isset($value->user_type) ? $value->user_type : '';
        $data = isset($value->data) ? json_decode($value->data) : '';
        if ($user_type == 'admin') {} else {
            ?>
      <div class="panel panel-default ia-permisssion-div ia-permission-<?php echo str_replace(' ', '-', $user_type);if ($i > 0) {echo " blind";} ?> ">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $id; ?>"><i class="fa fa-bars"></i> <?php echo lang('permissions_for') . ': ' . ucfirst($user_type); ?></a></h4>
        </div>
    <?php /*if ($i == 0) {echo "in";}*/?>
        <div id="collapse_<?php echo $id; ?>" class="panel-collapse collapse in">
          <div class="panel-body table-responsive">
            <table class="table table-bordered dt-responsive rolesPermissionTable">
              <thead>
                <tr class="showRolesPermission">
                  <th scope="col"><?php echo lang('modules'); ?></th>
                  <th scope="col"><?php echo lang('create'); ?></th>
                  <th scope="col"><?php echo lang('read'); ?></th>
                  <th scope="col"><?php echo lang('update'); ?></th>
                  <th scope="col"><?php echo lang('delete'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
if (isset($data) && !empty($data)) {
                foreach ($data as $perkey => $valueR) {
                    $perkey = isset($perkey) ? $perkey : '';
                    $valueR = isset($valueR) ? $valueR : '';
                    if (isset($valueR)) {
                        $setPermissionCheck = $valueR;
                        $own_create = isset($setPermissionCheck->own_create) ? $setPermissionCheck->own_create : '';
                        $own_read = isset($setPermissionCheck->own_read) ? $setPermissionCheck->own_read : '';
                        $own_update = isset($setPermissionCheck->own_update) ? $setPermissionCheck->own_update : '';
                        $own_delete = isset($setPermissionCheck->own_delete) ? $setPermissionCheck->own_delete : '';
                        $all_create = isset($setPermissionCheck->all_create) ? $setPermissionCheck->all_create : '';
                        $all_read = isset($setPermissionCheck->all_read) ? $setPermissionCheck->all_read : '';
                        $all_update = isset($setPermissionCheck->all_update) ? $setPermissionCheck->all_update : '';
                        $all_delete = isset($setPermissionCheck->all_delete) ? $setPermissionCheck->all_delete : '';
                    } else {
                        $setPermissionCheck = array();
                        $own_create = '';
                        $own_read = '';
                        $own_update = '';
                        $own_delete = '';
                        $all_create = '';
                        $all_read = '';
                        $all_update = '';
                        $all_delete = '';
                    }
                    ?>
                    <tr>
                      <th scope="col" colspan="5" class="showRolesPermission text-center"><?php echo ucfirst(str_replace('_', ' ', $perkey)); ?>
                        <?php

                    $user_type = str_replace(' ', '_SPACE_', $user_type);
                    ?>
                        <input type="hidden" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>]" value="<?php echo $perkey; ?>" />
                      </th>
                    </tr>
                    <tr>
                      <th scope="row" class="thfont"><?php echo lang('own_entries'); ?><input type="checkbox" class="pull-right sell_all"></th>
                      <td><input type="checkbox" class="chk_create" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>][own_create]" value="1" <?php if ($own_create == 1) {echo "checked";}?>/></td>
                      <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>][own_read]"  value="1" <?php if ($own_read == 1) {echo "checked";}?>/></td>
                      <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>][own_update]"  value="1" <?php if ($own_update == 1) {echo "checked";}?>/></td>
                      <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>][own_delete]" value="1" <?php if ($own_delete == 1) {echo "checked";}?>/></td>
                    </tr>
                    <tr>
                      <th scope="row" class="thfont"><?php echo lang('all_entries'); ?><input type="checkbox" class="pull-right sell_all"></th>
                      <td>-</td>
                      <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>][all_read]"  value="1" <?php if ($all_read == 1) {echo "checked";}?>/></td>
                      <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>][all_update]"  value="1" <?php if ($all_update == 1) {echo "checked";}?> /></td>
                      <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type; ?>][<?php echo $perkey; ?>][all_delete]" value="1" <?php if ($all_delete == 1) {echo "checked";}?>/></td>
                    </tr>
            <?php }
            } else {
                $blanckModule1 = getRowByTableColomId('ia_permission', 'admin', 'user_type', 'data');
                if (isset($blanckModule1) && $blanckModule1 != '') {
                    foreach (json_decode($blanckModule1) as $key1 => $value1) {
                        ?>
                      <tr>
                        <th scope="col" colspan="5" class="showRolesPermission text-center"><?php echo ucfirst(str_replace('_', ' ', $key1)); ?>
                          <?php

                        $user_type = str_replace(' ', '_SPACE_', $user_type);
                        ?>
                          <input type="hidden" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>]" value="<?php echo $key1; ?>" />
                        </th>
                      </tr>
                      <tr>
                        <th scope="row" class="thfont"><?php echo lang('own_entries'); ?></th>
                        <td><input type="checkbox" class="chk_create" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>][own_create]" value="1"/></td>
                        <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>][own_read]"  value="1"/></td>
                        <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>][own_update]"  value="1"/></td>
                        <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>][own_delete]" value="1"/></td>
                      </tr>
                      <tr>
                        <th scope="row" class="thfont"><?php echo lang('all_entries'); ?></th>
                        <td>-</td>
                        <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>][all_read]"  value="1"/></td>
                        <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>][all_update]"  value="1"/></td>
                        <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type; ?>][<?php echo $key1; ?>][all_delete]" value="1"/></td>
                      </tr>
                <?php
}
                }
            }
            ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php
$i++;
        }
    }
    ?>
    <div class="row">
      <div class="col-md-12 m-b-20">
        <input type="submit" name="save" value="<?php echo lang('save_permission'); ?>" class="btn btn-wide btn-primary waves-effect margin-top-20" />
      </div>
    </div>
    <?php }?>
    </form>

    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
