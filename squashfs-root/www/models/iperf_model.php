<?php

class Iperf_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(IPERF);
    }

    public function getIperfStatus() {
        $this->execute($this->config->GET_IPERF_STATUS_COMMAND, $output, $ret);
        return intval(trim($output[0])) >= 1 ? TRUE : FALSE;
    }

    public function startIperf($minutes) {
        if ($this->getIperfStatus()) {
            $this->stopIperf();
        }

        $this->shell_exec($this->config->IPERF_START_COMMAND . $minutes . $this->config->IGNORE_OUTPUT_COMMAND);
    }

    public function stopIperf() {
        $this->shell_exec($this->config->KILL_IPERF);
        $this->shell_exec($this->config->KILL_SLEEP);
    }

}