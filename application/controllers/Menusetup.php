<?php
defined('BASEPATH') or exit('No direct script access allowed ');
class Menusetup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->lang->load('menusetup', getSetting('language'));
        $this->load->model('Menusetup_model');
    }

    public function index()
    {
        $menus = $this->Menusetup_model->getDataBy("ia_menu", "0", "parent_id");
        $menuarray = [];
        foreach ($menus as $key => $value) {
            /*to pass full values
                $menuarray[] = array("href"=>"","icon"=>"","text"=>ucwords(str_replace('_', ' ', $value->menu_name)), "target"=> "_top", "title"=> "");
            */
            $menuarray[$value->sorting - 1] = array("id"=>$value->id,"text"=>ucwords(str_replace('_', ' ', $value->menu_name)));
            $childs = $this->Menusetup_model->getDataBy("ia_menu", $value->id, "parent_id");
            if (!empty($childs)) {
                foreach ($childs as $ch_key => $ch_value) {
                    $menuarray[$value->sorting - 1]['children'][$ch_value->sorting - 1] = array("id"=>$ch_value->id,"text"=>ucwords(str_replace('_', ' ', $ch_value->menu_name)));
                }
                ksort($menuarray[$value->sorting - 1]['children']);        
            }
        }
        ksort($menuarray);
        $data['menuarray'] = json_encode($menuarray);
    	$this->load->view("include/header");
        $this->load->view("menusetup/index", $data);
        $this->load->view("include/footer");
    }

    public function updateMenu()
    {
        $sequence = json_decode($this->input->post('sequence'));
        foreach ($sequence as $key => $value) 
        {
            if (array_key_exists("children",$value)) {
                foreach ($value->children as $ch_key => $ch_value) 
                {
                    $ch_data = [];
                    $ch_data["sorting"] = $ch_key+1;
                    $ch_data["parent_id"] = $value->id;
                    $this->Menusetup_model->updateRow("ia_menu","id", $ch_value->id, $ch_data);
                }
            }
            $data = [];
            $data["sorting"] = $key+1;
            $data["parent_id"] = 0;
            $this->Menusetup_model->updateRow("ia_menu","id", $value->id, $data);
            $art_msg['msg'] = lang('menu_updated');
            $art_msg['type'] = 'success';
            $this->session->set_userdata('alert_msg', $art_msg);
        }
        echo true;
    }
}
