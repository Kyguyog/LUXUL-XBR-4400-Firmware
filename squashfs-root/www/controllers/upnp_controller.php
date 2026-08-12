<?php

class Upnp_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(UPNP . DS . UPNP);
        $this->Load_Model(UPNP);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(UPNP);
    }

    public function addContent() {
        $this->addUPNPView();
    }

    public function addUPNPView() {
        $upnp = EMPTY_STRING;
        $upnp_view = new View();

        $this->assignRebootRequireView($upnp_view);
        $this->assignUpnpView($upnp_view);

        $upnp .= $upnp_view->Render(UPNP . DS . SETUP, FALSE);
        $this->Assign(UPNP, $upnp);
    }

    public function assignUpnpView($view) {
        $view->Assign(UPNP_STATUS_OPTIONS, $this->getUpnpStatusOptions());
        $view->Assign(LAN, $this->getLans());
        $view->Assign(VLANS, $this->getVlans());
        $view->Assign(LEASES, $this->getUpnpLeases());
    }

    public function getUpnpStatusOptions() {
        $options = array(
            UPNP_STATUS_ENABLED_KEY => UPNP_STATUS_ENABLED_VAL,
            UPNP_STATUS_DISABLED_KEY => UPNP_STATUS_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->model->getStatus());
    }

    function getUpnpLeases() {
        $upnpLeases = $this->model->getUpnpLeases();
        $upnpLeasesArray = array();

        if (count($this->model->getUpnpLeases()) > 0) {
            foreach ($upnpLeases as $row) {
                $arrRow = explode(SPACE, $row);
                $cols = explode(COLON, $arrRow[0]);

                if (count($cols) > 3)
                    $upnpLeasesArray[] = array(
                        PROTOCAL => $cols[0],
                        WAN_PORT => $cols[1],
                        LAN_IP_ADDR => $cols[2],
                        LAN_PORT => $cols[3]
                    );
            }
        }
        return $upnpLeasesArray;
    }

    function getLans() {
        return explode(SPACE, $this->model->getLans());
    }

    function getVlans() {
        $network = $this->model->getNetworkInfo();
        $vlanArray = array();

        foreach ($network as $line) {
            if ((strstr($line, NETWORK_LAN) || strstr($line, NETWORK_VLAN)) && strstr($line, EQUAL_INTERFACE)) {
                $line = str_replace(EQUAL_INTERFACE, EMPTY_STRING, $line);
                $line = str_replace(NETWORK . UCI_FIELD_DOT, EMPTY_STRING, $line);
                if ($line == LAN) {
                    $vlanArray[$line] = WORD_DEFAULT . DS . strtoupper(LAN);
                } else {
                    $vlanid = str_replace(VLAN, EMPTY_STRING, $line);
                    $vlanArray[$line] = str_replace(BACKTICK, EMPTY_STRING, $this->model->getVlanName($vlanid));
                }
            }
        }
        return $vlanArray;
    }

    public function save($data) {
        $upnpArray = explode(COMMA, $data);
        $this->saveUpnpSetting($upnpArray[0]);
        $vlans = join(SPACE, explode(SEMI_COLON, $upnpArray[1]));
        $this->saveLans($vlans);

        $this->commit();
        $this->restartUpnp();
        $this->saveRebootRequired();

        header(LOCATION . UPNP_PAGE);
    }

    public function saveUpnpSetting($status) {
        $this->model->setStatus($status);
        $status == UPNP_STATUS_ENABLED_KEY ? $this->model->enableUpnp() : $this->model->disableUpnp();
    }

    public function saveLans($lans) {
        $this->model->setLans($lans);
    }

    public function restartUpnp() {
        $this->model->restartUpnp();
    }

}