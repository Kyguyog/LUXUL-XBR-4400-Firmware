<?php

class Reboot_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(REBOOT . DS . REBOOT);
    }

    public function display($prePage) {
        $this->addHeader();
        $this->addContent($prePage);
    }

    public function addContent($prePage) {
        $reboot = EMPTY_STRING;
        $reboot_view = new View();

        $reboot_view->Assign(LAN_IP_ADDR,  $this->getLanIPAddr());
        $reboot_view->Assign(PREVIOUS_PAGE, $prePage);

        $reboot .= $reboot_view->Render(REBOOT . DS . REDIRECT, FALSE);
        $this->Assign(REBOOT, $reboot);
    }

}