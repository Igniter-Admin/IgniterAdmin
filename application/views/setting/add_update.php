<form action="<?php echo base_url() . 'setting/customField' ?>" method="post" id="customField_form" >
	<div class="form-group form-float">
		<div class="form-line">
			<select name="crud_nmae" required class="form-control" id="">
				<option value=""></option>
				<?php
$crud_list = $result['crud_list'];
$crud_list_arr = explode(',', $crud_list);
if (!empty($crud_list_arr)) {
    foreach ($crud_list_arr as $clakey => $clavalue) {
        $val = trim($clavalue);
        $selected = '';
        if (isset($data->rel_crud)) {
            if ($data->rel_crud == strtolower(str_replace(' ', '_', $val))) {
                $selected = 'selected="selected"';
            }
        }
        echo '<option value="' . strtolower(str_replace(' ', '_', $val)) . '" ' . $selected . ' >' . $val . '</option>';
    }
}
?>
			</select>
			<label for="" class="form-label"><?php echo lang('module'); ?></label>
		</div>
	</div>
	<div class="form-group form-float">
		<div class="form-line">
			<input type="text" name="field_name" required class="form-control" value="<?=isset($data->name) ? $data->name : '';?>">
			<label for="" class="form-label"><?php echo lang('field_name'); ?></label>
		</div>
	</div>
	<div class="form-group form-float">
		<div class="form-line">
			<select name="type" class="form-control" id="">
				<option value=""></option>
				<option value="text" <?=isset($data->type) && $data->type == 'text' ? 'selected' : '';?> ><?php echo lang('text'); ?></option>
				<option value="email" <?=isset($data->type) && $data->type == 'email' ? 'selected' : '';?>><?php echo lang('email') ?></option>
				<option value="text_area" <?=isset($data->type) && $data->type == 'text_area' ? 'selected' : '';?>><?php echo lang('text_area'); ?></option>
				<option value="numbers" <?=isset($data->type) && $data->type == 'numbers' ? 'selected' : '';?>><?php echo lang('numbers'); ?></option>
				<option value="options" <?=isset($data->type) && $data->type == 'options' ? 'selected' : '';?>><?php echo lang('options'); ?></option>
				<option value="checkbox" <?=isset($data->type) && $data->type == 'checkbox' ? 'selected' : '';?>><?php echo lang('checkbox'); ?></option>
				<option value="radio" <?=isset($data->type) && $data->type == 'radio' ? 'selected' : '';?>><?php echo lang('radio'); ?></option>
				<option value="date" <?=isset($data->type) && $data->type == 'date' ? 'selected' : '';?>><?php echo lang('date'); ?></option>
			</select>
			<label for="" class="form-label"><?php echo lang('type'); ?></label>
		</div>
	</div>
	<div class="form-group form-float">
		<div class="form-line">
			<select name="required" class="form-control" id="">
				<option value=""></option>
				<option value="1" <?=isset($data->required) && $data->required == '1' ? 'selected' : '';?>><?php echo lang('yes'); ?></option>
				<option value="0" <?=isset($data->required) && $data->required == '0' ? 'selected' : '';?>><?php echo lang('no'); ?></option>
			</select>
			<label for="" class="form-label"><?php echo lang('required'); ?></label>
		</div>
	</div>
	<div class="form-group form-float">
		<div class="form-line">
			<select name="show_in_grid" class="form-control" id="">
				<option value=""></option>
				<option value="1" <?=isset($data->show_in_grid) && $data->show_in_grid == '1' ? 'selected' : '';?>><?php echo lang('yes'); ?></option>
				<option value="0" <?=isset($data->show_in_grid) && $data->show_in_grid == '0' ? 'selected' : '';?>><?php echo lang('no'); ?></option>
			</select>
			<label for="" class="form-label"><?php echo lang('show_in_grid'); ?></label>
		</div>
	</div>
	<div class="form-group form-float">
		<div class="form-line">
			<select name="status" class="form-control" id="">
				<option value=""></option>
				<option value="active" <?=isset($data->status) && $data->status == 'active' ? 'selected' : '';?>><?php echo lang('active'); ?></option>
				<option value="deleted" <?=isset($data->status) && $data->status == 'deleted' ? 'selected' : '';?>><?php echo lang('deleted'); ?></option>
			</select>
			<label for="" class="form-label"><?php echo lang('status'); ?></label>
		</div>
	</div>
	<hr>
	<div class="form-group">
		<?php if (isset($data->ia_custom_fields_id)) {?>
			<input type="hidden" name="id" value="<?php echo $data->ia_custom_fields_id; ?>">
			<button class="btn btn-primary waves-effect"><?php echo lang('update'); ?></button>
		<?php } else {?>
			<button class="btn btn-primary waves-effect"><?php echo lang('save'); ?></button>
		<?php }?>
	</div>
</form>

<script>
	$.AdminBSB.input.activate();
	var set_options = function($obj, $val) {
		if($('.mka').length > 0) {
			$('.mka').remove();
		}
		if($obj.val() == 'options' || $obj.val() == 'checkbox' || $obj.val() == 'radio') {
			$html = '';
			$html += '<div class="form-group mka form-float">';
			$html += '<div class="form-line">';
			$html += '<textarea class="form-control" name="options" value="">'+$val+'</textarea>';
			$html += '<label for="" class="form-label"><?php echo lang("options"); ?></label>';
			$html += '</div">';
			$html += '<span class="help-text"><?php echo lang("enter_comma_saperated_options"); ?> </span>';
			$html += '</div>';
			$obj.parents('.form-group').after($html);
			$.AdminBSB.input.activate();
		}
	}
	$(document).ready(function() {
		set_options($('select[name="type"]'), '<?php echo isset($data->options) ? $data->options : ''; ?>');
		$('select[name="type"]').on('change', function() {
			set_options($(this), '');
		});
	});
</script>