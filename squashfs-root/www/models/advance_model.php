<?php

class Advance_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(ADVANCE);
    }

    public function getWanAccelerationStatus() {
        return $this->get(LUXUL_CTF_BASIC_ENABLED);
    }

    public function setWanPingStatus($value) {
        $this->set($this->config->FIREWALL_RULE_TARGET, $value);
    }

    public function getWanPingStatus() {
        return $this->get($this->config->FIREWALL_RULE_TARGET);
    }

    public function setPPTPPassthruStatus($value) {
        $this->set($this->config->LUXUL_DYNAMIC_PPTP_PASSTHRU, $value);
    }

    public function getPPTPPassthruStatus() {
        return $this->get($this->config->LUXUL_DYNAMIC_PPTP_PASSTHRU);
    }

    public function saveFirewallUserInfo($serverAddr) {
        $msg1 = $this->config->FIREWALL_USER_MSG1 . $serverAddr . PHP_EOL;
        file_put_contents(FIREWALL_USER_FILE, $msg1, FILE_APPEND);
        $msg2 = $this->config->FIREWALL_USER_MSG2_PART1 . $serverAddr . $this->config->FIREWALL_USER_MSG2_PART2 . PHP_EOL;
        file_put_contents(FIREWALL_USER_FILE, $msg2, FILE_APPEND);
    }

    public function getServerAddr() {
        $this->execute($this->config->GET_SERVER_ADDR_COMMAND, $output, $ret);
        return count($output) > 0 ? $output[0] : EMPTY_STRING;
    }

    public function deleteFireWallUserInfo() {
        $fileContent = file_get_contents(FIREWALL_USER_FILE);
        $output1 = $this->getFileContent($this->config->FIREWALL_USER_MSG1, FIREWALL_USER_FILE);
        $msg1 = str_replace($output1, EMPTY_STRING, $fileContent);
        file_put_contents(FIREWALL_USER_FILE, $msg1);

        $fileContent = file_get_contents(FIREWALL_USER_FILE);
        $output2 = $this->getFileContent($this->config->FIREWALL_USER_MSG2_PART1, FIREWALL_USER_FILE);
        $msg2 = str_replace($output2, EMPTY_STRING, $fileContent);
        file_put_contents(FIREWALL_USER_FILE, $msg2);

        $this->shell_exec("sed '/^$/d' " . FIREWALL_USER_FILE . ">" . FIREWALL_USER_FILE_TEMP);
        $this->shell_exec("mv " . FIREWALL_USER_FILE_TEMP . " " . FIREWALL_USER_FILE);
    }

    public function getPortMonitor() {
        return $this->get(LUXUL_BETA_VLAN_MONITOR);
    }

    public function setWanDelay($value) {
        $this->set($this->config->LUXUL_BETA_WAN_DELAY, $value);
    }

    public function getWanDelay() {
        return $this->get($this->config->LUXUL_BETA_WAN_DELAY);
    }

    public function getBlockSelfAssignedIp() {
        $this->execute($this->config->GET_BLOCK_SELF_ASSIGNED_IP_RULE_COMMAND, $output, $ret);
        return count($output) > 0 ? $output[0] : BLOCK_SELF_ASSIGNED_IP_DISABLED_KEY;
    }

    public function restartLuxulCtf() {
        $this->execute($this->config->RESTART_LUXUL_CTF_COMMAND, $output, $ret);
    }

}