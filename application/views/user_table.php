<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>
               <?php echo lang("users"); ?>
            </h2>
            <ul class="header-dropdown m-r--5">
                <?php if (CheckPermission("user", "own_create")) {?>
                  <button type="button" class="btn btn-lg btn-primary waves-effect modalButtonUser" data-toggle="modal"><i class="material-icons">add</i> <?php echo lang('add_user'); ?></button>
                <?php }if (getSetting('email_invitation') == 1) {?>
                  <button type="button" class="btn btn-lg btn-primary waves-effect InviteUser" data-toggle="modal"><i class="material-icons">add</i><?php echo lang('invite_users'); ?></button>
                <?php }?>
            </ul>
          </div>
          <!-- /.box-header -->
          <div class="body table-responsive">
            <table id="mtc123" class="table table-bordered table-striped table-hover delSelTable">
              <thead>
                  <tr>
                  <th>
                    <input type="checkbox" class="selAll" id="basic_checkbox_1mka" />
                    <label for="basic_checkbox_1mka"></label>
                  </th>
                  
                  <th><?php echo lang('name') ?></th>
                  <th><?php echo lang('email') ?></th>
                  <th><?php echo lang('user_type') ?></th>
                  
                  <?php $cf = getCustomField('user');
if (is_array($cf) && !empty($cf)) {
    foreach ($cf as $cfkey => $cfvalue) {
        echo '<th>' . lang(getLang($cfvalue->rel_crud) . '_' . getLang($cfvalue->name)) . '</th>';
    }
}
?>
                  <th><?php echo lang('Action'); ?></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($result as $key => $value) { ?>
                <tr>
                <td><input type="checkbox" id="basic_checkbox_<?=$key?>" name="selData" value="<?=$value['ia_users_id']?>"><label for="basic_checkbox_<?=$key?>"></label></td>
                <td><?=$value['name']?></td>
                <td><?=$value['email']?></td>
                <td><?=$value['user_type']?></td>
                <?php 
                      if (is_array($cf) && !empty($cf)) {
                        $cf_i = 0;
                        foreach ($cf as $cfkey => $cfvalue) {
                ?>
                  <td><?=$value['cfv_'.$cf_i]?></td>
                  <?php
                        $cf_i++;
                        } 
                      } 
                  ?>
                <td>
                  <?php 
                    if (CheckPermission('user', "all_update")) { ?>
                        <a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="<?=$value['ia_users_id']?>" title="Edit"><i class="material-icons font-20">mode_edit</i></a>
                    <?php } else if (CheckPermission('user', "own_update") && (CheckPermission('user', "all_update") != true)) {
                        $user_id = getRowByTableColomId('ia_users', $value['ia_users_id'], 'ia_users_id', 'user_id');
                        if ($user_id == $this->user_id) { ?>
                            <a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="<?=$value['ia_users_id']?>" title="Edit"><i class="material-icons font-20">mode_edit</i></a>
                       <?php }
                    }

                    if (CheckPermission('user', "all_delete")) { ?>
                        <a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(<?=$value['ia_users_id']?>, 'user')" data-target="#cnfrm_delete" title="delete"><i class="material-icons col-red font-20">delete</i></a>
                      <?php } else if (CheckPermission('user', "own_delete") && (CheckPermission('user', "all_delete") != true)) {
                        $user_id = getRowByTableColomId('ia_users', $value['ia_users_id'], 'ia_users_id', 'user_id');
                        if ($user_id == $this->user_id) { ?>
                            <a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(<?=$value['ia_users_id']?>, 'user')" data-target="#cnfrm_delete" title="delete"><i class="material-icons col-red font-20">delete</i></a>
                      <?php  }
                    }
                  ?>
                </td>
                </tr>
              <?php } ?>
              </tbody>
          </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
  </div>
  <!-- /.row -->
</section>
  <!-- /.content -->
<div class="modal fade" id="nameModal_user" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="defaultModalLabel"><?php echo lang('user_form'); ?></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div><!--End Modal Crud -->
<script type="text/javascript">
$(document).ready(function() {
    $('#mtc123').DataTable({
      dom: 'lfBrtip',
        buttons: [
            'excel'
        ]
      });
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');

        $('.dataTables_info').before('<button data-del-url="<?php echo base_url() . 'user/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
} );
  
</script>