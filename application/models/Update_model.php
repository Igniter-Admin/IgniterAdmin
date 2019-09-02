<?php defined('BASEPATH') or exit('No direct script access allowed');

class Update_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUpdateInfo()
    {   
        $url = 'http://igniteradmin.com/version/';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                'update_info' => 'true',
                'current_version' => $this->getCurrentDbVersion(),
            ),
        ));

        $result = curl_exec($curl);
        $error = '';
        if (!$curl || !$result) {
            $error = 'Curl Error - Contact your hosting provider with the following error as reference: Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl);
        }

        curl_close($curl);

        if ($error != '') {
            return $error;
        }

        return $result;
    }

    public function getCurrentDbVersion()
    {
        $data = $this->db->from('ia_setting')->where('keys', 'version')->get()->result();
        return !empty($data[0]->value) ? $data[0]->value : '';
    }

    public function upgradeDatabaseSilent($latest_version)
    {
        $data['value'] = $latest_version;
        $this->db->where('keys', 'version');
        $this->db->update('ia_setting', $data);
        return array(
            'success' => true,
        );
    }
}
