<?php

class Upgrade_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(UPGRADE . DS . UPGRADE);
        $this->Load_Model(UPGRADE);
    }

    public function display($status) {
        $errorMsg = EMPTY_STRING;

        if ($status != STATUS_SUCCESS && isset($_POST[UPGRADE]) && isset($_FILES[AP_FIRMWARE])) {
            $fileArray = $_FILES[AP_FIRMWARE];

            if ($fileArray[ERROR] != UPLOAD_ERR_OK) {
                $errorMsg = $this->getErrorMsg($fileArray[ERROR]);
            } else {
                if (move_uploaded_file($fileArray[TMP_NAME], TEMP_FILE_UPLOAD)) {
                    file_put_contents(FIRMWARE_NAME_FILE, TEMP_FILE_UPLOAD);

                    if ($this->checkModel() == EMPTY_STRING) {
                        if ($this->checkFileSum() == EMPTY_STRING) {
                            $this->upgrade();
                            header(LOCATION . UPGRADE_PROGRESS_PAGE . DS . $errorMsg);
                        } else {
                            $errorMsg = $this->checkFileSum();
                        }
                    } else {
                        $errorMsg = $this->checkModel();
                    }
                } else {
                    $errorMsg = FIRMWARE_FILE_CANNOT_PROCESS_MSG;
                }
            }

        }

        $this->addHeader();
        $this->addLeftNav();
        $this->addContent(PROGRESS_FALSE, $errorMsg, $status == STATUS_SUCCESS ? FIRMWARE_UPDATE_SUCCESS_MSG : EMPTY_STRING);
        $this->addHelpMessage(UPGRADE);
    }

    public function progress($errorMsg) {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent(PROGRESS_TRUE, $errorMsg, EMPTY_STRING);
        $this->addHelpMessage(UPGRADE);
    }

    public function addContent($progressBar, $errorMsg, $successMsg) {
        $upgrade = EMPTY_STRING;
        $upgrade_view = new View();

        if ($progressBar) {
            $upgrade .= $upgrade_view->Render(UPGRADE . DS . PROGRESS, FALSE);
        } else {
            $upgrade_view->Assign(ERROR_DISPLAY, $errorMsg != EMPTY_STRING ? TRUE : FALSE);
            $upgrade_view->Assign(ERROR_MSG, $errorMsg);
            $upgrade_view->Assign(SUCCESS_DISPLAY, $successMsg != EMPTY_STRING ? TRUE : FALSE);
            $upgrade_view->Assign(SUCCESS_MSG, $successMsg);

            $upgrade .= $upgrade_view->Render(UPGRADE . DS . DISPLAY, FALSE);
        }

        $this->Assign(UPGRADE, $upgrade);

    }

    public function getUpgradeModel() {
        return $this->model->getUpgradeModel();
    }

    public function checkModel() {
        $upgradeModel = $this->getUpgradeModel();
        $model = $this->getModel();

        return $upgradeModel != $model ? FIRMWARE_UPDATE_WRONG_MODEL_MSG . $model . FIRMWARE_UPDATE_TRY_AGAIN_MSG : EMPTY_STRING;
    }

    public function checkFileSum() {
        $md5Header = $this->getMD5Header();
        $md5File = preg_split(MD5_REGEX, $this->getMD5File());

        return $md5File[0] != $md5Header ? FIRMWARE_FILE_CORRUPTED_MSG : EMPTY_STRING;
    }

    public function getMD5Header() {
        return $this->model->getMD5Header();
    }

    public function getMD5File() {
        return $this->model->getMD5File();
    }

    public function upgrade() {
        $this->removeFileHeader();
        $this->upgradeFirmware();
    }

    public function removeFileHeader() {
        $this->model->removeFileHeader();
    }

    public function upgradeFirmware() {
        $this->model->upgradeFirmware();
    }

}