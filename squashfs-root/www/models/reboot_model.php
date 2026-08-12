<?php
class Reboot_Model extends Model{
    function __construct() {
        parent::__construct();
        $this->Load_Config('reboot');
    }

    public function getLanIPAddr() {
        return $this->get($this->config->NETWORK_LAN_IPADDR);
    }
//
//    public function reboot() {
//        $this->execute("reboot", $output,$ret);
//    }
//
//    public function reload() {
//        $this->shell_exec("/etc/init.d/network reload");
//    }
}