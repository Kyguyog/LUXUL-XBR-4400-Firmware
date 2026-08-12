<?php

class Factory_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(FACTORY . DS . FACTORY);
        $this->Load_Model(FACTORY);
    }

    public function display() {
        if (isset($_POST[WORD_DEFAULT])) {
            header(LOCATION . FACTORY_PROGRESS_PAGE);
        }

        $this->addHeader();
        $this->addLeftNav();
        $this->addContent(PROGRESS_FALSE);
        $this->addHelpMessage(FACTORY);
    }

    public function progress() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent(PROGRESS_TRUE);
        $this->addHelpMessage(FACTORY);

        $this->restoreFactoryDefault();
    }

    public function addContent($progressBar) {
        $factory = EMPTY_STRING;
        $factory_view = new View();

        $factory_view->Assign(MODEL, $this->getModel());
        $factory_view->Assign(FACTORY_DEFAULT_REQUIRED, $this->getMultiWanWizardStatus() == MULTI_WAN_WIZARD_STATUS_0 ? FALSE : TRUE);
        $progressBar ? $factory .= $factory_view->Render(FACTORY . DS . PROGRESS, FALSE) : $factory .= $factory_view->Render(FACTORY . DS . DISPLAY, FALSE);
        $this->Assign(FACTORY, $factory);
    }

    public function addHeader() {
        $header = EMPTY_STRING;
        $header_view = new View();

        $header_view->Assign(MODEL, $this->getModel());
        $header_view->Assign(VERSION, $this->getVersion());
        $header_view->Assign(FIRMWARE_VERSION, $this->getFirmwareVersion());

        $header .= $header_view->Render(HEADER, FALSE);
        $this->Assign(HEADER, $header);
    }

    public function download() {
        $this->commit();

        $this->getBackupFile();
        $this->downloadFile(TMP_BACKUP_FILE);
    }

    public function getModel() {
        return $this->model->getModel();
    }

    public function getVersion() {
        return $this->model->getVersion();
    }

    public function getFirmwareVersion() {
        return $this->model->getFirmwareVersion();
    }

//    public function getFactoryDefaultRequired() {
//        return $this->model->getFactoryDefaultRequired();
//    }

    public function restoreFactoryDefault() {
        $this->model->restoreFactoryDefault();
    }

}