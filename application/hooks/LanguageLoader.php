<?php
class LanguageLoader
{
    public function initialize()
    {
        $ci = &get_instance();
        $ci->load->helper('language');
        $ci->lang->load('message', getSetting('language'));
    }
}
