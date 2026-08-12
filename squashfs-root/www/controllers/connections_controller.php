<?php

class Connections_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(CONNECTIONS . DS . CONNECTIONS);
        $this->Load_Model(CONNECTIONS);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(CONNECTIONS);

        if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . CONNECTIONS);
        }
    }

    public function addContent() {
        $connected = EMPTY_STRING;
        $connected_view = new View();

        $connected_view->Assign(CONNECTED_CLIENTS_OPTIONS, $this->getConnectedClientsOptions());
        $connected_view->Assign(ALL_CLIENTS_INFO, $this->getAllClientsInfo());
        $connected_view->Assign(DHCP_CLIENTS_INFO, $this->getDHCPClientsInfo());

        $connected .= $connected_view->Render(CONNECTIONS . DS . INFO, FALSE);
        $this->Assign(CONNECTIONS, $connected);
    }

    public function getConnectedClientsOptions() {
        $options = array(
            CONNECTED_CLIENTS_ALL_KEY => CONNECTED_CLIENTS_ALL_VAL,
            CONNECTED_CLIENTS_DHCP_KEY => CONNECTED_CLIENTS_DHCP_VAL
        );

        return $this->helper->selectOption($options, isset($_POST[CONNECTED_CLIENTS_OPTIONS]) ? $_POST[CONNECTED_CLIENTS_OPTIONS] : CONNECTED_CLIENTS_ALL_KEY);
    }

    public function getDHCPClientsInfo() {
        $dhcpClientsInfo = array();

        if ($this->getDHCPStatus() == DHCP_STATUS_0) {
            $dhcpClientsArray = $this->getDHCPClientsArray();

            if (count($dhcpClientsArray) > 0) {
                foreach ($dhcpClientsArray as $key => $dhcpClientsString) {
                    $dhcpClients = explode(SPACE, $dhcpClientsString);
                    $dhcpClientsInfo[$key] = array(
                        MAC_ADDRESS => $dhcpClients[1],
                        IP_ADDRESS => $dhcpClients[2],
                        DEVICE_NAME => $dhcpClients[3]
                    );
                }
            }
        }

        return $dhcpClientsInfo;
    }

    public function getDHCPStatus() {
        return $this->model->getDHCPStatus();
    }

    public function getDHCPClientsArray() {
        return $this->model->getDHCPClientsArray();
    }

}