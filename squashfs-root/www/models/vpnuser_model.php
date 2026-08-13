<?php

class Vpnuser_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function createVpnUserFile() {
        fopen(VPN_USER_FILE, FILE_WRITE_FLAG);
    }

    public function saveVpnUserInfo($userName, $password) {
        file_put_contents(VPN_USER_FILE, $userName . PIPE . $password . PHP_EOL, FILE_APPEND);
    }

    public function getVpnUserInfoArray() {
        $this->execute("cat ".VPN_USER_FILE, $output, $ret);
        return $output;
    }
}