<?php defined("BASEPATH") or exit("No direct script access allowed");

class Plugins extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        isLogin();
        $this->lang->load('plugins', getSetting('language'));
        $this->load->model('plugins_model', 'em');
    }

    /**
     * This function is used to load page view
     * @return Void
     */
    public function index()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS ia_plugins.plugins_id AS plugins_id, ia_plugins.name AS name, ia_plugins.status AS status', false);

         if (CheckPermission('ia_plugins', "all_read")) {} else if (CheckPermission('ia_plugins', "own_read") && CheckPermission('ia_plugins', "all_read") != true) {
            $this->db->where('ia_plugins.user_id',$this->user_id);
        }
            $this->db->from('ia_plugins');
            $query = $this->db->get();
            $output_arr['result'] = $query->result_array();
        $this->load->view("include/header");
        $this->load->view("plugins/index", $output_arr);
        $this->load->view("include/footer");
    }

    public function install()
    {
        if (isset($_FILES['extn_file']) && $_FILES['extn_file']['error'] == 0) {
            $file_path = 'assets/tmp/';
            @mkdir($file_path, 0777, true);
            $f_name = strtolower(str_replace(' ', '_', $_FILES['extn_file']['name']));
            $config['upload_path'] = 'assets/tmp/';
            $config['allowed_types'] = 'rar|zip';
            $config['file_name'] = $f_name;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('extn_file')) {
                $art_msg['msg'] = $this->upload->display_errors();
                $art_msg['type'] = 'warning';
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect(base_url() . 'plugins');
            } else {
                /**** Extract file ****/
                $zip = new ZipArchive;
                $ext = pathinfo($file_path . $f_name, PATHINFO_EXTENSION);
                if ($zip->open($file_path . $f_name, ZipArchive::CREATE) === true) {
                    $zip->extractTo($file_path);
                    $zip->close();

                    /*----------  Check folder exist  ----------*/
                    $dir = scandir($file_path, 1);
                    foreach ($dir as $value) {
                        if (is_dir($file_path . $value)) {
                            $dir_in = scandir($file_path . $value, 1);
                            $k = array_search('configuration', $dir_in);
                            if ($k !== '') {
                                $abc = file_exists($file_path . $value . '/configuration/configuration.xml');
                                // echo $abc;die();
                                if ($abc == "1") {
                                    $xml = $this->parseXml($file_path . $value . '/configuration/configuration.xml');
                                    $this->checkInstalled($xml->name);
                                    if ($xml->options->database == 1) {
                                        $db_file = $file_path . $value . '/configuration/db/database.sql';
                                        $db_operation = $this->importDatabase($db_file);
                                        if ($db_operation) {
                                                    // print_r($xml);die();
                                            $this->removeDirectory($file_path . $value . '/configuration/');
                                            $dst = 'application/modules';
                                            $this->recurseCopy($file_path . $value, $dst . '/' . $xml->name);
                                            $this->removeDirectory($file_path);
                                            if (isset($xml->menus->list)) {
                                                $module_count = $xml->menus->list;
                                                $lastSort = $this->em->getDataBySort();
                                                $lastSortId = $lastSort[0]->sorting_id;
                                                for ($num=1; $num<=$module_count; $num++) {
                                                    $menu = 'menu'.$num;
                                                    $sorting = $lastSortId+$num;
                                                    $xml2 = $xml->menus->$menu;
                                                    $ia_menu_data = array(
                                                        "menu_name" => (string) $xml2->name,
                                                        "icon" => (string) $xml2->icon,
                                                        "slug" => (string) $xml2->slug,
                                                        "module_name" => (string) $xml2->moduleName,
                                                        "status" => 1,
                                                        "sorting" => $sorting
                                                    );
                                                    // print_r($ia_menu_data);die();
                                                    $this->em->insertRow('ia_menu', $ia_menu_data);
                                                    $last = $this->em->getDataByLast('ia_menu');
                                                    $lastId = $last[0]->id;
                                                    if (isset($xml2->sublist)) {
                                                        $sub_menu_count = $xml2->sublist;
                                                        for ($num2=1; $num2 <= $sub_menu_count; $num2++) {
                                                            $submenu = 'menu'.$num.$num2;
                                                            $xml3 = $xml2->$submenu;
                                                            $ia_menu_data1 = array(
                                                                "menu_name" => (string) $xml3->name,
                                                                "icon" => (string) $xml3->icon,
                                                                "slug" => (string) $xml3->slug,
                                                                "module_name" => (string) $xml3->moduleName,
                                                                "status" => 1,
                                                                "parent_id" => $lastId,
                                                                "sorting" => $num2
                                                            );
                                                            $this->em->insertRow('ia_menu', $ia_menu_data1);
                                    // print_r($ia_menu_data1);die();
                                    // print_r($xml);die();
                                                        }
                                                    }
                                                }
                                            } else {
                                                $ia_menu_data2 = array(
                                                    "menu_name" => $xml->name,
                                                    "icon" => (string) $xml->options->menu_con,
                                                    "slug" => $xml->name,
                                                    "module_name" => $xml->name,
                                                    "status" => 1,
                                                );
                                                $this->em->insertRow('ia_menu', $ia_menu_data2);
                                            }
                                            
                                            

                                            $ia_plugins_data = array(
                                                "name" => $xml->name,
                                                "db_tables" => (string) $xml->options->database_tb_name,
                                                "status" => 1,
                                                "inst_date" => date('Y-m-d H:i:s'),
                                            );

                                            if (isset($xml->rm_queries) && $xml->rm_queries != '') {
                                                $ia_plugins_data['rm_queries'] = $xml->rm_queries;
                                            }

                                            $this->em->insertRow('ia_plugins', $ia_plugins_data);
                                            $this->setPermissions($xml->name);

                                            $art_msg['msg'] = lang('plugins_installed_successfully');
                                            $art_msg['type'] = 'success';
                                            $this->session->set_userdata('alert_msg', $art_msg);
                                            redirect(base_url() . 'plugins');
                                        }
                                    }
                                } else {
                                    // $this->removeDirectory($file_path);
                                    $art_msg['msg'] = lang('configuration_file_not_exist');
                                    $art_msg['type'] = 'warning';
                                    $this->session->set_userdata('alert_msg', $art_msg);
                                    redirect(base_url() . 'plugins');
                                }
                            }
                        }
                    }
                } else {
                    $this->removeDirectory($file_path);
                    $art_msg['msg'] = lang('unable_to_extract_file');
                    $art_msg['type'] = 'warning';
                    $this->session->set_userdata('alert_msg', $art_msg);
                    redirect(base_url() . 'plugins');
                }
            }
        }
    }

    public function setPermissions($name)
    {
        //$name = 'todo';
        $per = $this->em->getDataBy('ia_permission', '', '');
        if (is_array($per) && !empty($per)) {
            foreach ($per as $perkey => $pervalue) {
                $rec = json_decode($pervalue->data, 1);
                $name = (string) $name;
                $rec[$name] = $name;
                $perdata = array("data" => json_encode($rec));
                $this->em->updateRow('ia_permission', 'id', $pervalue->id, $perdata);
            }
        }
    }

    public function checkInstalled($name)
    {
        $res = $this->em->getDataBy('ia_plugins', $name, 'name');
        if (is_array($res) && !empty($res)) {
            $art_msg['msg'] = lang('plugins_already_installed');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'plugins');
        }
    }

    public function parseXml($file)
    {
        $t = file_get_contents($file);
        $x = @simplexml_load_string($t);
        if ($x) {
            return $x;
        }
    }

    public function importDatabase($db_file)
    {
        if (file_exists($db_file) === true) {
            $connTemp = new mysqli($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
            if (mysqli_connect_errno()) {
                $art_msg['msg'] = lang('failed_to_connect_to_my_s_q_l') . ': .' . mysqli_connect_error();
                $art_msg['type'] = 'warning';
                $this->session->set_userdata('alert_msg', $art_msg);
                redirect(base_url() . 'plugins');
            }
            $sql = file_get_contents($db_file);
            $res = $connTemp->multi_query($sql);
            mysqli_close($connTemp);
            if ($res) {
                return true;
            }
        } else {
            $art_msg['msg'] = lang('database_file_not_exist');
            $art_msg['type'] = 'warning';
            $this->session->set_userdata('alert_msg', $art_msg);
            redirect(base_url() . 'plugins');
        }
    }

    public function removeDirectory($dir)
    {
        if ($dir) {
            @chmod($dir, 0777);
        }
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                @chmod($file->getRealPath(), 0777);
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    public function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst, 0777, true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function ajxData()
    {
        $primaryKey = 'plugins_id';
        $table = 'ia_plugins';
        $joinQuery = "FROM `ia_plugins` ";
        $columns = array(
            array('db' => 'ia_plugins.plugins_id AS plugins_id', 'field' => 'plugins_id', 'dt' => 0),
            array('db' => 'ia_plugins.name AS name', 'field' => 'name', 'dt' => 1),
            array('db' => 'ia_plugins.status AS status', 'field' => 'status', 'dt' => 2, 'formatter' => function ($d, $row) {
                $t = lang('inactive');
                $c = 'red';
                if ($d == 1) {
                    $t = lang('active');
                    $c = 'blue';
                }
                $st = '<span class="label bg-' . $c . '" data-id="' . $row['plugins_id'] . '" rel="' . $d . '">' . $t . '</span>';
                return $st;
            }),
            array('db' => 'ia_plugins.plugins_id AS plugins_id', 'field' => 'plugins_id', 'dt' => 3, 'formatter' => function ($d, $row) {
                $title = lang('active');
                $icn = 'check_circle';
                $color = 'green';
                if ($row['status'] == 1) {
                    $title = lang('inactive');
                    $icn = 'cancel';
                    $color = 'orange';
                }

                $act = '<a  class="ch-status" data-id="' . $d . '" rel="' . $row['status'] . '" title="' . $title . '"><i class="material-icons col-' . $color . ' font-20">' . $icn . '</i></a><a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="' . lang('delete') . '" onclick="setId(' . $d . ', \'plugins\')"><i class="material-icons col-red font-20">delete</i></a>';
                return $act;
            }),
        );
        $where = '';
        $j = 0;
        if (strpos($joinQuery, 'JOIN') > 0) {
            $j = 1;
        }
        $where = SSP::iaFilter($_GET, $columns, $j);
        $where = SSP::column_ia_filter($_GET, $where);
        if ($this->input->get('dateRange')) {
            $date = explode(' - ', $this->input->get('dateRange'));
            $and = 'WHERE ';
            if ($where != '') {
                $and = ' AND ';
            }
            $where .= $and . "DATE_FORMAT(`$table`.`" . $this->input->get('columnName') . "`, '%Y/%m/%d') >= '" . date('Y/m/d', strtotime($date[0])) . "' AND  DATE_FORMAT(`$table`.`" . $this->input->get('columnName') . "`, '%Y/%m/%d') <= '" . date('Y/m/d', strtotime($date[1])) . "' ";
        }

        if (CheckPermission($table, "all_read")) {} else if (CheckPermission($table, "own_read") && CheckPermission($table, "all_read") != true) {
            $and = 'WHERE ';
            if ($where != '') {
                $and = ' AND ';
            }
            $where .= $and . "`$table`.`user_id`=" . $this->user_id . " ";
        }

        if (trim($where) == 'WHERE') {
            $where = '';
        }
        $group_by = "";

        $limit = SSP::limit($_GET, $columns);
        $order = SSP::iaOrder($_GET, $columns, $j);
        $col = SSP::pluck($columns, 'db', $j);
        if (trim($where) == 'WHERE' || trim($where) == 'WHERE ()') {
            $where = '';
        }
        $query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $col) . " " . $joinQuery . " " . $where . " " . $group_by . " " . $order . " " . $limit . " ";
        $res = $this->db->query($query);
        $res = $res->result_array();
        $recordsTotal = $this->db->select("count('plugins_id') AS c")->get('ia_plugins')->row()->c;
        $res = SSP::iaDataOutput($columns, $res, $j);

        $output_arr['draw'] = intval($_GET['draw']);
        $output_arr['recordsTotal'] = intval($recordsTotal);
        $output_arr['recordsFiltered'] = intval($recordsTotal);
        $output_arr['data'] = $res;
        echo json_encode($output_arr);
        exit;
    }

    public function delete($id)
    {
        $folderpath = realpath(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/application/modules/';
        $o_extn = $this->em->getDataBy('ia_plugins', $id, 'plugins_id');
        foreach ($o_extn as $oekey => $oevalue) {
            $this->em->deleteExtnDbAction($oevalue);
            $folderpath = $folderpath . $oevalue->name;
            if (is_dir($folderpath)) {
                $this->removeDirectory($folderpath);
            }
        }
        $art_msg['msg'] = lang('plugins_deleted_successfully');
        $art_msg['type'] = 'success';
        $this->session->set_userdata('alert_msg', $art_msg);
        redirect(base_url() . 'plugins');
    }

    public function updateStatus()
    {
        $status = 1;
        if ($this->input->post('status') == 1) {
            $status = 0;
        }
        $o_extn = $this->em->getDataBy('ia_plugins', $this->input->post('id'), 'plugins_id');
        foreach ($o_extn as $ekey => $evalue) {
            $data = array('status' => $status);
            $this->em->updateRow('ia_plugins', 'plugins_id', $evalue->plugins_id, $data);
            $this->em->updateRow('ia_menu', 'menu_name', $evalue->name, $data);
        }
        echo 1;
        exit;
    }
}
