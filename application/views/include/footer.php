<script>
$(document).ready(function(){
    setInterval(function(){
        $('#leftsidebar').height('');
        $('.list').height('');
        $('#leftsidebar').height($(document).height());
        $('.list').height($(document).height());
        // console.log($(document).height());
    }, 200);
});
    
</script>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/dropzone/dropzone.js"></script>
    <!-- Moment Plugin Js -->
    <script type="text/javascript" src="<?php echo iaBase() . 'assets/js/moment.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo iaBase() . 'assets/js/daterangepicker.js'; ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/node-waves/waves.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo iaBase(); ?>assets/js/admin.js"></script>
    <script src="<?php echo iaBase(); ?>assets/js/pages/tables/jquery-datatable.js"></script>

    <script src="<?php echo iaBase(); ?>assets/js/pages/forms/form-validation.js"></script>
    <script src="<?php echo iaBase(); ?>assets/js/custom.js"></script>
    <script src="<?php echo iaBase(); ?>assets/plugins/chartjs/Chart.bundle.js"></script>
    <script src="<?php echo iaBase(); ?>assets/js/dialogs.js"></script>

    <!-- Demo Js -->
    <script src="<?php echo iaBase(); ?>assets/js/demo.js"></script>
    <script>
    window['CKEDITOR_BASEPATH'] = '//cdn.ckeditor.com/4.4.7/full/';
    </script>
    <script src="<?php echo iaBase() . 'assets/ckeditor/ckeditor.js'; ?>"></script>
    <script src="<?php echo iaBase() . 'assets/ckeditor/adapters/jquery.js'; ?>"></script>
    <script src="<?php echo iaBase() ?>assets/js/clipboard.js"></script>
    <script src="<?php echo iaBase() ?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


    <script>
        $(document).ready(function() {
            chkLatestVersion();
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
        });


    </script>
</body>

</html>

<!-- The Modal -->
<div id="mka_image_preview_modal" role="dialog" class="modal fade">
    <!-- The Close Button -->
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
    </div>
</div>

<div class="modal fade" id="cnfrm_delete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel"><?php echo lang("Confirmation"); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo lang("Doyoureallywanttodelete"); ?>
            </div>
            <div class="modal-footer">
                <a type="button" href="" class="btn btn-primary waves-effect yes-btn"><?php echo lang("Yes"); ?></a>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><?php echo lang("No"); ?></button>
            </div>
        </div>
    </div>
</div>