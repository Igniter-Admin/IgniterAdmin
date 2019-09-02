<?php defined("BASEPATH") or exit("No direct script access allowed");

class Templates extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->load->model("Templates_model");
    }

    /**
     * This function is used get html of template page
     */
    public function index()
    {
        $data["view_data"] = $this->Templates_model->getTemplates();
        echo $this->load->view("templates/index", $data, 1);
        exit;
    }

    /**
     * This function is used to add and update templates
     */
    public function addEdit($id = '')
    {
        $data = $this->input->post();
        if ($id = $this->input->post('id')) {
            unset($data['submit']);
            unset($data['fileOld']);
            unset($data['save']);
            unset($data['id']);
            $this->Templates_model->updateRow('ia_email_templates', 'id', $id, $data);
            $art_msg['msg'] = lang('your_data_updated_successfully');
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'setting#templates-setting');
        } else {
            unset($data['submit']);
            unset($data['fileOld']);
            unset($data['save']);
            $insert_id = $this->Templates_model->insertRow('ia_email_templates', $data);
            $art_msg['msg'] = lang('your_data_inserted_successfully');
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'setting#templates-setting');
        }
    }

    /**
     * This function is used to Load add abd update view/html
     */
    public function modalForm()
    {
        if ($this->input->post('id')) {
            $data['data'] = $this->Templates_model->getSpecificTemplate($this->input->post('id'));
            echo $this->load->view('templates/add_update', $data, true);
        } else {
            echo $this->load->view('templates/add_update', '', true);
        }
        exit;
    }

    /**
     * This function is used to Load template datatable view and appear template list in table form
     */
    public function ajaxData()
    {
        $table = 'ia_email_templates';
        $columns = array(
            array('db' => 'template_name', 'dt' => 0),
            array('db' => 'id', 'dt' => 1),
        );
        $joinQuery = '';
        $primaryKey = 'id';
        $this->load->library('Ssp');
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname,
        );

        $output_arr = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns);
        foreach ($output_arr['data'] as $key => $value) {
            $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] = '<a style="cursor:pointer;" class="mClass view_template" title="' . lang('view_template') . '" data-src="' . $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] . '"><i class="material-icons">remove_red_eye</i></a><a id="btnEditRow" class="templateModalButton mClass"  href="javascript:;" type="button" data-src="' . $output_arr['data'][$key][count($output_arr['data'][$key]) - 1] . '" title="' . lang('edit') . '"><i class="material-icons font-20">mode_edit</i></a>';
        }
        echo json_encode($output_arr);
    }

    /**
     * This function is used to preview template
     */
    public function preview()
    {
        $template_row = $this->Templates_model->getSpecificTemplate($this->input->post('template_id'));
        echo $html = $template_row->html;
        exit;
    }
}
