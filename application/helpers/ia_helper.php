<?php

function CheckPermission($moduleName = "", $method = "")
{
    $CI = get_instance();
    $moduleName = strtolower(str_replace(' ', '_', $moduleName));
    $permission = isset($CI->session->get_userdata()['user_details'][0]->user_type) ? $CI->session->get_userdata()['user_details'][0]->user_type : '';
    // print_r($moduleName);die();
    if ($moduleName=="dashboard") {
        return true;
        exit();
    } else if ($moduleName=="settings" || $moduleName=="plugins") {
        if ($permission == "admin" || $permission == 'Admin') {
            return true;
            exit();
        }
    }
    if (isset($permission) && $permission != "") {

        if ($permission == 'admin' || $permission == 'Admin') {
            return true;
        } else {
            $getPermission = array();
            $getPermission = json_decode(getRowByTableColomId('ia_permission', $permission, 'user_type', 'data'));

            if (isset($getPermission->$moduleName)) {

                if (isset($moduleName) && isset($method) && $moduleName != "" && $method != "") {

                    $method_arr = explode(',', $method);
                    foreach ($method_arr as $method_item) {
                        if (isset($getPermission->$moduleName->$method_item)) {
                            return $getPermission->$moduleName->$method_item;
                        } else {
                            //return 0;
                        }
                    }
                    //return 0;
                } else {
                    return 0;
                }
            } else {return 0;}
        }
    } else {
        return 0;
    }
}

function getSetting($keys = '')
{
    $CI = get_instance();
    if (!empty($keys)) {
        $CI->db->select('*');
        $CI->db->from('ia_setting');
        $CI->db->where('keys', $keys);
        $query = $CI->db->get();
        $result = $query->row();
        if (!empty($result)) {
            $result = $result->value;
            return $result;
        } else {
            return false;
        }
    } else {
        $setting = $CI->db->get('ia_setting')->result();
        return $setting;
    }

}

function settings()
{
    $setting = getSetting();
    $result = [];
    foreach ($setting as $key => $value) {
        $result[$value->keys] = $value->value;
    }
    return $result;
}

function getRowByTableColomId($tableName = '', $id = '', $colom = 'id', $whichColom = '')
{
    if ($colom == 'id' && $tableName != 'ia_users') {
        $colom = $tableName . '_id';
    }
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from($tableName);
    $CI->db->where($colom, $id);
    $query = $CI->db->get();
    $result = $query->row();
    if (!empty($result)) {
        if (!empty($whichColom)) {
            $result = $result->$whichColom;
            return $result;
        } else {
            return $result;
        }
    } else {
        return false;
    }

}

function getOptionValue($keys = '')
{
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from('ia_setting');
    $CI->db->where('keys', $keys);
    $query = $CI->db->get();

    if (!empty($query->row())) {return $result = $query->row()->value;} else {return false;}

}

function getNameByColomeId($tableName = '', $id = '', $colom = 'id')
{
    if ($colom == 'id') {
        $colom = $tableName . '_id';
    }
    $CI = get_instance();
    $CI->db->select($colom);
    $CI->db->from($tableName);
    $CI->db->where($tableName . '_id', $id);
    $query = $CI->db->get();
    return $result = $query->row();

}

function selectBoxDynamic($field_name = '', $tableName = 'ia_setting', $colom = 'value', $selected = '', $attr = '', $whereCol = '', $whereVal = '')
{
    $add_per = 0;
    if (!CheckPermission($tableName, 'all_read') || !CheckPermission($tableName, 'all_update') || !CheckPermission($tableName, 'all_delete')) {
        $add_per = 1;
    }
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from($tableName);
    if (!empty($whereCol) && !empty($whereVal)) {
        $CI->db->where($whereCol, $whereVal);
    }
    if ($add_per == 1) {
        $CI->db->where('ia_users_id', $CI->session->get_userdata()['user_details'][0]->ia_users_id);
    }
    $query = $CI->db->get();
    if ($query->num_rows() > 0) {
        $catlog_data = $query->result();
        $res = '';
        $res .= '<select class="form-control" id="' . $field_name . '" name="' . $field_name . '" ' . $attr . ' >';
        $res .= '<option value=""></option>';
        foreach ($catlog_data as $catlogData) {
            $select_this = '';
            $tab_id = $tableName . '_id';
            if ($catlogData->$tab_id == $selected) {$select_this = ' selected ';}
            $res .= '<option value="' . $catlogData->$tab_id . '"  ' . $select_this . ' >' . $catlogData->$colom . '</option>';
        }
        $res .= '</select>';
    } else {
        $catlog_data = '';
        $res = '';
        $res .= '<select class="form-control" id="' . $field_name . '" name="' . $field_name . '" ' . $attr . ' >';
        $res .= '<option value=""></option>';
        $res .= '</select>';
    }
    return $res;
}

function MultipleSelectBoxDynamic($field_name = '', $tableName = 'ia_setting', $colom = 'value', $selected = '', $attr = '', $whereCol = '', $whereVal = '')
{
    $add_per = 0;
    if (!CheckPermission($tableName, 'all_read') || !CheckPermission($tableName, 'all_update') || !CheckPermission($tableName, 'all_delete')) {
        $add_per = 1;
    }
    $selected = explode(',', $selected);
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from($tableName);
    if (!empty($whereCol) && !empty($whereVal)) {
        $CI->db->where($whereCol, $whereVal);
    }
    if ($add_per == 1) {
        $CI->db->where('user_id', $CI->session->get_userdata()['user_details'][0]->ia_users_id);
    }
    $query = $CI->db->get();
    if ($query->num_rows() > 0) {
        $catlog_data = $query->result();
        $res = '';
        $res .= '<select multiple="multiple" class="form-control" id="' . $field_name . '" name="' . $field_name . '[]" ' . $attr . ' >';
        $res .= '<option value="">Select</option>';
        foreach ($catlog_data as $catlogData) {
            $select_this = '';
            $tab_id = $tableName . '_id';
            if (in_array($catlogData->$tab_id, $selected)) {$select_this = ' selected ';}
            $res .= '<option value="' . $catlogData->$tab_id . '"  ' . $select_this . ' >' . $catlogData->$colom . '</option>';
        }
        $res .= '</select>';
    } else {
        $catlog_data = '';
        $res = '';
        $res .= '<select class="form-control" id="' . $field_name . '" name="' . $field_name . '" ' . $attr . ' >';
        $res .= '</select>';
    }
    return $res;
}

function isLogin()
{
    if (isset($_SESSION['user_details'])) {
        return true;
    } else {
        redirect(base_url() . 'user/login', 'refresh');
    }
}

function getDataByid($tableName = '', $columnValue = '', $colume = '')
{
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from($tableName);
    $CI->db->where($colume, $columnValue);
    $query = $CI->db->get();
    return $result = $query->row();
}
function getAllDataByTable($tableName = '', $columnValue = '*', $colume = '')
{
    $CI = get_instance();
    $CI->db->select($columnValue);
    $CI->db->from($tableName);
    $query = $CI->db->get();
    if ($query->num_rows() > 0) {
        $catlog_data = $query->result();
        return $catlog_data;
    } else {return false;}
}

function getTemplatesByModule($module)
{
    $CI = get_instance();
    $CI->db->select('*');
    $CI->db->from('ia_email_templates');
    $CI->db->where('module', $module);
    $qr = $CI->db->get();
    return $qr->result();
}

function getCustomFields($crud, $rel_crd_id = null)
{
    $html = '';
    $cf_val = array();
    $CI = get_instance();
    $res = $CI->db->select('*')
        ->where('rel_crud', $crud)
        ->where('status', 'active')
        ->get('ia_custom_fields')
        ->result();
    if ($rel_crd_id) {
        $cf_val = $CI->db->select('*')
            ->where('rel_crud_id', $rel_crd_id)
            ->get('ia_custom_fields_values')
            ->result();
    }
    if ($res) {
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12">';
        $html .= '<h4> ' . lang("custom_fields") . ' </h4>';
        $html .= '<hr>';
        $html .= '</div>';

        foreach ($res as $rkey => $rvalue) {
            $ls = '';
            $required = '';
            if ($rvalue->required == 1) {
                $ls = '<span class="text-red">*</span>';
                $required = 'required';
            }
            $html .= '<div class="col-md-12">';
            $html .= '<div class="form-group form-float">';

            $v = '';
            if (!empty($cf_val)) {
                foreach ($cf_val as $cfvkey => $cfvvalue) {
                    if ($cfvvalue->cf_id == $rvalue->ia_custom_fields_id) {
                        $v = $cfvvalue->value;
                        break;
                    }
                }
            }
            if ($rvalue->type == 'text' || $rvalue->type == 'numbers' || $rvalue->type == 'date' || $rvalue->type == 'email') {
                $rvalue->type = $rvalue->type == 'numbers' ? 'number' : $rvalue->type;
                $html .= '<div class="form-line">';
                $html .= '<input type="' . $rvalue->type . '" name="mkacf[' . $rvalue->ia_custom_fields_id . ']" class="form-control" ' . $required . ' value="' . $v . '" />';
                $html .= '<label class="form-label">' . ucfirst(lang(getLang($crud) . '_' . getLang($rvalue->name))) . ' ' . $ls . '</label>';
                $html .= '</div>';

            } else if ($rvalue->type == 'text_area') {
                $html .= '<div class="form-line">';
                $html .= '<textarea name="mkacf[' . $rvalue->ia_custom_fields_id . ']" class="form-control" ' . $required . ' >' . $v . '</textarea>';
                $html .= '<label class="form-label">' . ucfirst(lang(getLang($crud) . '_' . getLang($rvalue->name))) . ' ' . $ls . '</label>';
                $html .= '</div>';
            } else if ($rvalue->type == 'options') {
                $html .= '<div class="form-line">';
                $html .= '<select class="form-control" name="mkacf[' . $rvalue->ia_custom_fields_id . ']" ' . $required . ' >';
                $html .= '<option value=""></option>';
                $opt = explode(',', $rvalue->options);
                if (is_array($opt) && !empty($opt)) {
                    foreach ($opt as $opkey => $opvalue) {
                        $opvalue = trim($opvalue);
                        $selected = '';
                        if ($v == $opvalue) {
                            $selected = 'selected="selected"';
                        }
                        $html .= '<option value="' . $opvalue . '" ' . $selected . ' >' . ucfirst(lang(strtolower($crud) . '_' . getLang($opvalue))) . '</option>';
                    }
                }
                $html .= '</select>';
                $html .= '<label class="form-label">' . ucfirst(lang(getLang($crud) . '_' . getLang($rvalue->name))) . ' ' . $ls . '</label>';
                $html .= '</div>';
            } else if ($rvalue->type == 'checkbox') {
                $opt = explode(',', $rvalue->options);
                if (is_array($opt) && !empty($opt)) {
                    $html .= '<label class="form-label">' . ucfirst(lang(getLang($crud) . '_' . getLang($rvalue->name))) . ' ' . $ls . '</label>';
                    foreach ($opt as $opkey => $opvalue) {
                        $opvalue = trim($opvalue);
                        $checked = '';
                        if (in_array($opvalue, explode(',', $v))) {
                            $checked = 'checked';
                        }
                        $html .= '<div class="checkbox">';
                        $html .= '<input type="checkbox" id="mka_' . $opvalue . '" value="' . $opvalue . '" name="mkacf[' . $rvalue->ia_custom_fields_id . '][]" ' . $checked . ' ' . $required . ' class="check_box ' . $required . '"   >';
                        $html .= '<label for="mka_' . $opvalue . '">' . ucfirst(lang(strtolower($crud) . '_' . getLang($opvalue))) . '</label>';
                        $html .= '</div>';
                    }
                }
            } else if ($rvalue->type == 'radio') {
                $opt = explode(',', $rvalue->options);
                if (is_array($opt) && !empty($opt)) {
                    $html .= '<label class="form-label">' . ucfirst(lang(getLang($crud) . '_' . getLang($rvalue->name))) . ' ' . $ls . '</label>';
                    foreach ($opt as $opkey => $opvalue) {
                        $opvalue = trim($opvalue);
                        $checked = '';
                        if ($opvalue == $v) {
                            $checked = 'checked';
                        }
                        $html .= '<div class="radio">';
                        $html .= '<input type="radio" id="mka_r_' . $opvalue . '" value="' . $opvalue . '" name="mkacf[' . $rvalue->ia_custom_fields_id . ']" ' . $checked . ' ' . $required . '>';
                        $html .= '<label for="mka_r_' . $opvalue . '">' . ucfirst(lang(strtolower($crud) . '_' . getLang($opvalue))) . '</label>';
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

function getCustomField($crud)
{
    $CI = get_instance();
    $res = $CI->db->select('*')
        ->where('rel_crud', $crud)
        ->where('status', 'active')
        ->where('show_in_grid', '1')
        ->get('ia_custom_fields')
        ->result();

    return $res;
}

function iaBase()
{
    return str_replace('index.php/', '', base_url());
}

function getLang($str)
{
    $str = strtolower($str);
    return $str = str_replace(' ', '_', $str);
}

function customMenus()
{
    $CI = get_instance();
    $menus = $CI->db->select('*')
        ->where('status', '1')
        ->order_by("sorting", "asc")
        ->get('ia_menu')
        ->result();
    $mka = '';
    foreach ($menus as $key => $value) {
        $slug = $value->slug.'/';
        $slugs = "";
        if (strpos($value->slug,"/")) {
            $slugs = explode("/",$value->slug);
        }
        $cl = 'not-active';
        if ($CI->router->class == $value->slug) {
            $cl = 'active';
        } elseif ($CI->router->method == $value->slug && strpos($value->slug,"/")) {
            $cl = 'active';
        } else if (!empty($slugs)) {
            if ($CI->router->method == $slugs[1]) {
                $cl = 'active';
            }
        } elseif ($CI->router->method == $value->slug && $value->slug == "dashboard") {
            $cl = 'active';
        }
        $pId = $value->id;
        $subMenus = $CI->db->query('SELECT * FROM ia_menu WHERE parent_id = '.$pId.' ORDER BY sorting ASC')->result();
        if (CheckPermission($value->menu_name,"own_read") || CheckPermission($value->menu_name, "all_read")) {
            if (!empty($subMenus)) {
                $subcl_array = array();
                $submka = '';
                $route_class = array();
                $i = 0;
                foreach ($subMenus as $subkey => $subvalue) {
                    if (strpos($subvalue->slug,"/")) {
                        $route_class = explode("/",$subvalue->slug);
                    } else {
                        $route_class = $subvalue->slug;
                    }
                    $abc[$i] = $route_class;
                    $subcl = 'not-active';

                    if ($CI->router->class == $subvalue->slug) {
                        $subcl = 'active';
                    } else if (!empty($route_class) && $CI->router->method != $value->slug) {
                        if ($CI->router->method == $route_class[1]) {
                            $subcl = 'active';
                        }
                    }
                    $submka .= '<li class="'.$subcl.'">
                                <a href="'.base_url() . $subvalue->slug.'">
                                 <span>'.ucwords(str_replace('_', ' ', $subvalue->menu_name)).'</span>
                                </a>
                            </li>';
                    $subcl_array[$i] = $subcl;
                    $i++;
                }
                if ($value->module_name) {
                    $copy_menu = '<li class="'.$cl.'" style="display:none;">
                                    <a href="'.base_url() . $value->slug.'">
                                     <span>'.ucwords(str_replace('_', ' ', $value->menu_name)).'</span>
                                    </a>
                                </li>';
                } else {
                    $copy_menu = '<li class="'.$cl.'">
                                    <a href="'.base_url() . $value->slug.'">
                                     <span>'.ucwords(str_replace('_', ' ', $value->menu_name)).'</span>
                                    </a>
                                </li>';
                }
                if (in_array("active", $subcl_array) == 1) {
                    $cl = "active";
                } else {
                    $cl = "not-active";
                }
                if (strpos($value->icon,",")) {
                    $s_icons = explode(",",$value->icon);
                    $mka .= '<li class="treeview '.$cl.'">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="'.$s_icons[0].'">'.$s_icons[1].'</i>
                        <span>'.ucwords(str_replace('_', ' ', $value->menu_name)).'</span>
                    </a>
                    <ul class="ml-menu">'.$copy_menu.$submka.'</ul>
                        </li>';
                } else {
                    $mka .= '<li class="treeview '.$cl.'">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="'.$value->icon.'"></i>
                        <span>'.ucwords(str_replace('_', ' ', $value->menu_name)).'</span>
                    </a>
                    <ul class="ml-menu">'.$copy_menu.$submka.'</ul>
                        </li>';
                }
            } else if ($value->parent_id != 0) {
                $mka .= '';
            } else {
                if (strpos($value->icon,",")) {
                    $icons = explode(",",$value->icon);
                    $mka .= '<li class="' . $cl . '">
                                <a href="' . base_url() . $value->slug . '">
                                <i class="' . $icons[0] . '">'.$icons[1].'</i>
                                <span>' . ucwords(str_replace('_', ' ', $value->menu_name)) . '</span></a>
                            </li>';
                }
                else {
                    $mka .= '<li class="' . $cl . '">
                                <a href="' . base_url() . $value->slug . '">
                                <i class="' . $value->icon . '"></i>
                                <span>' . ucwords(str_replace('_', ' ', $value->menu_name)) . '</span></a>
                            </li>';
                }
            }
        }
        
    }
    return $mka;
}

function checkEnableStatus($name)
{
    $CI = get_instance();
    return $CI->db->where('name', $name)
        ->where('status', 1)
        ->get('ia_plugins')->result();
}

/**
 * This function is used to upload single file
 * @return Void
 */
function upload($name, $path = 'assets/images/', $allow_type = array())
{
    $CI = get_instance();
    if (empty($allow_type)) {
        $allow_type = 'gif|jpg|jpeg|png';
    } else {
        $allow_type = implode('|', $allow_type);
    }
    $result = array();
    $filename = str_replace(' ', '_', strtolower($_FILES[$name]['name']));
    if ($filename != '') {
        $tmpname = $_FILES[$name]['tmp_name'];
        $exp = explode('.', $filename);
        $ext = end($exp);
        $newname = $exp[0] . '_' . time() . "." . $ext;
        $config['upload_path'] = $path;
        $config['upload_url'] = base_url() . $path;
        $config['allowed_types'] = $allow_type;
        $config['max_size'] = 2048;
        $config['file_name'] = $newname;
        $CI->load->library('upload', $config);
        if (!$CI->upload->do_upload($name)) {
            $result['error'] = $CI->upload->display_errors();
        }
        return $newname;
    }
}

/**
 * Set session alert / flashdata
 * @param string $type    Alert type
 * @param string $message Alert message
 */
function setAlert($type, $message)
{
    $CI = &get_instance();
    $CI->session->set_flashdata('message-' . $type, $message);
}

function latestVersion()
{
    $CI = &get_instance();
    $CI->load->model("Update_model");
    $update_data = $CI->Update_model->getUpdateInfo();
    $current_version = $CI->Update_model->getCurrentDbVersion();
    $data = json_decode($update_data);
    if ($data->latest_version > $current_version) {
        return $data->latest_version;
    } else {
        return 0;
    }
}
