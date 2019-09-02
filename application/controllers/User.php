<?php
defined('BASEPATH') or exit('No direct script access allowed ');
class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id) ? $this->session->get_userdata()['user_details'][0]->ia_users_id : '1';
        $this->lang->load('user', getSetting('language'));
    }

    /**
     * This function is redirect to users profile page
     * @return Void
     */
    public function index()
    {
        if (isLogin()) {
            redirect(base_url() . 'dashboard', 'refresh');
        }
    }

    /**
     * This function to load dashboard
     * @return Void
     */
    public function dashboard()
    {
        isLogin();

        $data[] = '';

        $qr = " SELECT count(*) AS `ia` FROM `ia_users`   ";
        $data['Total_Users_data'] = $this->User_model->getQrResult($qr);

        $qr = " SELECT count(*) AS `ia` FROM `ia_users`   ";
        $data['Today_Registered_data'] = $this->User_model->getQrResult($qr);

        $qr = " SELECT count(*) AS `ia` FROM `ia_users`   WHERE  `ia_users`.`status` = 'active' ";
        $data['Active_Users_data'] = $this->User_model->getQrResult($qr);

        $query = "SELECT MONTH(`create_date`) as `months`, '1' AS `mka_sum` FROM  `ia_users`  WHERE YEAR(`create_date`) = '" . date("Y") . "'  ";
        $data['Bar_1'] = $this->User_model->getBarChartData($query);
        $query = "SELECT * FROM  `ia_users`   WHERE  `ia_users`.`user_type` != 'admin' ORDER BY `ia_users_id` DESC LIMIT 10 ";
        $data['last_10_registration_list'] = $this->User_model->getQrResult($query);
        $this->load->view('include/header');
        $this->load->view('dashboard', $data);
        $this->load->view('include/footer');
    }

    /**
     * This function is used to load login view page
     * @return Void
     */
    public function login()
    {
        if (isset($_SESSION['user_details'])) {
            redirect(base_url() . 'dashboard', 'refresh');
        }
        $this->load->view('login');
    }

    /**
     * This function is used to logout user
     * @return Void
     */
    public function logout()
    {
        isLogin();
        $this->session->unset_userdata('user_details');
        redirect(base_url() . 'login', 'refresh');
    }

    /**
     * This function is used to registr user
     * @return Void
     */
    public function registration()
    {
        if (isset($_SESSION['user_details'])) {
            redirect(base_url() . 'profile', 'refresh');
        }
        //Check if admin allow to registration for user
        if (getSetting('register_allowed') == 1) {
            if ($this->input->post()) {
                $this->addEdit();
                $art_msg['msg'] = lang('successfully_registered');
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
            } else {
                $this->load->view('register');
            }
        } else {
            $art_msg['msg'] = lang('registration_not_allowed');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'login', 'refresh');
        }
    }

    /**
     * This function is used for user authentication ( Working in login process )
     * @return Void
     */
    public function authUser($page = '')
    {
        $return = $this->User_model->authUser();
        if (empty($return)) {
            $art_msg['msg'] = lang('invalid_details');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'login', 'refresh');
        } else {
            if ($return == 'not_varified') {
                $art_msg['msg'] = lang('this_account_is_not_verified_please_contact_to_your_admin');
                $art_msg['type'] = 'danger';
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect(base_url() . 'login', 'refresh');
            } else {
                $this->session->set_userdata('user_details', $return);
            }
            redirect(base_url() . 'dashboard', 'refresh');
        }
    }

    /**
     * This function is used send mail in forget password
     * @return Void
     */
    public function forgetPassword()
    {
        $page['title'] = lang('forgot_password');
        if ($this->input->post()) {
            $setting = settings();
            $res = $this->User_model->getDataBy('ia_users', $this->input->post('email'), 'email', 1);
            if (isset($res[0]->ia_users_id) && $res[0]->ia_users_id != '') {
                $var_key = $this->getVerificationCode();
                $this->User_model->updateRow('ia_users', 'ia_users_id', $res[0]->ia_users_id, array('var_key' => $var_key));
                $sub = "Reset password";
                $email = $this->input->post('email');
                $data = array(
                    'user_name' => $res[0]->name,
                    'action_url' => base_url(),
                    'sender_name' => $setting['company_name'],
                    'website_name' => $setting['website'],
                    'varification_link' => base_url() . 'user/mailVerify?code=' . $var_key,
                    'url_link' => base_url() . 'user/mailVerify?code=' . $var_key,
                );
                $body = $this->User_model->getTemplate('forgot_password');
                $body = $body->html;
                foreach ($data as $key => $value) {
                    $body = str_replace('{var_' . $key . '}', $value, $body);
                }
                if ($setting['mail_setting'] == 'php_mailer') {
                    $this->load->library("send_mail");
                    $emm = $this->send_mail->email($sub, $body, $email, $setting);
                } else {
                    // content-type is required when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: ' . $setting['EMAIL'] . "\r\n";
                    $emm = mail($email, $sub, $body, $headers);
                }
                if ($emm) {
                    $art_msg['msg'] = lang('to_reset_your_password_link_has_been_sent_to_your_email');
                    $art_msg['type'] = 'info';
                    $this->session->set_userdata('alert_msg', $art_msg);
                    redirect(base_url() . 'login', 'refresh');
                }
            } else {
                $art_msg['msg'] = lang('this_account_does_not_exist');
                $art_msg['type'] = 'danger';
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect(base_url() . "forgot_password");
            }
        } else {
            $this->load->view('forget_password');
        }
    }

    /**
     * This function is used to load view of reset password and varify user too
     * @return : void
     */
    public function mailVerify()
    {
        $return = $this->User_model->mailVerify();
        if ($return) {
            $data['email'] = $return;
            $this->load->view('set_password', $data);
        } else {
            $data['email'] = 'allredyUsed';
            $this->load->view('set_password', $data);
        }
    }

    /**
     * This function is used to reset password in forget password process
     * @return : void
     */
    public function reset_password()
    {
        $return = $this->User_model->ResetPpassword();
        if ($return) {
            $art_msg['msg'] = lang('password_changed_successfully');
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'login', 'refresh');
        } else {
            $art_msg['msg'] = lang('unable_to_update_password');
            $art_msg['type'] = 'danger';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'login', 'refresh');
        }
    }

    /**
     * This function is generate hash code for random string
     * @return string
     */
    public function getVerificationCode()
    {
        $pw = $this->randomString();
        return $varificat_key = password_hash($pw, PASSWORD_DEFAULT);
    }

    /**
     * This function is used for show users list
     * @return Void
     */
    public function userlist()
    { 
        isLogin();
        if (CheckPermission("user", "own_read") || CheckPermission("user", "all_read")) {
            $cf = getCustomField('user');
            $qr1 = 'SELECT SQL_CALC_FOUND_ROWS ia_users.ia_users_id AS ia_users_id, ia_users.name AS name, ia_users.email AS email, ia_users.user_type AS user_type';
            $joinQuery = "FROM `ia_users` ";

            if (is_array($cf) && !empty($cf)) {
                foreach ($cf as $cfkey => $cfvalue) {
                    $qr1 .= ", ia_custom_fields_values_" . $cfkey . ".value AS cfv_" . $cfkey;
                    $joinQuery .= " LEFT JOIN `ia_custom_fields_values` AS ia_custom_fields_values_" . $cfkey . "  ON  `ia_users`.`ia_users_id` = `ia_custom_fields_values_" . $cfkey . "`.`rel_crud_id` AND `ia_custom_fields_values_" . $cfkey . "`.`cf_id` =  '" . $cfvalue->ia_custom_fields_id . "' ";;
                }
            }
            $where = ' WHERE ';
            if (CheckPermission("user", "all_read") || $this->session->get_userdata()['user_details'][0]->user_type == 'admin') {
                $where .= "  `ia_users`.`user_type` != 'admin' AND `ia_users`.`ia_users_id` != $this->user_id";
            } else {
                $where .= "  `ia_users`.`user_type` != 'admin' AND `ia_users`.`user_id` = $this->user_id";
            }
            $qr = $qr1 . " " . $joinQuery . " " . $where ;
            $res = $this->db->query($qr);
            $output_arr['result'] = $res->result_array();;
        
            $this->load->view('include/header');
            $this->load->view('user_table', $output_arr);
            $this->load->view('include/footer');
        } else {
            $art_msg['msg'] = lang('you_do_not_have_permission_to_access');
            $art_msg['type'] = 'danger';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'profile', 'refresh');
        }
    }

    /**
     * This function is used to create datatable in users list page
     * @return Void
     */

    public function userTable()
    {
        isLogin();
        $table = 'ia_users';
        $primaryKey = 'ia_users_id';
        $columns = array(
            array('db' => 'ia_users.ia_users_id AS ia_users_id', 'field' => 'ia_users_id', 'dt' => 0),
            array('db' => 'ia_users.name AS name', 'field' => 'name', 'dt' => 1),
            array('db' => 'ia_users.email AS email', 'field' => 'email', 'dt' => 2),
            array('db' => 'ia_users.user_type AS user_type', 'field' => 'user_type', 'dt' => 3),

        );

        $joinQuery = "FROM `" . $table . "` ";
        $cf = getCustomField('user');
        if (is_array($cf) && !empty($cf)) {
            foreach ($cf as $cfkey => $cfvalue) {
                array_push($columns, array('db' => "ia_custom_fields_values_" . $cfkey . ".value AS cfv_" . $cfkey, 'field' => "cfv_" . $cfkey, 'dt' => count($columns)));
                $joinQuery .= " LEFT JOIN `ia_custom_fields_values` AS ia_custom_fields_values_" . $cfkey . "  ON  `ia_users`.`ia_users_id` = `ia_custom_fields_values_" . $cfkey . "`.`rel_crud_id` AND `ia_custom_fields_values_" . $cfkey . "`.`cf_id` =  '" . $cfvalue->ia_custom_fields_id . "' ";
            }
        }
        array_push($columns, array('db' => 'ia_users.ia_users_id AS ia_users_id', 'field' => 'ia_users_id', 'dt' => count($columns)));

        $j = 0;
        if (strpos($joinQuery, 'JOIN') > 0) {
            $j = 1;
        }
        $where = SSP::iaFilter($_GET, $columns, $j);
        if ($where == '') {
            $where .= ' WHERE ';
        } else {
            $where .= ' AND ';
        }
        if (CheckPermission("user", "all_read") || $this->session->get_userdata()['user_details'][0]->user_type == 'admin') {
            $where .= "  `ia_users`.`user_type` != 'admin' AND `ia_users`.`ia_users_id` != $this->user_id";
        } else {
            $where .= "  `ia_users`.`user_type` != 'admin' AND `ia_users`.`user_id` = $this->user_id";
        }

        $limit = SSP::limit($_GET, $columns);
        $order = SSP::iaOrder($_GET, $columns, $j);
        if (trim($order) == 'ORDER BY') {
            $order = '';
        }
        $col = SSP::pluck($columns, 'db', $j);

        $query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $col) . " " . $joinQuery . " " . $where . " " . $order . " " . $limit . " ";
        
        $res = $this->db->query($query);
        $res = $res->result_array();
        $recordsTotal = $this->db->select("count('ia_users_id') AS c")->get('ia_users')->row()->c;
        $res = SSP::iaDataOutput($columns, $res, $j);

        $output_arr['draw'] = intval($_GET['draw']);
        $output_arr['recordsTotal'] = intval($recordsTotal);
        $output_arr['recordsFiltered'] = intval($recordsTotal);
        $output_arr['data'] = $res;
        foreach ($output_arr['data'] as $key => $value) {
            $id = $output_arr['data'][$key][count($output_arr['data'][$key]) - 1];
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] = '';
            if (CheckPermission('user', "all_update")) {
                $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="Edit"><i class="material-icons font-20">mode_edit</i></a>';
            } else if (CheckPermission('user', "own_update") && (CheckPermission('user', "all_update") != true)) {
                $user_id = getRowByTableColomId($table, $id, 'ia_users_id', 'user_id');
                if ($user_id == $this->user_id) {
                    $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a id="btnEditRow" class="modalButtonUser mClass"  href="javascript:;" type="button" data-src="' . $id . '" title="Edit"><i class="material-icons font-20">mode_edit</i></a>';
                }
            }

            if (CheckPermission('user', "all_delete")) {
                $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(' . $id . ', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="material-icons col-red font-20">delete</i></a>';} else if (CheckPermission('user', "own_delete") && (CheckPermission('user', "all_delete") != true)) {
                $user_id = getRowByTableColomId($table, $id, 'ia_users_id', 'user_id');
                if ($user_id == $this->user_id) {
                    $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] .= '<a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(' . $id . ', \'user\')" data-target="#cnfrm_delete" title="delete"><i class="material-icons col-red font-20">delete</i></a>';
                }
            }

            $output_arr['data'][$key][0] = '<input type="checkbox" id="basic_checkbox_' . $key . '" name="selData" value="' . $output_arr['data'][$key][0] . '"><label for="basic_checkbox_' . $key . '"></label>';
        }
        echo json_encode($output_arr);
    }

    /**
     * This function is Showing users profile
     * @return Void
     */
    public function profile($id = '')
    {
        isLogin();
        if (!isset($id) || $id == '') {
            $id = $this->session->userdata('user_details')[0]->ia_users_id;
        }
        $data['user_data'] = $this->User_model->getUsers($id);
        $this->load->view('include/header');
        $this->load->view('profile', $data);
        $this->load->view('include/footer');
    }

    /**
     * This function is used to show popup of user to add and update
     * @return Void
     */
    public function getModal()
    {
        isLogin();
        if ($this->input->post('id')) {
            $data['userData'] = getDataByid('ia_users', $this->input->post('id'), 'ia_users_id');
            echo $this->load->view('add_user', $data, true);
        } else {
            echo $this->load->view('add_user', '', true);
        }
        exit;
    }

    /**
     * This function is used to add and update users
     * @return Void
     */
    public function addEdit($id = '')
    {
        $data = $this->input->post();
        $profile_pic = 'user.png';
        if ($this->input->post('ia_users_id')) {
            $id = $this->input->post('ia_users_id');
        }
        if (isset($this->session->userdata('user_details')[0]->ia_users_id)) {
            if ($this->input->post('ia_users_id') == $this->session->userdata('user_details')[0]->ia_users_id) {
                $redirect = 'profile';
                $setSession = true;
            } else {
                $redirect = 'user/userlist';
                $setSession = false;
            }
        } else {
            $redirect = 'login';
        }
        if ($this->input->post('fileOld')) {
            $newname = $this->input->post('fileOld');
            $profile_pic = $newname;
        } else {
            $profile_pic = 'user.png';
        }
        foreach ($_FILES as $name => $fileInfo) {
            if (!empty($_FILES[$name]['name'])) {
                if ($newname = upload($name)) {
                    $data[$name] = $newname;
                    $profile_pic = $newname;
                }
            } else {
                if ($this->input->post('fileOld')) {
                    $newname = $this->input->post('fileOld');
                    $data[$name] = $newname;
                    $profile_pic = $newname;
                } else {
                    $data[$name] = '';
                    $profile_pic = 'user.png';
                }
            }
        }
        if ($id != '') {
            $data = $this->input->post();
            if ($this->input->post('status') != '') {
                $data['status'] = $this->input->post('status');
            }
            if ($this->input->post('ia_users_id') == 1) {
                $data['user_type'] = 'admin';
                $data['status'] = 'active';
            }
            $checkValue = $this->User_model->checkExists('ia_users', 'email', $this->input->post('email'), $id, 'ia_users_id');
            if ($checkValue == false) {
                $art_msg['msg'] = lang('this_email_already_registered_with_us');
                $art_msg['type'] = 'info';
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect(base_url() . 'user/userlist', 'refresh');
            }

            if ($this->input->post('password') != '') {
                if ($this->input->post('currentpassword') != '') {
                    $old_row = getDataByid('ia_users', $this->input->post('ia_users_id'), 'ia_users_id');
                    if (password_verify($this->input->post('currentpassword'), $old_row->password)) {
                        if ($this->input->post('password') == $this->input->post('confirmPassword')) {
                            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                            $data['password'] = $password;
                        } else {
                            $art_msg['msg'] = lang('password_and_confirm_password_should_be_same');
                            $art_msg['type'] = 'warning';
                            $this->session->set_userdata('alert_msg', $art_msg);
                            redirect(base_url() . $redirect, 'refresh');
                        }
                    } else {
                        $art_msg['msg'] = lang('enter_valid_current_password');
                        $art_msg['type'] = 'warning';
                        $this->session->set_userdata('alert_msg', $art_msg);
                        redirect(base_url() . $redirect, 'refresh');
                    }
                } else {
                    $art_msg['msg'] = lang('current_password_is_required');
                    $art_msg['type'] = 'warning';
                    $this->session->set_userdata('alert_msg', $art_msg);
                    redirect(base_url() . $redirect, 'refresh');
                }
            }
            $id = $this->input->post('ia_users_id');
            unset($data['fileOld']);
            unset($data['currentpassword']);
            unset($data['confirmPassword']);
            unset($data['ia_users_id']);
            if (isset($data['edit'])) {
                unset($data['edit']);
            }
            if (isset($data['password']) && $data['password'] == '') {
                unset($data['password']);
            }
            if (isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
                if (!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                        $qr = "SELECT * FROM `ia_custom_fields_values` WHERE `rel_crud_id` = '" . $id . "' AND `cf_id` = '" . $cfkey . "'";
                        $cf_data = $this->User_model->getQrResult($qr);
                        if (is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                "value" => $custom_fields[$cf_data[0]->cf_id],
                            );
                            $this->User_model->updateRow('ia_custom_fields_values', 'ia_custom_fields_values_id', $cf_data[0]->ia_custom_fields_values_id, $d);
                        } else {
                            $d = array(
                                "rel_crud_id" => $id,
                                "cf_id" => $cfkey,
                                "curd" => 'user',
                                "value" => $cfvalue,
                            );
                            $this->User_model->insertRow('ia_custom_fields_values', $d);
                        }
                    }
                }
            }
            $data['profile_pic'] = $profile_pic;
            foreach ($data as $dkey => $dvalue) {
                if (is_array($dvalue)) {
                    $data[$dkey] = implode(',', $dvalue);
                }
            }
            $this->User_model->updateRow('ia_users', 'ia_users_id', $id, $data);
            $new_data = $this->User_model->getDataBy('ia_users', $id, 'ia_users_id');
            if (isset($setSession) && $setSession == true) {
                $this->session->set_userdata('user_details', $new_data);
            }

            $art_msg['msg'] = lang('your_data_updated_successfully');
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . $redirect, 'refresh');
        } else {
            if ($this->input->post('user_type') != 'admin') {
                $data = $this->input->post();
                $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                $checkValue = $this->User_model->checkExists('ia_users', 'email', $this->input->post('email'));
                if ($checkValue == false) {
                    $art_msg['msg'] = lang('this_email_already_registered_with_us');
                    $art_msg['type'] = 'warning';
                    $this->session->set_userdata('alert_msg', $art_msg);
                    redirect(base_url() . 'user/userlist', 'refresh');
                }

                $data['status'] = 'active';
                if (getSetting('admin_approval') == 1) {
                    $data['status'] = 'pending';
                }

                if ($this->input->post('status') != '') {
                    $data['status'] = $this->input->post('status');
                }

                $data['user_id'] = $this->user_id;
                $data['password'] = $password;
                $data['profile_pic'] = $profile_pic;
                $data['is_deleted'] = 0;
                $data['create_date'] = date('Y-m-d');
                if (isset($data['password_confirmation'])) {
                    unset($data['password_confirmation']);
                }
                if (isset($data['call_from'])) {
                    unset($data['call_from']);
                }
                unset($data['submit']);
                $custom_fields = array();
                if (isset($data['mkacf'])) {
                    $custom_fields = $data['mkacf'];
                    unset($data['mkacf']);
                }

                foreach ($data as $dkey => $dvalue) {
                    if (is_array($dvalue)) {
                        $data[$dkey] = implode(',', $dvalue);
                    }
                }
                if ($redirect == 'login') {
                    $data['status'] = 'pending';
                    $var_key = $this->getVerificationCode();
                    $data['var_key'] = $var_key;
                }
                $last_id = $this->User_model->insertRow('ia_users', $data);
                if (!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                        $d = array(
                            "rel_crud_id" => $last_id,
                            "cf_id" => $cfkey,
                            "curd" => 'user',
                            "value" => $cfvalue,
                        );
                        $this->User_model->insertRow('ia_custom_fields_values', $d);
                    }
                }
                if ($redirect == 'login') {
                    $this->registerMail($data);
                }
                redirect(base_url() . $redirect, 'refresh');
            } else {
                $art_msg['msg'] = lang('you_do_not_have_permission_to_access');
                $art_msg['type'] = 'danger';
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect(base_url() . 'user/registration', 'refresh');
            }
        }

    }

    /**
     * This function is used to send verification mail for registeration of ia_users
     * @return Void
     */

    public function registerMail($data1)
    {
        $setting = settings();
        $res = $this->User_model->getDataBy('ia_users', $data1['email'], 'email', 1);
        if (isset($res[0]->ia_users_id) && $res[0]->ia_users_id != '') {
            $sub = "Varify your account";
            $email = $data1['email'];

            $data = array(
                'user_name' => $res[0]->name,
                'varification_link' => base_url() . 'user/registrationMailVerify?code=' . $data1['var_key'],
                'website_name' => $setting['website'],
            );
            $body = $this->User_model->getTemplate('registration');
            $body = $body->html;
            foreach ($data as $key => $value) {
                $body = str_replace('{var_' . $key . '}', $value, $body);
            }

            if ($setting['mail_setting'] == 'php_mailer') {
                $this->load->library("send_mail");
                $emm = $this->send_mail->email($sub, $body, $email, $setting);
            } else {
                // content-type is required when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: ' . $setting['EMAIL'] . "\r\n";
                $emm = mail($email, $sub, $body, $headers);
            }
            if ($emm) {
                $art_msg['msg'] = lang('successfully_registered_check_your_mail_for_varification');
                $art_msg['type'] = 'success';
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect(base_url() . 'login', 'refresh');
            }
        }

    }

    public function registrationMailVerify()
    {
        $return = $this->User_model->registrationMailVerify();
        if ($return) {
            $art_msg['msg'] = lang('successfully_verified') . '!';
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'login', 'refresh');
        } else {
            $art_msg['msg'] = lang('invalid_link');
            $art_msg['type'] = 'danger';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'user/registration', 'refresh');
        }
    }

    /**
     * This function is used to delete users
     * @return Void
     */
    public function delete($id)
    {
        isLogin();
        $ids = explode('-', $id);
        foreach ($ids as $id) {
            $this->User_model->delete($id);
        }
        redirect(base_url() . 'user/userlist', 'refresh');
    }

    /**
     * This function is used to send invitation mail to users for registration
     * @return Void
     */
    public function InvitePeople()
    {
        isLogin();
        if ($this->input->post('emails')) {
            $setting = settings();
            $var_key = $this->randomString();
            $emailArray = explode(',', $this->input->post('emails'));
            $emailArray = array_map('trim', $emailArray);
            $body = $this->User_model->getTemplate('invitation');
            $result['existCount'] = 0;
            $result['seccessCount'] = 0;
            $result['invalidEmailCount'] = 0;
            $result['noTemplate'] = 0;
            if (isset($body->html) && $body->html != '') {
                $body = $body->html;
                foreach ($emailArray as $mailKey => $mailValue) {
                    if (filter_var($mailValue, FILTER_VALIDATE_EMAIL)) {
                        $res = $this->User_model->getDataBy('ia_users', $mailValue, 'email');
                        if (is_array($res) && empty($res)) {
                            $link = (string) '<a href="' . base_url() . 'user/registration?invited=' . $var_key . '">Click here</a>';
                            $data = array('var_user_email' => $mailValue, 'var_inviation_link' => $link);
                            foreach ($data as $key => $value) {
                                $body = str_replace('{' . $key . '}', $value, $body);
                            }
                            if ($setting['mail_setting'] == 'php_mailer') {
                                $this->load->library("send_mail");
                                $emm = $this->send_mail->email('Invitation for registration', $body, $mailValue, $setting);
                            } else {
                                // content-type is required when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: ' . $setting['EMAIL'] . "\r\n";
                                $emm = mail($mailValue, 'Invitation for registration', $body, $headers);
                            }
                            if ($emm) {
                                $darr = array('email' => $mailValue, 'var_key' => $var_key);
                                $this->User_model->insertRow('ia_users', $darr);
                                $result['seccessCount'] += 1;
                            }
                        } else {
                            $result['existCount'] += 1;
                        }
                    } else {
                        $result['invalidEmailCount'] += 1;
                    }
                }
            } else {
                $result['noTemplate'] = lang('no_email_template_availabale') . '.';
            }
        }
        echo json_encode($result);
        exit;
    }

    /**
     * This function is used to Check invitation code for user registration
     * @return TRUE/FALSE
     */
    public function chekInvitation()
    {
        if ($this->input->post('code') && $this->input->post('code') != '') {
            $res = $this->User_model->getDataBy('ia_users', $this->input->post('code'), 'var_key');
            $result = array();
            if (is_array($res) && !empty($res)) {
                $result['email'] = $res[0]->email;
                $result['ia_users_id'] = $res[0]->ia_users_id;
                $result['result'] = 'success';
            } else {
                $art_msg['msg'] = lang('this_code_is_not_valid');
                $art_msg['type'] = 'warning';
                $this->session->set_userdata('alert_msg', $art_msg);
                $result['result'] = 'error';
            }
        }
        echo json_encode($result);
        exit;
    }

    /**
     * This function is used to registr invited user
     * @return Void
     */
    public function registerInvited($id)
    {
        $data = $this->input->post();
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['password'] = $password;
        $data['var_key'] = null;
        $data['is_deleted'] = 0;
        $data['status'] = 'active';
        $data['user_id'] = 1;
        if (isset($data['password_confirmation'])) {
            unset($data['password_confirmation']);
        }
        if (isset($data['call_from'])) {
            unset($data['call_from']);
        }
        if (isset($data['submit'])) {
            unset($data['submit']);
        }
        $custom_fields = array();
        if (isset($data['mkacf'])) {
            $custom_fields = $data['mkacf'];
            unset($data['mkacf']);
        }
        $this->User_model->updateRow('ia_users', 'ia_users_id', $id, $data);
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $cfkey => $cfvalue) {
                $d = array(
                    "rel_crud_id" => $id,
                    "cf_id" => $cfkey,
                    "curd" => 'user',
                    "value" => $cfvalue,
                );
                $this->User_model->insertRow('ia_custom_fields_values', $d);
            }
        }
        $art_msg['msg'] = lang('successfully_registered');
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'login', 'refresh');
    }

    /**
     * This function is used to check email is alredy exist or not
     * @return TRUE/FALSE
     */
    public function checEmailExist()
    {
        $result = 1;
        $res = $this->User_model->getDataBy('ia_users', $this->input->post('email'), 'email');
        if (!empty($res)) {
            if ($res[0]->ia_users_id != $this->input->post('uId')) {
                $result = 0;
            }
        }
        echo $result;
        exit;
    }

    /**
     * This function is used to Generate a random string
     * @return String
     */
    public function randomString()
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = $alpha . $alpha_upper . $numeric;
        $pw = '';
        $chars = str_shuffle($chars);
        $pw = substr($chars, 8, 8);
        return $pw;
    }

}
