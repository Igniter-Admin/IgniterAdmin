<form action="<?php echo base_url() . "templates/addEdit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 30px">
 <?php
//$id =  isset($data->id) ?$data->id : "";
if (isset($data->id)) {?><input type="hidden"  name="id" value="<?php echo isset($data->id) ? $data->id : ""; ?>"> <?php }?>
 	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group form-float">
				<div class="form-line">
					<label class="form-label"><?php echo lang('template_name'); ?></label>
					<input type="text" class="form-control" id="template_name" name="template_name" required value="<?php echo isset($data->template_name) ? $data->template_name : ""; ?>"  ></div>
				</div>
			</div>
		</div>
		<div class="form-group template-vars">
			<label for="help-variables"><?php echo lang('template_Variables'); ?></label>
			<div class="help-variables-div">
				<p class="line">
					<span class="col-md-4">
						<code>{var_user_type}</code>
					</span>
					<span class="col-md-7">
						<strong>: <?php echo lang('user_type'); ?></strong>
					</span>
				</p>
				<p class="line">
					<span class="col-md-4">
						<code>{var_user_name}</code>
					</span>
					<span class="col-md-7">
						<strong>: <?php echo lang('user_name'); ?></strong>
					</span>
				</p>
				<p class="line">
					<span class="col-md-4">
						<code>{var_sender_name}</code>
					</span>
					<span class="col-md-7">
						<strong>: <?php echo lang('sender_name'); ?></strong>
					</span>
				</p>
				<p class="line">
					<span class="col-md-4">
						<code>{var_website_name}</code>
					</span>
					<span class="col-md-7">
						<strong>: <?php echo lang('website_name'); ?></strong>
					</span>
				</p>
				<p class="line">
					<span class="col-md-4">
						<code>{var_user_email}</code>
					</span>
					<span class="col-md-7">
						<strong>: <?php echo lang('user_email'); ?></strong>
					</span>
				</p>
				<p class="line">
					<span class="col-md-4">
						<code>{var_inviation_link}</code>
					</span>
					<span class="col-md-7">
						<strong>: <?php echo lang('invitation_link'); ?></strong>
					</span>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label for="html"><?php echo lang('html'); ?></label>
			<textarea class="form-control ckeditor" id="html" name="html" required><?php echo isset($data->html) ? $data->html : ""; ?></textarea>
		</div>
	</div>
    <!-- /.box-body -->
    <div class="box-footer sub-btn-wdt">
    	<input type="submit" value="Save" name="save" class="btn btn-primary waves-effect wdt-bg">
    </div>
</form>
<script>
	$.AdminBSB.input.activate();
	var tt = $('textarea.ckeditor').ckeditor();
	CKEDITOR.config.allowedContent = true;
	$(document).ready(function() {
		$('#nameModal_Templates')
			.find('div.col-md-offset-4')
			.removeClass('col-md-offset-4')
			.removeClass('col-md-4')
			.addClass('modal-dialog')
			.addClass('modal-lg');
	});
</script>