<?php defined('BASEPATH') or exit('No direct script access allowed');

class Plugins_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->ia_users_id) ? $this->session->get_userdata()['user_details'][0]->ia_users_id : '1';
    }

    /**
     * This function is used to Insert Record in table
     * @param : $table - table name in which you want to insert record
     * @param : $data - record array
     */
    public function insertRow($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
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
        if ((!empty($value)) && (!empty($colum))) {
            $this->db->where($colum, $value);
        }
        $this->db->select('*');
        $this->db->from($tableName);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDataByLast($tableName)
    {
        $query = $this->db->query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");
        return $query->result();
    }

    public function getDataBySort()
    {
        $query = $this->db->query("SELECT MAX(sorting) as sorting_id FROM ia_menu where parent_id = 0");
        return $query->result();
    }

    public function deleteExtnDbAction($data)
    {
        /*----------  Remove From Menu  ----------*/
        $this->db->where('module_name', $data->name)->delete('ia_menu');

        /*----------  Remove Permissions  ----------*/
        $per = $this->getDataBy('ia_permission');
        if (is_array($per) && !empty($per)) {
            foreach ($per as $perkey => $pervalue) {
                $rec = json_decode($pervalue->data, 1);
                unset($rec[$data->name]);
                $perdata = array("data" => json_encode($rec));
                $this->em->updateRow('ia_permission', 'id', $pervalue->id, $perdata);
            }
        }

        /*----------  Remove table of module  ----------*/
        $this->load->dbforge();
        $tbls = explode(',', $data->db_tables);
        foreach ($tbls as $key => $value) {
            $this->dbforge->drop_table($value, true);
        }

        /*----------  Remove Dependencies  ----------*/
        if (isset($data->rm_queries) && $data->rm_queries != '') {
            $qry = explode(';', $data->rm_queries);
            foreach ($qry as $key => $value) {
                $this->db->query($value);
            }
        }

        /*----------  Remove Record from extension table  ----------*/
        $this->db->where('name', $data->name)->delete('ia_plugins');

        return true;
    }

}
