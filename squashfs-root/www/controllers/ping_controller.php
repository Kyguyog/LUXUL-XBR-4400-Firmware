<?php

class Ping_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(PING . DS . PING);
    }

    public function display($ipAddr, $output) {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent($ipAddr, $output);
        $this->addHelpMessage(PING);
    }

    public function addContent($ipAddr, $output) {
        $ping = EMPTY_STRING;
        $ping_view = new View();

        $ping_view->Assign(IP_ADDRESS, $ipAddr);
        $ping_view->Assign(RESULTS, explode(PHP_EOL, $output));

        $ping .= $ping_view->Render(PING . DS . INFO, FALSE);
        $this->Assign(PING, $ping);
    }

    public function progress($ipAddr) {
        $output = shell_exec(PING_COMMAND . $ipAddr);
        $this->display($ipAddr, $output);
    }

}


