<?php
/**
*@if(CheckPermission('crm', 'read'))
**/
 

	function setting_all($keys='')
	{  
		$CI = get_instance();
		if(!empty($keys)){
			$CI->db->select('*');
			$CI->db->from('ia_setting');
			$CI->db->where('keys' , $keys);
			$query = $CI->db->get();
			$result = $query->row();
			if(!empty($result)){
				 $result = $result->value;
				return $result;
			}
			else
			{
				return false;
			}
		}
		else{
			$CI->load->model('setting/setting_model');
			$setting= $CI->setting_model->get_setting();
			return $setting;
		}
		
	}


  function is_login(){ 
      if(isset($_SESSION['user_details'])){
          return true;
      }else{
         redirect( base_url().'user/login', 'refresh');
      }
  }
  function form_safe_json($json) {
    $json = empty($json) ? '[]' : $json ;
    $search = array('\\',"\n","\r","\f","\t","\b","'") ;
    $replace = array('\\\\',"\\n", "\\r","\\f","\\t","\\b", "&#039");
    $json = str_replace($search,$replace,$json);
    return strip_tags($json);
}

function search_in_array_obj($arr, $arrKey, $sVal) {
	  	if(!empty($arr)) {
	    	foreach ($arr as $arkey => $arValue) {
	      		if($sVal == $arValue->$arrKey) {
	        		return true;
	      		}
	    	}    
	  	}
	}
	function get_custom_fields($crud, $rel_crd_id = NULL){
		$html = '';
		$cf_val = array();
		$CI = get_instance();
		$res = $CI->db->select('*')
					  ->where('rel_crud', $crud)
					  ->where('status', 'active')
					  ->get('ia_custom_fields')
					  ->result();
		if($rel_crd_id) {
			$cf_val = $CI->db->select('*')
					  ->where('rel_crud_id', $rel_crd_id)
					  ->get('ia_custom_fields_values')
					  ->result();
		}
		if($res) {
			$html .= '<div class="row">';
			$html .= '<div class="col-md-12">';
			$html .= '<h4> '.lang("custom_fields").' </h4>';
			$html .= '<hr>';
			$html .= '</div>';

			foreach ($res as $rkey => $rvalue) {
				$ls = '';
				$required = '';
				if($rvalue->required == 1) {
					$ls = '<span class="text-red">*</span>';
					$required = 'required';
				}
				$html .= '<div class="col-md-12">';
				$html .= '<div class="form-group form-float">';
				
				$v = '';
				if(!empty($cf_val)) {
					foreach ($cf_val as $cfvkey => $cfvvalue) {
						if($cfvvalue->cf_id == $rvalue->custom_fields_id) {
							$v = $cfvvalue->value;
							break;
						}
					}
				}
				if($rvalue->type == 'text' || $rvalue->type == 'numbers' || $rvalue->type == 'date' || $rvalue->type == 'email') {
					$rvalue->type = $rvalue->type == 'numbers'?'number':$rvalue->type;
					$html .= '<div class="form-line">';
					$html .= '<input type="'.$rvalue->type.'" name="mkacf['.$rvalue->custom_fields_id.']" class="form-control" '.$required.' value="'.$v.'" />';
					$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
					$html .= '</div>';
					
				} else if($rvalue->type == 'text_area') {
					$html .= '<div class="form-line">';
					$html .= '<textarea name="mkacf['.$rvalue->custom_fields_id.']" class="form-control" '.$required.' >'.$v.'</textarea>';
					$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
					$html .= '</div>';
				} else if($rvalue->type == 'options') {
					$html .= '<div class="form-line">';
					$html .= '<select class="form-control" name="mkacf['.$rvalue->custom_fields_id.']" '.$required.' >';
					$html .= '<option value=""></option>';
					$opt = explode(',', $rvalue->options);
					if(is_array($opt) && !empty($opt)) {
						foreach ($opt as $opkey => $opvalue) {
							$opvalue = trim($opvalue);
							$selected = '';
							if($v == $opvalue) {
								$selected = 'selected="selected"';
							}
							$html .= '<option value="'.$opvalue.'" '.$selected.' >'.ucfirst(lang(strtolower($crud).'_'.get_lang($opvalue))).'</option>';
						}
					}
					$html .= '</select>';
					$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
					$html .= '</div>';
				} else if($rvalue->type == 'checkbox') {
					$opt = explode(',', $rvalue->options);
					if(is_array($opt) && !empty($opt)) {
						$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
						foreach ($opt as $opkey => $opvalue) {
							$opvalue = trim($opvalue);
							$checked = '';
							if(in_array($opvalue, explode(',', $v))) {
								$checked = 'checked';
							}
							$html .= '<div class="checkbox">';
							$html .= '<input type="checkbox" id="mka_'.$opvalue.'" value="'.$opvalue.'" name="mkacf['.$rvalue->custom_fields_id.'][]" '.$checked.' '.$required.' class="check_box '.$required.'"   >';
							$html .= '<label for="mka_'.$opvalue.'">'.ucfirst(lang(strtolower($crud).'_'.get_lang($opvalue))).'</label>';
							$html .= '</div>';
						}
					}
				} else if($rvalue->type == 'radio') {
					$opt = explode(',', $rvalue->options);
					if(is_array($opt) && !empty($opt)) {
						$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
						foreach ($opt as $opkey => $opvalue) {
							$opvalue = trim($opvalue);
							$checked = '';
							if($opvalue == $v) {
								$checked = 'checked';
							}
							$html .= '<div class="radio">';
							$html .= '<input type="radio" id="mka_r_'.$opvalue.'" value="'.$opvalue.'" name="mkacf['.$rvalue->custom_fields_id.']" '.$checked.' '.$required.'>';
							$html .= '<label for="mka_r_'.$opvalue.'">'.ucfirst(lang(strtolower($crud).'_'.get_lang($opvalue))).'</label>';
							$html .= '</div>';
							$required = '';
						}
					}
				}
				
				$html .= '</div>';
				$html .= '</div>';
			}
			$html .= '</div>';
		}
		echo $html;
	}

	function get_cf($crud) {
		$CI = get_instance();
		$res = $CI->db->select('*')
					  ->where('rel_crud', $crud)
					  ->where('status', 'active')
					  ->where('show_in_grid', '1')
					  ->get('ia_custom_fields')
					  ->result();

		return $res;	
	}


	function mka_base() {
		return str_replace('index.php/', '', base_url());
	}

	function get_lang($str) {
	    $str = strtolower($str);
	    return $str = str_replace(' ', '_', $str);
    }

    function custom_menus() {
    	$CI = get_instance();
    	$menus = $CI->db->select('*')
    					->where('status', '1')
    					->get('wpb_c_modules')
    					->result();
    	$mka = '';
    	foreach ($menus as $key => $value) {
    		$cl = 'not-active';
    		if($CI->router->class == $value->slug) {
    			$cl = 'active';
    		}
    		$mka .= '<li class="'.$cl.'"> 
                        <a href="'.base_url().$value->slug.'"> 
                        <i class="'.$value->icon.'"></i>   
                        <span>'.$value->menu_name.'</span></a>
                    </li>';	
    	}
    	return $mka;
    }

    function char_limit($string, $length) {
  		if(strlen($string) <= $length) {
    		return $string;
  		} else {
    		$y = substr($string,0,$length) . '...';
    		return $y;
  		}
	}

	function get_operator($opt) {
		switch ($opt) {
	    	case 'equal_to':
	        	return '=';
	        	break;
	    	case 'greater_then':
	        	return '>';
	        	break;
	    	case 'greater_then_equal_to':
	        	return '>=';
	        	break;
	        case 'less_then':
	        	return '<';
	        	break;
	        case 'less_then_equal_to':
	        	return '<=';
	        	break;
	        case 'not_equal_to':
	        	return '!=';
	        	break;
	    	default:
	    		return '=';    	
		}	

	}

	function generateRandomNumber($length = 10, $str = FALSE) {
	    $characters = '0123456789';
		if($str === TRUE) {
			$characters .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

?>