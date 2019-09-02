<?php
defined('BASEPATH') or exit('No direct script access allowed');

@ini_set('memory_limit', '128M');
@ini_set('max_execution_time', 240);

class Auto_update extends CI_Controller
{
    private $tmp_update_dir;
    private $tmp_dir;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Update_model');
    }

    public function index()
    {
        if (isset($this->session->get_userdata()['VersionChecking'])) {
            $this->session->unset_userdata('VersionChecking');
        }
        if (isset($this->session->get_userdata()['update_info'])) {
            $this->session->unset_userdata('update_info');
        }

        $latest_version = $this->input->post('latest_version');
        $download_url = $this->input->post('download_url');
        file_put_contents(FCPATH . "zip/" . $latest_version . ".zip", fopen($download_url, 'r'));
                    
        $zip = new ZipArchive;
        if ($zip->open(FCPATH . "zip/$latest_version.zip") === true) {
            $zip->extractTo(FCPATH);
            $zip->close();
            unlink(FCPATH . "zip/$latest_version.zip");
        }
    }
    public function database()
    {
        $latest_version = $this->input->post('latest_version');
        $db_update = $this->Update_model->upgradeDatabaseSilent($latest_version);
        if ($db_update['success'] == false) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode(array(
                $db_update['message'],
            ));
            die;
        }
        setAlert('success', lang('using_latest_version'));
    }
}
