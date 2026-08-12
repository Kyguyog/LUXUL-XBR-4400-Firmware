<?php

class Log_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(LOG . DS . LOG);
        $this->Load_Model(LOG);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(LOG);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->saveLogFile();
        }
    }

    public function addContent() {
        $log = EMPTY_STRING;
        $log_view = new View();

        $logMessage = array_slice($this->getLogMessage(), -18, 18, false);

        $log_view->Assign(SYSTEM_LOG_OPTIONS, $this->getSysLogSizeOptions());
        $log_view->Assign(LOG_MSG, $logMessage);

        $log .= $log_view->Render(LOG . DS . MESSAGE, FALSE);
        $this->Assign(LOG, $log);

    }

    public function getSysLogSizeOptions() {
        $options = array(
            SYSTEM_LOG_SIZE_16_KEY => SYSTEM_LOG_SIZE_16_VAL,
            SYSTEM_LOG_SIZE_32_KEY => SYSTEM_LOG_SIZE_32_VAL,
            SYSTEM_LOG_SIZE_64_KEY => SYSTEM_LOG_SIZE_64_VAL,
        );

        return $this->helper->selectOption($options, $this->getSysLogSize());
    }

    public function getSysLogSize() {
        return $this->model->getSysLogSize();
    }

    public function getLogMessage() {
        return $this->model->getLogMessage();
    }

    public function saveSysLogSize($logSize) {
        $this->model->setSysLogSize($logSize);
    }

    public function saveLogSize($logSize) {
        $this->saveSysLogSize($logSize);
        $this->commit();
        $this->restartSystem();

        header(LOCATION . LOG_PAGE);
    }

    public function saveLogFile() {
        $logfile = fopen(TMP_SYS_LOG_FILE, FILE_WRITE_FLAG) or die(UNABLE_TO_OPEN_FILE_MSG);
        $logMsg = LUXUL . $this->getModel() . VERSION_SHORT . $this->getFirmwareVersion() . LOG_FILE. PHP_EOL;

        foreach ($this->getLogMessage() as $key => $message) {
            $logMsg .= $message . PHP_EOL;
        }

        fwrite($logfile, $logMsg);
        $this->downloadFile(TMP_SYS_LOG_FILE);
    }

    public function downloadFile($logfile) {
        header(PRAGMA_PUBLIC);
        header(EXPIRES_0);
        header(CACHE_CONTROL_CHECK);
        header(CACHE_CONTROL_PRIVATE, FALSE);
        header(CONTENT_TYPE_TEXT_PLAIN);
        header(CONTENT_DISPOSITION_ATTACHMENT . basename(LUXUL_SYS_LOG . date(DATE_FORMAT_FULL) . LOG_EXTENSION) . DOUBLE_QUOTE);
        header(CONTENT_TRANSFER_ENCODING);
        header(CONTENT_LENGTH . filesize($logfile));
        readfile($logfile);
    }
}