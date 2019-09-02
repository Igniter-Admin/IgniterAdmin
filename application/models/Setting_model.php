<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Setting_model Class extends CI_Model
 */
class Setting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * This function is used add user type
     */
    public function addUserType()
    {
        $rolesName = isset($_REQUEST['rolesName']) ? $_REQUEST['rolesName'] : '';
        $this->db->where('user_type', $rolesName);
        $result = $this->db->get('ia_permission')->row();
        if (!empty($result)) {
            return 'This User Type(' . $result->user_type . ') is alredy exist, In this Project Please enter Another name';
        } else {
            return $this->insertRow('ia_permission', array('user_type' => $rolesName));
        }
    }

    /**
     * This function is used to insert data in table
     * @param : $table - table name in which you want to insert record
     * @param : $data - data array
     */
    public function insertRow($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * This function is used to update data in specific table
     * @param : $table - table name in which you want to update record
     * @param : $col - field name for where clause
     * @param : $colVal - field value for where clause
     * @param : $data - data array
     */
    public function updateRow($table, $col, $colVal, $data)
    {
        $this->db->where($col, $colVal);
        $this->db->update($table, $data);
        return true;
    }

    /**
     * This function is get table data by id
     * @param : $id is value of project_id
     */
    public function GetDataById($id = '')
    {
        $this->db->select('*');
        $this->db->from('ia_custom_fields');
        $this->db->where('ia_custom_fields_id', $id);
        $query = $this->db->get();
        return $result = $query->row();
    }

    /**
     * This function is used to delete record from table
     * @param : $id record id which you want to delete
     */
    public function deleteData($id = '')
    {
        $this->db->where('ia_custom_fields_id', $id);
        $this->db->delete('ia_custom_fields');
    }

    /**
     * This function is used to get admin setting data
     */
    public function getAdminPermissions()
    {
        return $this->db->where('user_type', 'admin')->get('ia_permission')->row();
    }

    /**
     * This function is used to delete record from any table
     * @param : $table table name from which you want to delete record
     * @param : $col = column for where condition
     * @param : $col_val = column value for where condition
     */
    public function delete($table, $col, $col_val)
    {
        $this->db->where($col, $col_val);
        $this->db->delete($table);
    }
}
