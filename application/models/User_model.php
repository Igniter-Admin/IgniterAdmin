<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id) ? $this->session->get_userdata()['user_details'][0]->ia_users_id : '1';
    }

    /**
     * This function is used authenticate user at login
     */
    public function authUser()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $this->db->where("is_deleted='0' AND (name='$email' OR email='$email')");
        $result = $this->db->get('ia_users')->result();
        if (!empty($result)) {
            if (password_verify($password, $result[0]->password)) {
                // if ($result[0]->status != 'active') {
                //     return 'not_varified';
                // }
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * This function is used to delete user
     * @param: $id - id of user table
     */
    public function delete($id = '')
    {
        $this->db->where('ia_users_id', $id);
        $this->db->delete('ia_users');
    }

    /**
     * This function is used to load view of reset password and varify user too
     */
    public function mailVerify()
    {
        $ucode = $this->input->get('code');
        $this->db->select('email as e_mail');
        $this->db->from('ia_users');
        $this->db->where('var_key', $ucode);
        $query = $this->db->get();
        $result = $query->row();
        if (!empty($result->e_mail)) {
            return $result->e_mail;
        } else {
            return false;
        }
    }

    /**
     * This function is used Reset password
     */
    public function ResetPpassword()
    {
        $email = $this->input->post('email');
        if ($this->input->post('password_confirmation') == $this->input->post('password')) {
            $npass = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $data['password'] = $npass;
            $data['var_key'] = '';
            return $this->db->update('ia_users', $data, "email = '$email'");
        }
    }

    /**
     * This function is used to select data form table
     */
    public function getDataBy($tableName = '', $value = '', $colum = '', $condition = '')
    {
        if ((!empty($value)) && (!empty($colum))) {
            $this->db->where($colum, $value);
        }
        $this->db->select('*');
        $this->db->from($tableName);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * This function is used to check user is alredy exist or not
     */
    public function checkExists($table = '', $colom = '', $colomValue = '', $id = '', $id_CheckCol = '')
    {
        $this->db->where($colom, $colomValue);
        if (!empty($id) && !empty($id_CheckCol)) {
            $this->db->where($id_CheckCol . ' !=', $id);
        }
        $res = $this->db->get($table)->row();
        if (!empty($res)) {return false;} else {return true;}
    }

    /**
     * This function is used to get users detail
     */
    public function getUsers($userID = '')
    {
        $this->db->where('is_deleted', '0');
        if (isset($userID) && $userID != '') {
            $this->db->where('ia_users_id', $userID);
        } else if ($this->session->userdata('user_details')[0]->user_type == 'admin') {
            $this->db->where('user_type', 'admin');
        } else {
            $this->db->where('ia_users.ia_users_id !=', '1');
        }
        $result = $this->db->get('ia_users')->result();
        return $result;
    }

    /**
     * This function is used to get email template
     */
    public function getTemplate($code)
    {
        $this->db->where('code', $code);
        return $this->db->get('ia_email_templates')->row();
    }

    /**
     * This function is used to Insert record in table
     */
    public function insertRow($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * This function is used to Update record in table
     */
    public function updateRow($table, $col, $colVal, $data)
    {
        $this->db->where($col, $colVal);
        $this->db->update($table, $data);
        return true;
    }

/*      public function get_list_box_data($qr) {
$exe = $this->db->query($qr);
return $exe->result();
}
 */
    public function getQrResult($qr)
    {
        // echo"<pre>"; print_r($qr); die;
        $exe = $this->db->query($qr);
        return $exe->result();
    }

    public function getBarChartData($qr)
    {
        $exe = $this->db->query($qr);
        $res = $exe->result();
        $result = [];
        $i = 1;
        while ($i <= 12) {
            $result[$i] = 0;
            foreach ($res as $key => $value) {
                if ($value->months == $i) {
                    //$result[$i] += $value->mka_sum;
                    $result[$i] += (int) str_replace(',', '', $value->mka_sum);
                }
            }
            $i++;
        }
        return implode(',', $result);
    }

    public function registrationMailVerify()
    {
        $ucode = $this->input->get('code');
        if ($ucode == '') {
            return false;
        }
        $this->db->select('email as e_mail');
        $this->db->from('ia_users');
        $this->db->where('var_key', $ucode);
        $query = $this->db->get();
        $result = $query->row();
        if (!empty($result->e_mail)) {
            $data['var_key'] = '';
            $data['status'] = 'active';
            if (getSetting('admin_approval') == 1) {
                $data['status'] = 'varified';
            }
            $this->db->update('ia_users', $data, "email = '$result->e_mail'");
            return $result->e_mail;
        } else {
            return false;
        }
    }
}
