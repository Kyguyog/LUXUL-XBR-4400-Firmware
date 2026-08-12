<?php

class Qos_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(QOS . DS . QOS);
        $this->Load_Model(QOS);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(QOS);

        if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . QOS);
        }
    }

    public function addContent() {
        $this->addQOSView();
    }

    public function addQOSView() {
        $qos = EMPTY_STRING;
        $qos_view = new View();

        $this->assignRebootRequireView($qos_view);
        $this->assignQOSSetupView($qos_view);
        $this->assignQOSRulesView($qos_view);

        $qos .= $qos_view->Render(QOS . DS . SETUP, FALSE);
        $this->Assign(QOS, $qos);
    }

    public function assignQOSSetupView($view) {
        $view->Assign(QOS_SERVICE_STATUS_OPTIONS, $this->getQosServiceStatusOptions());
        $view->Assign(CALCULATE_OVERHEAD_OPTIONS, $this->getCalculateOverheadOptions());
        $view->Assign(QOS_DOWNLOAD_SPEED, $this->getQosDownloadSpeed());
        $view->Assign(QOS_UPLOAD_SPEED, $this->getQosUploadSpeed());
    }

    public function assignQOSRulesView($view) {
        $view->Assign(SERVICE_LEVEL_OPTIONS, $this->getServiceLevelOptions());
        $view->Assign(PROTOCAL_OPTIONS, $this->getProtocalOptions());
        $view->Assign(QOS_RULES_INFO, $this->getQosRulesInfo());
    }

    public function getProtocalOptions() {
        $options = array(
            PROTOCAL_ALL_KEY => PROTOCAL_ALL_VAL,
            PROTOCAL_TCP_KEY => PROTOCAL_TCP_VAL,
            PROTOCAL_UDP_KEY => PROTOCAL_UDP_VAL,
        );

        return $this->helper->selectOption($options, PROTOCAL_ALL_KEY);
    }

    public function getQosServiceStatusOptions() {
        $options = array(
            QOS_SERVICE_STATUS_ENABLED_KEY => QOS_SERVICE_STATUS_ENABLED_VAL,
            QOS_SERVICE_STATUS_DISABLED_KEY => QOS_SERVICE_STATUS_DISABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getQosServiceStatus());
    }

    public function getQosServiceStatus() {
        return $this->model->getQosServiceStatus();
    }

    public function getCalculateOverheadOptions() {
        $options = array(
            CALCULATE_OVERHEAD_STATUS_ENABLED_KEY => CALCULATE_OVERHEAD_STATUS_ENABLED_VAL,
            CALCULATE_OVERHEAD_STATUS_DISABLED_KEY => CALCULATE_OVERHEAD_STATUS_DISABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getCalculateOverheadStatus());
    }

    public function getCalculateOverheadStatus() {
        return $this->model->getCalculateOverheadStatus();
    }

    public function getQosDownloadSpeed() {
        return $this->model->getQosDownloadSpeed();
    }

    public function getQosUploadSpeed() {
        return $this->model->getQosUploadSpeed();
    }

    public function getServiceLevelOptions() {
        $options = array(
            SERVICE_LEVEL_NORMAL_KEY => SERVICE_LEVEL_NORMAL_VAL,
            SERVICE_LEVEL_PRIORITY_KEY => SERVICE_LEVEL_PRIORITY_VAL,
            SERVICE_LEVEL_EXPRESS_KEY => SERVICE_LEVEL_EXPRESS_VAL,
            SERVICE_LEVEL_BULK_KEY => SERVICE_LEVEL_BULK_VAL
        );

        return $this->helper->selectOption($options, SERVICE_LEVEL_NORMAL_KEY);
    }

    public function getQosRulesInfo() {
        $qosRulesArray = array();
        $index = 0;

        while ($this->getQosClassify($index)) {
            $qosRulesArray[$index] = array(
                SERVICE_LEVEL => $this->getServiceLevel($index),
                SOURCE_HOST => $this->getSourceHost($index),
                PROTOCAL => $this->revertProtocal($this->getProtocal($index)),
                PORTS => $this->getPorts($index)
            );

            $index++;
        }
        return $qosRulesArray;
    }

    public function revertProtocal($protocol) {
        $protocolVal = EMPTY_STRING;

        if ($protocol == PROTOCAL_ALL_KEY) {
            $protocolVal = PROTOCAL_ALL_VAL;
        } else if ($protocol == PROTOCAL_TCP_KEY) {
            $protocolVal = PROTOCAL_TCP_VAL;
        } else if ($protocol == PROTOCAL_UDP_KEY) {
            $protocolVal = PROTOCAL_UDP_VAL;
        }

        return $protocolVal;
    }

    public function getQosClassify($index) {
        return $this->model->getQosClassify(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getServiceLevel($index) {
        return $this->model->getServiceLevel(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getSourceHost($index) {
        return $this->model->getSourceHost(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getProtocal($index) {
        return $this->model->getProtocal(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getPorts($index) {
        return $this->model->getPorts(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function save($data) {
        $qosDataArray = explode(URL_POST_SEPERATOR, urldecode($data));
        $this->saveQosSetup($qosDataArray[0]);

        for ($i = count($this->getQosRulesInfo()); $i >= 0; $i--) {
            $this->deleteQosClassify($i);
        }

        if (isset($qosDataArray[1])) {
            $this->saveQosRules($qosDataArray);
        }

        $this->saveRebootRequired();
        $this->commit();
        $this->restartQOS();
        header(LOCATION . QOS_PAGE);
    }

    public function deleteQosRules($index) {
        $this->deleteQosClassify($index);

        $this->commit();
        $this->saveRebootRequired();

        header(LOCATION . QOS_PAGE);
    }

    public function deleteQosClassify($index) {
        $this->model->deleteQosClassify(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function saveQosSetup($qosSetupArg) {
        $qosSetupArray = explode(COMMA, $qosSetupArg);

        $this->saveQosServiceStatus($qosSetupArray[0]);

        if ($qosSetupArray[0] == QOS_SERVICE_STATUS_ENABLED_KEY) {
            $this->saveWanAccelerationStatus(WAN_ACCELERATION_DISABLED_KEY);
        }

        $this->saveCalculateOverheadStatus($qosSetupArray[1]);
        $this->saveQosDownloadSpeed($qosSetupArray[2]);
        $this->saveQosUploadSpeed($qosSetupArray[3]);
    }

    public function saveQosRules($qosDataArray) {
        for ($i = 1; $i < count($qosDataArray); $i++) {
            $qosRulesArray = explode(COMMA, $qosDataArray[$i]);

            $this->addQosClassify();
            $this->saveServiceLevel($qosRulesArray[1]);
            $this->saveSourceHost(str_replace(EQUAL_SIGN, "/", $qosRulesArray[2]));
            $this->saveProtocal($this->translateProtocol($qosRulesArray[3]));
            $this->savePorts(str_replace(EQUAL_SIGN, COMMA, $qosRulesArray[4]));
        }
    }

    public function translateProtocol($protocolVal) {
        $protocol = EMPTY_STRING;

        if ($protocolVal == PROTOCAL_ALL_VAL) {
            $protocol = PROTOCAL_ALL_KEY;
        } else if ($protocolVal == PROTOCAL_TCP_VAL) {
            $protocol = PROTOCAL_TCP_KEY;
        } else if ($protocolVal == PROTOCAL_UDP_VAL) {
            $protocol = PROTOCAL_UDP_KEY;
        }

        return $protocol;
    }

    public function saveQosServiceStatus($value) {
        $this->model->setQosServiceStatus($value);
    }

    public function saveCalculateOverheadStatus($value) {
        $this->model->setCalculateOverheadStatus($value);
    }

    public function saveQosDownloadSpeed($value) {
        $this->model->setQosDownloadSpeed($value);
    }

    public function saveQosUploadSpeed($value) {
        $this->model->setQosUploadSpeed($value);
    }

    public function addQosClassify() {
        $this->model->addQosClassify();
    }

    public function saveServiceLevel($value) {
        $this->model->setServiceLevel($value);
    }

    public function saveSourceHost($value) {
        $this->model->setSourceHost($value);
    }

    public function saveProtocal($value) {
        $this->model->setProtocal($value);
    }

    public function savePorts($value) {
        $this->model->setPorts($value);
    }

    public function restartQOS() {
        $this->model->restartQOS();
    }

}