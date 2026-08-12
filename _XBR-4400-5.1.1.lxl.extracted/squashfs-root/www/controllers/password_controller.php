<?php

class Password_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(PASSWORD . DS . PASSWORD);
        $this->Load_Model(PASSWORD);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(PASSWORD);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->save();
        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . PASSWORD);
        }
    }

    public function addContent() {
        $password = EMPTY_STRING;
        $password_view = new View();

        $password_view->Assign(REBOOT_REQUIRED, $this->checkRebootRequired());
        $password_view->Assign(ADMIN_PASSWORD, $this->getAdminPassword());

        $password .= $password_view->Render(PASSWORD . DS . FORM, FALSE);
        $this->Assign(PASSWORD, $password);

    }

    public function getAdminPassword() {
        return $this->model->getAdminPassword();
    }

    public function save() {
        if ($_POST[NEW_PASSWORD] == $_POST[CONFIRMATION_PASSWORD]) {
            $this->saveAdminPassword();
            $this->saveRebootRequired();

            $this->commit();
            header(LOCATION . PASSWORD_PAGE);
        }
    }

    public function saveAdminPassword() {
        $this->model->setAdminPassword($_POST[NEW_PASSWORD]);
    }

}