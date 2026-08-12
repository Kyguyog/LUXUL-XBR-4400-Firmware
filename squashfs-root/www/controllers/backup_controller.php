<?php

class Backup_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(BACKUP . DS . BACKUP);
        $this->Load_Model(BACKUP);
    }

    public function display($status) {
        $errorMsg = EMPTY_STRING;

        if ($status != STATUS_SUCCESS && isset($_POST[RESTORE]) && isset($_FILES[RESTORE_FILE])) {

            $fileArray = $_FILES[RESTORE_FILE];

            if ($fileArray[ERROR] != UPLOAD_ERR_OK) {
                $errorMsg = $this->getErrorMsg($fileArray[ERROR]);
            } else {
                move_uploaded_file($fileArray[TMP_NAME], TEMP_FILE_UPLOAD);

                if ($this->restoreFile() == RESTORE_FILE_CODE_0) {
                    $this->reboot();
                    header(LOCATION . RESTORE_PROGRESS_PAGE);
                } else if ($this->restoreFile() == RESTORE_FILE_CODE_1) {
                    $errorMsg = RESTORE_FILE_CODE_1_MSG;
                } else if ($this->restoreFile() == RESTORE_FILE_CODE_2) {
                    $errorMsg = RESTORE_FILE_CODE_2_MSG;
                } else if ($this->restoreFile() == RESTORE_FILE_CODE_3) {
                    $errorMsg = RESTORE_FILE_CODE_3_MSG;
                }
            }
        }

        $this->addHeader();
        $this->addLeftNav();
        $this->addContent(PROGRESS_FALSE, $errorMsg, $status == STATUS_SUCCESS ? RESTORE_CONFIGURATION_SUCCESS_MSG : EMPTY_STRING);
        $this->addHelpMessage(BACKUP);
    }

    public function restoreFile() {
        return $this->model->restoreFile();
    }

    public function forceRestoreFile() {
        $this->model->forceRestoreFile();
        $this->reboot();
        header(LOCATION . RESTORE_PROGRESS_PAGE);
    }

    public function progress() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addProgressContent();
        $this->addHelpMessage(BACKUP);
    }

    public function addProgressContent() {
        $progress = EMPTY_STRING;
        $progress_view = new View();

        $progress .= $progress_view->Render(BACKUP . DS . PROGRESS, FALSE);
        $this->Assign(BACKUP, $progress);
    }

    public function download() {
        $this->commit();

        $this->getBackupFile();
        $this->downloadFile(TMP_BACKUP_FILE);
    }

//    public function getBackupFile() {
//        $this->model->getBackupFile();
//    }

//    public function downloadFile($fileName) {
//        header(PRAGMA_PUBLIC);
//        header(EXPIRES_0);
//        header(CACHE_CONTROL_CHECK);
//        header(CACHE_CONTROL_PRIVATE, FALSE);
//        header(CONTENT_TYPE_FORCE_DOWNLOAD);
//        header(CONTENT_TYPE_OCTET_STREAM);
//        header(CONTENT_TYPE_DOWNLOAD);
//        header(CONTENT_DESCRIPTION_FILE_TRANSFER);
//        header(CONTENT_DISPOSITION_ATTACHMENT . basename(BACKUP_FILE . $this->getModel() . BACKUP_FILE_LXC_EXTENTION) . DOUBLE_QUOTE);
//        header(CONTENT_TRANSFER_ENCODING);
//        header(CONTENT_LENGTH . filesize($fileName));
//        readfile($fileName);
//    }

    public function addContent($progressCheck, $errorMsg, $successMsg) {
        $backup = EMPTY_STRING;
        $backup_view = new View();

        if ($progressCheck) {
            $this->reboot();
            $backup .= $backup_view->Render(BACKUP . DS . PROGRESS, FALSE);
        } else {
            $backup_view->Assign(ERROR_DISPLAY, $errorMsg != EMPTY_STRING ? TRUE : FALSE);
            $backup_view->Assign(ERROR_MSG, $errorMsg);
            $backup_view->Assign(SUCCESS_DISPLAY, $successMsg != EMPTY_STRING ? TRUE : FALSE);
            $backup_view->Assign(SUCCESS_MSG, $successMsg);

            $backup .= $backup_view->Render(BACKUP . DS . DISPLAY, FALSE);
        }

        $this->Assign(BACKUP, $backup);

    }

}