<?php

class Portforward_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(PORT_FORWARD . DS . PORT_FORWARD);
        $this->Load_Model(PORT_FORWARD);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();

        if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . PORT_FORWARD);
        }
    }

    public function addContent() {
        $port_forward = EMPTY_STRING;
        $port_forward_view = new View();

        $this->assignRebootRequireView($port_forward_view);
        $port_forward_view->Assign(PROTOCAL_OPTIONS, $this->getProtocalOptions());
        $port_forward_view->Assign(FORWARDED_PORTS_INFO, $this->getForwardedPortsInfo());

        $port_forward .= $port_forward_view->Render(PORT_FORWARD . DS . INFO, FALSE);
        $this->Assign(PORT_FORWARD, $port_forward);
    }

    public function getForwardedPortsInfo() {
        $forwardedPortsArray = array();
        $index = 0;

        while ($this->getFirewallRedirect($index)) {
            if ($this->getFirewallRedirectPortForward($index) == PORT_FORWARD_YES) {
                $forwardedPortsArray[$index] = array(
                    APPLICATION_NAME => $this->getFirewallRedirectName($index),
                    PROTOCAL => $this->revertProtocal($this->getFirewallRedirectProtocol($index)),
                    WAN_PORT => $this->getFirewallRedirectSrcPort($index),
                    LAN_IP_ADDR => $this->getFirewallRedirectDestIp($index),
                    LAN_PORT => $this->getFirewallRedirectDestPort($index)
                );
            }
            $index++;
        }

        return $forwardedPortsArray;
    }

    public function getProtocalOptions() {
        $options = array(
            PROTOCAL_BOTH_KEY => PROTOCAL_BOTH_VAL,
            PROTOCAL_TCP_KEY => PROTOCAL_TCP_VAL,
            PROTOCAL_UDP_KEY => PROTOCAL_UDP_VAL,
        );

        return $this->helper->selectOption($options, PROTOCAL_BOTH_KEY);
    }

    public function getFirewallRedirectProtocol($index) {
        return $this->model->getFirewallRedirectProtocol(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getFirewallRedirectSrcPort($index) {
        return $this->model->getFirewallRedirectSrcPort(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getFirewallRedirectDestPort($index) {
        return $this->model->getFirewallRedirectDestPort(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function save($tableData) {
        $this->deleteForwardedPortsInfo();
        $forwardedPortsArray = explode(URL_POST_SEPERATOR, rawurldecode($tableData));

        if (count($forwardedPortsArray) > 0) {
            foreach ($forwardedPortsArray as $key => $forwardedPortInfo) {
                if ($forwardedPortInfo != EMPTY_STRING) {
                    $forwardedPortInfoArray = explode(COMMA, $forwardedPortInfo);

                    $this->addFirewallRedirect();
                    $this->saveFirewallRedirectName(urldecode($forwardedPortInfoArray[1]));
                    $this->saveFirewallRedirectPortForward(PORT_FORWARD_YES);
                    $this->saveFirewallRedirectSrc();
                    $this->saveFirewallRedirectProto($this->translateProtocol($forwardedPortInfoArray[2]));
                    $this->saveFirewallRedirectSrcPort($forwardedPortInfoArray[3]);
                    $this->saveFirewallRedirectDestIp($forwardedPortInfoArray[4]);
                    $this->saveFirewallRedirectDestPort($forwardedPortInfoArray[5]);
                    $this->saveFirewallRedirectTarget();
                    $this->saveFirewallRedirectDest();
                }
            }
        }

        $this->commit();
        $this->saveRebootRequired();

        header(LOCATION . PORT_FORWARD_PAGE);
    }

    public function translateProtocol($protocolVal) {
        $protocol = EMPTY_STRING;

        if ($protocolVal == PROTOCAL_BOTH_VAL) {
            $protocol = PROTOCAL_BOTH_KEY;
        } else if ($protocolVal == PROTOCAL_TCP_VAL) {
            $protocol = PROTOCAL_TCP_KEY;
        } else if ($protocolVal == PROTOCAL_UDP_VAL) {
            $protocol = PROTOCAL_UDP_KEY;
        }

        return $protocol;
    }

    public function revertProtocal($protocol) {
        $protocolVal = EMPTY_STRING;

        if ($protocol == PROTOCAL_BOTH_KEY) {
            $protocolVal = PROTOCAL_BOTH_VAL;
        } else if ($protocol == PROTOCAL_TCP_KEY) {
            $protocolVal = PROTOCAL_TCP_VAL;
        } else if ($protocol == PROTOCAL_UDP_KEY) {
            $protocolVal = PROTOCAL_UDP_VAL;
        }

        return $protocolVal;
    }

    public function deleteForwardedPortsInfo() {
        $index = 0;

        while ($this->getFirewallRedirect($index)) {
            if ($this->getFirewallRedirectPortForward($index) == PORT_FORWARD_YES) {
                $this->deleteFirewallRedirect($index);
            } else {
                $index++;
            }
        }
    }

    public function deleteForwardedPort($index) {
        $this->deleteFirewallRedirect($index);

        $this->commit();
        $this->saveRebootRequired();

        header(LOCATION . PORT_FORWARD_PAGE);
    }

}