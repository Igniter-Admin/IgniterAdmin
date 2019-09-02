<?php defined("BASEPATH") or exit("No direct script access allowed");

class Setting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Checking user is login or not
        isLogin();
        $this->load->model("Setting_model");
        $this->lang->load('settings', getSetting('language'));
    }

    /**
     * Load Setting view page
     */
    public function index()
    {
        $this->load->model("Update_model");
        $result = array();
        $data['result'] = getSetting();
        $result = [];
        foreach ($data['result'] as $key => $value) {
            $result[$value->keys] = $value->value;
        }

        $this->load->view('include/header');
        if (getSetting('UserModules') == 'yes') {
            if (isset($this->session->get_userdata()['user_details'][0]->user_type) && $this->session->get_userdata()['user_details'][0]->user_type == 'admin') {
                $data['result'] = $result;
                $this->load->view('setting/index', $data);
            }
        } else {
            $data['result'] = $result;
            $this->load->view('setting/index', $data);
        }

        $this->load->view('include/footer');
    }

    /**
     * This function is used to update setting
     */
    public function editSetting()
    {
        $data = array();
        $data = $this->input->post();
        $data['logo'] = '';
        if (isset($data['user_type']) && is_array($data['user_type']) && !empty($data['user_type'])) {
            $data['user_type'] = json_encode($data['user_type']);
        }

        if (!empty($_FILES['logo']['name'])) {
            $newname = upload('logo');
            $data['logo'] = $newname;
            if (!$newname) {
                redirect(base_url() . 'setting', 'refresh');
            }
        } else {
            if ($this->input->post('fileOldlogo')) {
                $data['logo'] = $this->input->post('fileOldlogo');
            }
        }

        foreach ($data as $key => $value) {
            $this->Setting_model->updateRow('ia_setting', 'keys', $key, array('value' => $value));
        }

        $art_msg['msg'] = lang('your_data_updated_successfully');
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        if ($this->input->post('mail_setting')) {
            redirect(base_url() . 'setting#emailSetting', 'refresh');
        } else {
            redirect(base_url() . 'setting', 'refresh');
        }
    }

    public function editMailSetting()
    {
        $data = array();
        $data = $this->input->post();
        if (isset($data['user_type']) && is_array($data['user_type']) && !empty($data['user_type'])) {
            $data['user_type'] = json_encode($data['user_type']);
        }

        foreach ($data as $key => $value) {
            $this->Setting_model->updateRow('ia_setting', 'keys', $key, array('value' => $value));
        }

        $art_msg['msg'] = lang('your_data_updated_successfully');
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        if ($this->input->post('mail_setting')) {
            redirect(base_url() . 'setting#emailSetting', 'refresh');
        } else {
            redirect(base_url() . 'setting', 'refresh');
        }
    }

    public function editRegistrationSetting()
    {
        $data = array();
        $data = $this->input->post();
        if (isset($data['user_type']) && is_array($data['user_type']) && !empty($data['user_type'])) {
            $data['user_type'] = json_encode($data['user_type']);
        }

        if (!isset($data['register_allowed'])) {
            $data['register_allowed'] = 0;
        }

        if (!isset($data['admin_approval'])) {
            $data['admin_approval'] = 0;
        }
        
        foreach ($data as $key => $value) {
            $this->Setting_model->updateRow('ia_setting', 'keys', $key, array('value' => $value));
        }

        $art_msg['msg'] = lang('your_data_updated_successfully');
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        if ($this->input->post('mail_setting')) {
            redirect(base_url() . 'setting#emailSetting', 'refresh');
        } else {
            redirect(base_url() . 'setting#registration-setting', 'refresh');
        }
    }

    public function updateRole()
    {
        $data = $this->input->post();

        if (isset($data['user_type_name'])) {
            if (is_array($data['user_type_name']) && !empty($data['user_type_name'])) {
                foreach ($data['user_type_name'] as $utkey => $utvalue) {
                    $this->Setting_model->updateRow('ia_permission', 'id', $utkey, array('user_type' => $utvalue));
                }
            }

            unset($data['user_type_name']);
        }

        if (isset($data['new_user_name'])) {
            $permissiona = $this->Setting_model->getAdminPermissions();
            if (is_array($data['new_user_name']) && !empty($data['new_user_name'])) {
                foreach ($data['new_user_name'] as $nutkey => $nutvalue) {
                    $inst_data = array(
                        'user_type' => $nutvalue,
                        'data' => $permissiona->data,
                    );
                    $this->Setting_model->insertRow('ia_permission', $inst_data);
                }
            }
            unset($data['new_user_name']);
        }

        if (isset($data['rm_user_type'])) {
            if (is_array($data['rm_user_type']) && !empty($data['rm_user_type'])) {
                foreach ($data['rm_user_type'] as $rutkey => $rutvalue) {
                    $this->Setting_model->delete('ia_permission', 'id', $rutvalue);
                }
            }
            unset($data['rm_user_type']);
        }

        $art_msg['msg'] = lang('your_data_updated_successfully');
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'setting#permission-setting', 'refresh');
    }

    /**
     * This function is used to add new user type
     * @return: true if update successfuly
     */
    public function addUserType()
    {
        echo $this->Setting_model->addUserType();
        exit;
    }

    /**
     * This function is used to update user permissions
     * @return: true if update successfuly
     */

    public function permission()
    {
        $data = array();
        $dataa = $this->input->post('data');
        foreach ($dataa as $key => $value) {
            $key = str_replace('_SPACE_', ' ', $key);
            $arr = array();
            foreach ($value as $vkey => $vvalue) {
                $vkey = str_replace('_SPACE_', ' ', $vkey);
                $arr[$vkey] = $vvalue;
            }
            $this->Setting_model->updateRow('ia_permission', 'user_type', $key, array('data' => json_encode($arr)));
        }
        $art_msg['msg'] = lang('your_data_updated_successfully');
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'setting#permission-setting', 'refresh');
    }

    /**
     * This function is used to show custom fields list in setting
     */
    public function ajaxData()
    {
        $primaryKey = 'ia_custom_fields_id';
        $table = 'ia_custom_fields';
        $columns = array(
            array('db' => 'ia_custom_fields_id', 'dt' => 0),
            array('db' => 'name', 'dt' => 1),
            array('db' => 'type', 'dt' => 2),
            array('db' => 'rel_crud', 'dt' => 3),
            array('db' => 'status', 'dt' => 4),
            array('db' => 'create_date', 'dt' => 5),
        );
        $joinQuery = "FROM `ia_custom_fields` ";
        $where = '';
        $j = 0;
        if (strpos($joinQuery, 'JOIN') > 0) {
            $j = 1;
        }
        $where = SSP::iaFilter($_GET, $columns, $j);

        $group_by = "";
        $having = "";

        $limit = SSP::limit($_GET, $columns);
        $order = SSP::order($_GET, $columns, $j);
        $col = SSP::pluck($columns, 'db', $j);

        $query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $col) . " " . $joinQuery . " " . $where . " " . $group_by . " " . $having . " " . $order . " " . $limit . " ";
        $res = $this->db->query($query);
        $res = $res->result_array();
        $recordsTotal = $this->db->select("count('ia_custom_fields') AS c")->get('ia_custom_fields')->row()->c;
        $res = SSP::data_output($columns, $res, $j);

        $output_arr['draw'] = intval($_GET['draw']);
        $output_arr['recordsTotal'] = intval($recordsTotal);
        $output_arr['recordsFiltered'] = intval($recordsTotal);
        $output_arr['data'] = $res;

        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][0];
            $arr_keys = array_keys($output_arr['data'][$key]);

            $output_arr['data'][$key][end($arr_keys)] = '';
            $output_arr['data'][$key][end($arr_keys)] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-toggle="modal"  data-target="#custom_fields_modal" data-src="' . $id . '" title="' . lang('edit') . '"><i class="material-icons font-20">mode_edit</i></a>';

            $output_arr['data'][$key][end($arr_keys)] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="' . lang('delete') . '" onclick="setId(' . $id . ', \'setting\')"><i class="material-icons col-red font-20">delete</i></a>';

        }
        echo json_encode($output_arr);
    }

    public function customField()
    {
        if ($this->input->post('id')) {
            $data = array(
                "rel_crud" => $this->input->post('crud_nmae'),
                "name" => $this->input->post('field_name'),
                "type" => $this->input->post('type'),
                "required" => $this->input->post('required'),
                "options" => $this->input->post('options'),
                "status" => $this->input->post('status'),
                "show_in_grid" => $this->input->post('show_in_grid'),
            );
            $old_res = $this->getCustomFieldById($this->input->post('id'));
            if ($this->Setting_model->updateRow('ia_custom_fields', 'ia_custom_fields_id', $this->input->post('id'), $data)) {
                $this->UpdateCustomFieldLang($old_res, $this->input->post('field_name'), $this->input->post('crud_nmae'));
                $this->session->set_flashdata('message', lang('your_data_updated_successfully') . '..');
            }
        } else {
            $data = array(
                "rel_crud" => $this->input->post('crud_nmae'),
                "name" => $this->input->post('field_name'),
                "type" => $this->input->post('type'),
                "required" => $this->input->post('required'),
                "options" => $this->input->post('options'),
                "status" => $this->input->post('status'),
                "show_in_grid" => $this->input->post('show_in_grid'),
            );
            if ($this->Setting_model->insertRow('ia_custom_fields', $data)) {
                $this->setCustomFieldLang($this->input->post('field_name'), $this->input->post('crud_nmae'));
                $art_msg['msg'] = lang('your_data_added_successfully');
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            }
        }
        redirect(base_url() . '/setting#custom-fields');

    }

    public function getModal()
    {
        $data['result'] = getSetting();
        $result = [];
        foreach ($data['result'] as $key => $value) {
            $result[$value->keys] = $value->value;
        }
        $data['result'] = $result;
        if ($this->input->post('id')) {
            $data['data'] = $this->Setting_model->GetDataById($this->input->post('id'));
            echo $this->load->view('setting/add_update', $data, true);
        } else {
            echo $this->load->view('setting/add_update', $data, true);
        }
        exit;
    }

    public function delete($ids)
    {
        $idsArr = explode('-', $ids);
        foreach ($idsArr as $key => $value) {
            $this->Setting_model->deleteData($value);
        }
        echo json_encode($idsArr);
        exit;
    }

    public function switchLang($language = "")
    {
        $language = ($language != "") ? $language : "english";
        $this->Setting_model->updateRow('ia_setting', 'keys', 'language', array('value' => $language));
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function setThemeColorCookie()
    {
        if ($this->input->post('theme_color')) {
            $this->load->helper('cookie');
            $cookie = array(
                'name' => 'theme_color',
                'value' => $this->input->post('theme_color'),
                'expire' => 86400 * 7,
                'path' => '/',
                'secure' => false,
            );
            set_cookie($cookie);

            echo "1";
            exit;
        } else {
            echo "0";
            exit;
        }
    }

    public function setCustomFieldLang()
    {
        $lang_var = '';
        if ($this->input->post('options') != '') {
            $opt = explode(',', $this->input->post('options'));
            foreach ($opt as $key => $value) {
                $lang_var .= '$lang[\'' . getLang($this->input->post('crud_nmae') . '_' . trim($value)) . '\'] = \'' . trim($value) . '\';' . PHP_EOL;
            }
        }
        $lang_var .= '$lang[\'' . getLang(trim($this->input->post('crud_nmae'))) . '_' . getLang(trim($this->input->post('field_name'))) . '\'] = \'' . $this->input->post('field_name') . '\';' . PHP_EOL;
        $Path = realpath(dirname(dirname(dirname(__FILE__)))) . '/application/language/english';
        $g_lang = file_get_contents($Path . '/custom_field_lang.php');
        $lg = $lang_var . '/*ia_custom_variables*/';
        $g_lang = str_replace('/*ia_custom_variables*/', $lg, $g_lang);
        file_put_contents($Path . '/custom_field_lang.php', $g_lang);
    }

    public function getCustomFieldById($id)
    {
        $this->db->select('*');
        $this->db->from('ia_custom_fields');
        $this->db->where('ia_custom_fields_id', $id);
        $query = $this->db->get();
        return $result = $query->row();
    }

    public function UpdateCustomFieldLang($old_result, $field_name, $crud_name)
    {
        $lang_var = '$lang[\'' . getLang(trim($crud_name)) . '_' . getLang(trim($field_name)) . '\'] = \'' . $field_name . '\';';
        $lg = '$lang[\'' . getLang(trim($old_result->rel_crud)) . '_' . getLang(trim($old_result->name)) . '\'] = \'' . $old_result->name . '\';';
        $Path = realpath(dirname(dirname(dirname(dirname(__FILE__))))) . '/language/english';
        $g_lang = file_get_contents($Path . '/custom_field_lang.php');
        $g_lang = str_replace($lg, $lang_var, $g_lang);
        file_put_contents($Path . '/custom_field_lang.php', $g_lang);

        if ($this->input->post('options') != '') {
            $opt = explode(',', $this->input->post('options'));
            $old = explode(',', $old_result->options);
            $lang_var = '';
            $lg = '';
            foreach ($opt as $key => $value) {
                $Path = realpath(dirname(dirname(dirname(dirname(__FILE__))))) . '/language/english';
                $g_lang = file_get_contents($Path . '/custom_field_lang.php');
                $m = '';
                if (isset($old[$key])) {
                    $lg = '$lang[\'' . getLang(trim($this->input->post('crud_nmae'))) . '_' . getLang(trim($old[$key])) . '\'] = \'' . trim($old[$key]) . '\';';
                } else {
                    $lg = '/*ia_custom_variables*/';
                    $m = PHP_EOL . $lg;
                }
                $lang_var = '$lang[\'' . getLang($this->input->post('crud_nmae') . '_' . trim($value)) . '\'] = \'' . trim($value) . '\';' . $m;

                $g_lang = str_replace($lg, $lang_var, $g_lang);
                file_put_contents($Path . '/custom_field_lang.php', $g_lang);
            }
        }
    }

    public function getUpdateInfo()
    {
        $res = 0;
        $this->load->model("Update_model");
        $updateInfo = $this->Update_model->getUpdateInfo();
        $updateInfo = json_decode($updateInfo);
        $current = $this->Update_model->getCurrentDbVersion();
        if (isset($updateInfo->latest_version) && $updateInfo->latest_version > $current) {
            $res = 1;
            $this->session->set_userdata('VersionUpdate', 1);
        }

        echo $res;
        exit;
    }

    public function getCurrentVersion()
    {

        /*if (isset($this->session->get_userdata()['VersionChecking'])) {
        $this->session->unset_userdata('VersionChecking');
        }
        if (isset($this->session->get_userdata()['update_info'])) {
        $this->session->unset_userdata('update_info');
        }

        die;*/
        $res = array();
        if (isset($this->session->get_userdata()['VersionChecking']) && $this->session->get_userdata()['VersionChecking'] == 1) {
            if (isset($this->session->get_userdata()['update_info'])) {
                $res = array('action' => false, 'ia_data' => $this->session->get_userdata()['update_info']);
            } else {
                $res = array('action' => false, 'ia_data' => '0');
            }
        } else {
            $this->session->set_userdata('VersionChecking', 1);
            $this->load->model("Update_model");
            $res = array('action' => true, 'ia_data' => $this->Update_model->getCurrentDbVersion());
        }
        echo json_encode($res);
        exit;
    }

    public function getNotificationHtml()
    { 
        $this->session->set_userdata('update_info', $this->input->post('update_info'));
        $html = '
            <div class="panel bg-white">
                <div class="panel-heading b-light bg-light">
                  <strong> ' . lang('you_have') . ' <span>1</span> ' . lang('notifications') . ' </strong>
                </div>
                <div class="list-group">
                  <a href=" ' . base_url() . 'setting#system-update-setting" class="list-group-item">
                    <span class="clear block m-b-none">
                      ' . $this->input->post('update_info')['latest_version'] . '  ' . lang('initial_released') . '<br>
                    </span>
                  </a>
                </div>
              </div>
        ';
        echo $html;
        exit;
    }

    public function getUpdateHtml()
    {
        $this->load->model("Update_model");
        if (!extension_loaded('curl')) {
            $data['update_errors'][] = lang('CURL_Extension_not_enabled');
            $data['latest_version'] = 0;
            $data['update_info'] = json_decode("");
        } else {
            $data['update_info'] = $this->Update_model->getUpdateInfo();
            if (strpos($data['update_info'], 'Curl Error -') !== false) {
                $data['update_errors'][] = $data['update_info'];
                $data['latest_version'] = 0;
                $data['update_info'] = json_decode("");
                $data['download_url'] = '';
            } else {
                $data['update_info'] = json_decode($data['update_info']);
                $data['latest_version'] = $data['update_info']->latest_version;
                $data['download_url'] = $data['update_info']->download_url;
                $data['update_errors'] = array();
            }
        }

        if (!extension_loaded('zip')) {
            $data['update_errors'][] = lang('ZIP_extension_not_enabled');
        }

        $data['current_version'] = $this->Update_model->getCurrentDbVersion();

        echo $this->load->view('setting/update', $data, true);
        exit;
    }
}
