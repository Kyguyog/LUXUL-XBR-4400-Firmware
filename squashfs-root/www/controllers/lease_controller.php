<?php

class Lease_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(LEASE . DS . LEASE);
        $this->Load_Model(LEASE);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
    }

    public function addContent() {
        $lease = EMPTY_STRING;
        $lease_view = new View();

        $lease_view->Assign(ALL_CLIENTS_INFO, $this->getAllClientsInfo());
        $lease_view->Assign(LEASE_CLIENTS_INFO, $this->getLeaseClientsInfo());

        $lease .= $lease_view->Render(LEASE . DS . INFO, FALSE);
        $this->Assign(LEASE, $lease);
    }

    public function getLeaseClientsInfo() {
        $leaseClientArray = array();
        $index = 0;

        while ($this->getDHCPHost($index)) {
            $leaseClientArray[$index] = array(
                DESCRIPTION => $this->getDHCPName($index),
                IP_ADDRESS => $this->getDHCPIP($index),
                MAC_ADDRESS => $this->getDHCPMac($index),
                HOST_NAME => $this->getHostName($this->getDHCPMac($index))
            );

            $index++;
        }
        return $leaseClientArray;
    }

    public function getDHCPHost($index) {
        return $this->model->getDHCPHost(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getDHCPIP($index) {
        return $this->model->getDHCPIP(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getDHCPMac($index) {
        return $this->model->getDHCPMac(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function getHostName($macAddr) {
        $allClientsArray = $this->getAllClientsInfoRaw();
        $hostName = EMPTY_STRING;

        if (count($allClientsArray) > 0) {
            foreach ($allClientsArray as $key => $clientsInfo) {

                if ($macAddr == $clientsInfo[MAC_ADDRESS]) {
                    $hostName = $clientsInfo[HOST_NAME];
                    break;
                }
            }
        }

        return $hostName;
    }

    public function getAllClientsInfoRaw() {
        $allClientsArray = $this->getAllClientsArray();
        $allClientsInfo = array();

        if (count($allClientsArray) > 0) {
            foreach ($allClientsArray as $key => $allClientsString) {
                if ($key != 0) {
                    $allClients = explode(SPACE, $allClientsString);

                    $allClientsInfo[$key] = array(
                        HOST_NAME => $allClients[0],
                        IP_ADDRESS => $allClients[1],
                        MAC_ADDRESS => $allClients[2],
                    );
                }

            }
        }

        return $allClientsInfo;
    }

    public function save($tableData) {
        $this->deleteDHCPHostInfo();

        $assignedClientsArray = explode(URL_POST_SEPERATOR, rawurldecode($tableData));

        foreach ($assignedClientsArray as $key => $assignedClientsInfo) {
            if ($assignedClientsInfo != EMPTY_STRING) {
                $assignedClientsInfoArray = explode(COMMA, $assignedClientsInfo);

                $this->addDHCPHost();
                $this->saveDHCPName(urldecode($assignedClientsInfoArray[1]));
                $this->saveDHCPIP($assignedClientsInfoArray[2]);
                $this->saveDHCPMac($assignedClientsInfoArray[3]);
            }
        }

        $this->commit();
        $this->restartDnsmasq();

        header(LOCATION . LEASE_PAGE);
    }

    public function delete($index) {
        $this->deleteDHCPHost($index);
        $this->commit();

        $this->restartDnsmasq();
        header(LOCATION . LEASE_PAGE);
    }

    public function deleteDHCPHostInfo() {
        if (count($this->getLeaseClientsInfo()) > 0) {
            for ($i = count($this->getLeaseClientsInfo()); $i >= 0; $i--) {
                $this->deleteDHCPHost($i);
            }
        }
    }

    public function deleteDHCPHost($index) {
        $this->model->deleteDHCPHost(INDEX_BRACKET_LEFT . $index . INDEX_BRACKET_RIGHT);
    }

    public function addDHCPHost() {
        $this->model->addDHCPHost();
    }

    public function saveDHCPName($value) {
        $this->model->setDHCPName($value);
    }

    public function saveDHCPIP($value) {
        $this->model->setDHCPIP($value);
    }

    public function saveDHCPMac($value) {
        $this->model->setDHCPMac($value);
    }

    public function restartDnsmasq() {
        $this->model->restartDnsmasq();
    }

}