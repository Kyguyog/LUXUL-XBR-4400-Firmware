<?php

class Upgrade_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(UPGRADE);
    }

    public function getUpgradeModel() {
        $this->execute($this->config->GET_UPGRADE_FILE_HEADER_ECHO_COMMAND . TEMP_FILE_UPLOAD . $this->config->GET_UPGRADE_MODEL_COMMAND, $output, $ret);
        return $output[0];
    }

    public function getMD5Header() {
        $this->execute($this->config->GET_UPGRADE_FILE_HEADER_ECHO_COMMAND . TEMP_FILE_UPLOAD . $this->config->GET_UPGRADE_HEADER_SUM_COMMAND, $output, $ret);
        return $output[0];
    }

    public function getMD5File() {
        $this->execute($this->config->GET_UPGRADE_FILE_HEADER_ECHO_COMMAND . TEMP_FILE_UPLOAD . $this->config->GET_UPGRADE_FILE_SUM_COMMAND, $output, $ret);
        return $output[0];
    }

    public function removeFileHeader() {
        $this->execute($this->config->GET_UPGRADE_FILE_HEADER_COMMAND . TEMP_FILE_UPLOAD . $this->config->REMOVE_UPGRADE_FILE_HEADER_COMMAND1 . TEMP_FILE_UPLOAD . $this->config->REMOVE_UPGRADE_FILE_HEADER_COMMAND2, $output, $ret);
    }

    public function upgradeFirmware() {
        $this->execute($this->config->FIRMWARE_UPGRADE_DIRECTORY . TEMP_FILE_UPLOAD . $this->config->FIRMWARE_UPGRADE_COMMAND, $output, $ret);
    }

}