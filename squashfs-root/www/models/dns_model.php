<?php

class Dns_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(DNS);
    }

    public function setDNSStatus($value) {
        $this->set($this->config->DNS_STATUS, $value);
    }

    public function getDNSStatus() {
        return $this->get($this->config->DNS_STATUS);
    }

    public function setServiceProvider($value) {
        $this->set($this->config->DNS_SERVICE_PROVIDER, $value);
    }

    public function getServiceProvider() {
        return $this->get($this->config->DNS_SERVICE_PROVIDER);
    }

    public function setDNSHostname($value) {
        $this->set($this->config->DNS_HOST_NAME, $value);
    }

    public function getDNSHostname() {
        return $this->get($this->config->DNS_HOST_NAME);
    }

    public function setDNSUsername($value) {
        $this->set($this->config->DNS_USER_NAME, $value);
    }

    public function getDNSUsername() {
        return $this->get($this->config->DNS_USER_NAME);
    }

    public function setDNSPassword($value) {
        $this->set($this->config->DNS_PASSWORD, $value);
    }

    public function getDNSPassword() {
        return $this->get($this->config->DNS_PASSWORD);
    }

    public function setDNSInterval($value) {
        $this->set($this->config->DNS_INTERVAL, $value);
    }

    public function getDNSInterval() {
        return $this->get($this->config->DNS_INTERVAL);
    }

    public function setDNSUpdateInterval($value) {
        $this->set($this->config->DNS_UPDATE_INTERVAL, $value);
    }

    public function getDNSUpdateInterval() {
        return $this->get($this->config->DNS_UPDATE_INTERVAL);
    }

    public function setDNSService() {
        $this->set($this->config->DNS, $this->config->SERVICE);
    }

    public function setDNSInterface() {
        $this->set($this->config->DNS_INTERFACE, $this->config->DNS_INTERFACE_WAN);
    }

    public function setDNSForceUnit() {
        $this->set($this->config->DNS_FORCE_UNIT, $this->config->DNS_FORCE_UNIT_DAYS);
    }

    public function setDNSCheckUnit() {
        $this->set($this->config->DNS_CHECK_UNIT, $this->config->DNS_CHECK_UNIT_MINUTES);
    }

    public function setDNSRetryInterval() {
        $this->set($this->config->DNS_RETRY_INTERVAL, $this->config->DNS_RETRY_INTERVAL_60);
    }

    public function setDNSRetryUnit() {
        $this->set($this->config->DNS_RETRY_UNIT, $this->config->DNS_RETRY_UNIT_SECONDS);
    }

    public function setDNSIPSource() {
        $this->set($this->config->DNS_IP_SOURCE, $this->config->DNS_IP_SOURCE_WEB);
    }

    public function setDNSIPUrl() {
        $this->set($this->config->DNS_IP_URL, $this->config->DNS_IP_URL_CHECKIP_DNS);
    }

    public function runHotplugScript() {
        $this->shell_exec($this->config->HOTPLUG_SCRIPT);
    }

}