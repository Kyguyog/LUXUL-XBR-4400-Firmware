<?php

class Dmz_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(DMZ . DS . DMZ);
        $this->Load_Model(DMZ);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(DMZ);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->save();
        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . DMZ);
        }
    }

    public function addContent() {
        $this->addDMZView();
    }

    public function addDMZView() {
        $dmz = EMPTY_STRING;
        $dmz_view = new View();

        $this->assignRebootRequireView($dmz_view);
        $dmz_view->Assign(DMZ_STATUS, $this->getDMZStatusOptions());
        $dmz_view->Assign(DMZ_IP_ADDR, $this->getFirewallRedirectDestIP($this->getIndexByName(DMZ)));

        $dmz .= $dmz_view->Render(DMZ . DS . SETUP, FALSE);
        $this->Assign(DMZ, $dmz);
    }

    public function getDMZStatusOptions() {
        $options = array(
            DMZ_STATUS_DISABLED_KEY => DMZ_STATUS_DISABLED_VAL,
            DMZ_STATUS_ENABLED_KEY => DMZ_STATUS_ENABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getDMZStatus());
    }

    public function getDMZStatus() {
        return $this->model->getDMZStatus();
    }

    public function getIndexByName($value) {
        $index = 0;

        while ($this->getFirewallRedirect($index)) {
            if ($this->getFirewallRedirectName($index) == $value && $this->getFirewallRedirectPortForward($index) == PORT_FORWARD_NO) {
                break;
            } else {
                $index++;
            }
        }

        return $index;
    }

    public function save() {
        $this->saveDMZStatus();
        $this->deleteFirewallRedirectByName(DMZ, PORT_FORWARD_NO);

        if ($_POST[DMZ_STATUS] == DMZ_STATUS_ENABLED_KEY) {
            $this->saveFirewallRedirect();
        }

        $this->saveRebootRequired();
        $this->commit();
        header(LOCATION . DMZ_PAGE);
    }

    public function saveDMZStatus() {
        $this->model->setDMZStatus($_POST[DMZ_STATUS]);
    }

    public function saveFirewallRedirect() {
        $this->addFirewallRedirect();
        $this->saveFirewallRedirectPortForward(PORT_FORWARD_NO);
        $this->saveFirewallRedirectSrc();
        $this->saveFirewallRedirectProto(PROTOCAL_ALL_KEY);
        $this->saveFirewallRedirectDestIP($_POST[DMZ_IP_ADDR]);
        $this->saveFirewallRedirectName(DMZ);
    }

}