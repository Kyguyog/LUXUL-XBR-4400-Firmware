<?php

class Trace_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(TRACE . DS . TRACE);
    }

    public function display($ipAddr, $output) {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent($ipAddr, $output);
        $this->addHelpMessage(TRACE);
    }

    public function addContent($ipAddr, $output) {
        $trace = EMPTY_STRING;
        $trace_view = new View();

        $trace_view->Assign(IP_ADDRESS, $ipAddr);
        $trace_view->Assign(RESULTS, explode(PHP_EOL, $output));

        $trace .= $trace_view->Render(TRACE . DS . INFO, FALSE);
        $this->Assign(TRACE, $trace);
    }

    public function progress($ipAddr) {
        $output = shell_exec(TRACE_ROUTE_COMMAND . $ipAddr);
        $this->display($ipAddr, $output);
    }

}


