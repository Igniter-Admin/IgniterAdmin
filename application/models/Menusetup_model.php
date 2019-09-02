<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menusetup_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id) ? $this->session->get_userdata()['user_details'][0]->ia_users_id : '1';
    }

    /**
     * This function is used to Update Record in table
     * @param : $table - table name in which you want to update record
     * @param : $col - field name for where clause
     * @param : $colVal - field value for where clause
     * @param : $data - updated array
     */
    public function updateRow($table, $col, $colVal, $data)
    {
        $this->db->where($col, $colVal);
        $this->db->update($table, $data);
        return true;
    }

    /**
     * This function is used to select data form table
     */
    public function getDataBy($tableName = '', $value = '', $colum = '', $condition = '')
    {   
        if (((!empty($value)) && (!empty($colum))) || $value == "0") {
            $this->db->where($colum, $value);
        }
        $this->db->select('*');
        $this->db->from($tableName);
        $query = $this->db->get();
        return $query->result();
    }
}
