<?php

class Cmdline_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(CMDLINE . DS . CMDLINE);
    }

    public function display($query1 = NULL, $query2 = NULL) {
        $command = isset($_POST[COMMAND]) ? trim($_POST[COMMAND]) : EMPTY_STRING;
        $output = EMPTY_STRING;

        if ($command != EMPTY_STRING) {
            $output = shell_exec($command . ' 2>&1');
        }

        $this->addHeader();
        $this->addLeftNav();
        $this->addContent($command, $output);
        $this->addHelpMessage(CMDLINE);
    }

    public function addContent($command, $output) {
        $cmdline = EMPTY_STRING;
        $cmdline_view = new View();

        $cmdline_view->Assign(COMMAND, $command);
        $cmdline_view->Assign(RESULTS, $output);

        $cmdline .= $cmdline_view->Render(CMDLINE . DS . INFO, FALSE);
        $this->Assign(CMDLINE, $cmdline);
    }

}
