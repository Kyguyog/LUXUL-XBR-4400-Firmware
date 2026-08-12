<?php

class Qos_Model extends Model {
    function __construct() {
        parent::__construct();
        $this->Load_Config(QOS);
    }

    public function setQosServiceStatus($value) {
        $this->set($this->config->QOS_WAN_ENABLED, $value);
    }

    public function getQosServiceStatus() {
        return $this->get($this->config->QOS_WAN_ENABLED);
    }

    public function setCalculateOverheadStatus($value) {
        $this->set($this->config->QOS_WAN_OVERHEAD, $value);
    }

    public function getCalculateOverheadStatus() {
        return $this->get($this->config->QOS_WAN_OVERHEAD);
    }

    public function setQosDownloadSpeed($value) {
        $this->set($this->config->QOS_WAN_DOWNLOAD, $value * 1024);
    }

    public function getQosDownloadSpeed() {
        return $this->get($this->config->QOS_WAN_DOWNLOAD) ? round($this->get($this->config->QOS_WAN_DOWNLOAD) / 1024) : $this->config->QOS_WAN_SPEED_0;
    }

    public function setQosUploadSpeed($value) {
        $this->set($this->config->QOS_WAN_UPLOAD, $value * 1024);
    }

    public function getQosUploadSpeed() {
        return $this->get($this->config->QOS_WAN_UPLOAD) ? round($this->get($this->config->QOS_WAN_UPLOAD) / 1024) : $this->config->QOS_WAN_SPEED_0;
    }

    public function addQosClassify() {
        $this->add(QOS, $this->config->CLASSIFY);
    }

    public function deleteQosClassify($index) {
        $this->delete(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . $index);
    }

    public function getQosClassify($index) {
        return $this->get(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . $index);
    }

    public function setServiceLevel($value) {
        $this->set(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . TARGET, $value);
    }

    public function getServiceLevel($index) {
        return $this->get(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . $index . UCI_FIELD_DOT . TARGET);
    }

    public function setSourceHost($value) {
        $this->set(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . $this->config->SOURCE_HOST, $value);
    }

    public function getSourceHost($index) {
        return $this->get(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . $index . UCI_FIELD_DOT . $this->config->SOURCE_HOST);
    }

    public function setProtocal($value) {
        $this->set(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . PROTO, $value);
    }

    public function getProtocal($index) {
        return $this->get(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . $index . UCI_FIELD_DOT . PROTO);
    }

    public function setPorts($value) {
        $this->set(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . PORTS, $value);
    }

    public function getPorts($index) {
        return $this->get(QOS . UCI_FIELD_DOT . UCI_FIELD_AT . $this->config->CLASSIFY . $index . UCI_FIELD_DOT . PORTS);
    }

    public function restartQOS() {
        $this->execute($this->config->RESTART_QOS_COMMAND, $output, $ret);
    }

}