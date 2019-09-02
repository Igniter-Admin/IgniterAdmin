<!-- Content Wrapper. Contains page content -->
<section class="content extensions-page">
  <div class="container-fluid">
    <div class="card">
      <div class="header">
        <h2><?php echo lang('plugins'); ?></h2>
        <ul class="header-dropdown m-r--5">
          <a class="btn btn-primary" target="_blank" href="http://www.igniteradmin.com/plugins"><i class="material-icons">search</i> Plugin Store</a>
          <button class="btn btn-primary waves-effect add-extn-btn" type="button"> <i class="material-icons">add</i> <?php echo lang('add_plugins'); ?> </button>
        </ul>
      </div>
      <div class="body">
        <div class="row">
          <div class="col-md-12">
            <blockquote class="m-b-25" style="display: none;">
              <form action="<?php echo base_url() . 'plugins/install'; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <div class="form-line">
                    <input type="file" required name="extn_file" class="form-control" accept=".zip">
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary"><?php echo lang('install'); ?></button>
                  <input class="btn btn-danger cn-btn" type="reset" value="<?php echo lang('cancel'); ?>">
                </div>
              </form>
            </blockquote>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <!-- <table class="table table-hover" id="plugins_tbl">
                  <thead>
                    <tr>
                      <th><strong>#</strong></th>
                      <th><strong><?php echo lang('name'); ?></strong></th>
                      <th><strong><?php echo lang('status'); ?></strong></th>
                      <th><strong><?php echo lang('action'); ?></strong></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table> -->

                <table class="table table-hover" id="plugins_tbl">
                  <thead>
                    <tr>
                      <th><strong>#</strong></th>
                      <th><strong><?php echo lang('name'); ?></strong></th>
                      <th><strong><?php echo lang('status'); ?></strong></th>
                      <th><strong><?php echo lang('action'); ?></strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($result as $key => $value) { ?>
                    <tr>
                    <td><?=$value['plugins_id']?></td>
                    <td><?=$value['name']?></td>
                    <td><?php $t = lang('inactive');$c = 'red'; if($value['status']==1){$t = lang('active');$c = 'blue';}?>
                    <span class="label bg-<?=$c?>" data-id="' . $value['plugins_id'] . '" rel="<?=$value['status']?>"><?=$t?></span></td>
                    <td><?php 
                      $title = lang('active');
                      $icn = 'check_circle';
                      $color = 'green';
                      if ($value['status'] == 1) {
                          $title = lang('inactive');
                          $icn = 'cancel';
                          $color = 'orange';
                      }                      ?>
                        <a  class="ch-status" data-id="<?=$value['plugins_id']?>" rel="<?=$value['status']?>" title="<?=$title?>"><i class="material-icons col-<?=$color?> font-20"><?=$icn?></i></a>
                        <a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="<?=lang('delete')?>" onclick="setId(<?=$value['plugins_id']?>, 'plugins')"><i class="material-icons col-red font-20">delete</i></a>
                      </td>
                    <!-- <td><input type="checkbox" id="basic_checkbox_<?=$key?>" name="selData" value="<?=$value['ia_users_id']?>"><label for="basic_checkbox_<?=$key?>"></label></td>
                    <td><?=$value['name']?></td>
                    <td><?=$value['email']?></td>
                    <td><?=$value['user_type']?></td>
                    <?php if (is_array($cf) && !empty($cf)) { ?>
                      <td><?=$value['cfv_0']?></td>
                      <?php } ?>
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
                    </td> -->
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    // data_table();
    $("#plugins_tbl").DataTable();
    $('body').on('click', '.ch-status', function() {
      $.post($('body').attr('data-base-url') + 'plugins/updateStatus', {status: $(this).attr('rel'), id : $(this).attr('data-id')}, function(data) {
          if(data) {
            window.location.reload();
          }
        });
    });

    $('.add-extn-btn').on('click', function() {
      $('blockquote').slideToggle('slow');
    });

    $('.cn-btn').on('click', function() {
      $('blockquote').slideUp('slow');
    })
  });

// var data_table = function($filter, $search) {
//   var url = "<?php echo base_url(); ?>";
//   return table = $("#plugins_tbl").DataTable({
//     "dom":  "lfBrtip",
//             "buttons": [],
//             "processing": true,
//             "serverSide": true,
//             "ajax": {
//               "url" : url + "plugins/ajxData",
//               "data": function ( d ) {
//                 if($filter != '') {
//                   $.each($filter, function(index, val) {
//                     d[index] = val;
//                   });
//                 }
//               }
//             },
//             "sPaginationType": false,
//             "bPaginate": false,
//             "paging":   false,
//             "info":     false,
//             "language": {
//               "search": "_INPUT_",
//               "searchPlaceholder": "<?php echo lang('search'); ?>",
//               "paginate": {
//                 "next": '<i class="material-icons">keyboard_arrow_right</i>',
//                 "previous": '<i class="material-icons">keyboard_arrow_left</i>',
//                 "first": '<i class="material-icons">first_page</i>',
//                 "last": '<i class="material-icons">last_page</i>'
//               }
//             },
//             "iDisplayLength": 10,
//             "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"<?php echo lang('all'); ?>"]],
//             "columnDefs" : [
//               {
//                 "orderable": false,
//                 "targets": [0]
//               }
//               <?php if (!CheckPermission("plugins", "all_delete") && !CheckPermission("plugins", "own_delete")) {?>
//               ,{
//                 "targets": [0],
//                 "visible": false,
//                 "searchable": false
//               }
//             <?php }?>
//             ],
//             "order": [[1, 'asc']],
//             "oSearch": {"sSearch": $search}
//           });
//         }
</script>
