<?php

class Compliance_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(COMPLIANCE . DS . COMPLIANCE);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
    }

    public function addContent() {
        $compliance = EMPTY_STRING;
        $compliance_view = new View();

        $compliance .= $compliance_view->Render(COMPLIANCE . DS . INFO, FALSE);
        $this->Assign(COMPLIANCE, $compliance);
    }

}