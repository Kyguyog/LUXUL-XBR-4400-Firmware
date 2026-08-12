<?php

class Log_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function getLogMessage() {
        $this->execute(GET_LOG_MSG_COMMAND, $output, $ret);
        return $output;
    }

    public function getSysLogSize() {
        return $this->get(SYS_LOG_SIZE);
    }

    public function setSysLogSize($logSize) {
        $this->set(SYS_LOG_SIZE, $logSize);
    }

}