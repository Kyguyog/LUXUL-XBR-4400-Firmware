<?php
class Backup_Model extends Model{
    function __construct() {
        parent::__construct();
        $this->Load_Config(BACKUP);
    }

    public function restoreFile() {
        $this->execute($this->config->RESTORE_FILE_COMMAND, $output,$ret);
        return $ret;
    }

    public function forceRestoreFile() {
        $this->execute($this->config->FORCE_RESTORE_FILE_COMMAND, $output,$ret);
        return $ret;
    }

}