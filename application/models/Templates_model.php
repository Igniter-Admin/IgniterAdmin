<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * templates_model Class extends CI_Model
 */
class Templates_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * This function is used to get specific by id template record from database
     * @param: $id - it is id of template
     */
    public function getSpecificTemplate($id = '')
    {
        $this->db->select('*');
        $this->db->from('ia_email_templates');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $result = $query->row();
    }

    /**
     * This function is used to get all record from templates table
     */
    public function getTemplates()
    {
        $this->db->select('*');
        $this->db->from('ia_email_templates');
        $query = $this->db->get();
        return $result = $query->result();
    }

    /**
     * This function is used to insert row in table
     * @param: $table - table name in which you want to insert record
     * @param: $data - data array
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
}
