<?php

class System_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(SYSTEM . DS . SYSTEM);
        $this->Load_Model(SYSTEM);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(SYSTEM);
    }

    public function addContent() {
        $system = EMPTY_STRING;
        $system_view = new View();

        $this->assignSysInfoView($system_view);
        $this->assignWanSettingsInfo($system_view, EMPTY_STRING);

        $system .= $system_view->Render(SYSTEM . DS . INFO, FALSE);

        $this->Assign(SYSTEM, $system);
    }

    public function assignSysInfoView($view) {
        $upTime = $this->getUpTime();

        $view->Assign(DEVICE_NAME, $this->getDeviceName());
        $view->Assign(CPU_USAGE, $this->getCPUUsage());
        $view->Assign(MEMORY_USAGE, $this->getMemoryUsage());
        $view->Assign(UPTIME, $upTime[DAYS] . DAY_SHORT_NAME . SPACE . $upTime[HOURS] . HOUR_SHORT_NAME . SPACE . $upTime[MINUTES] . MINUTE_SHORT_NAME);
        $view->Assign(FIRMWARE_VERSION, $this->getFirmwareVersion());
        $view->Assign(VERSION, $this->getVersion());
        $view->Assign(CURRENT_TIME, $this->getCurrentTime());

    }

    public function getDeviceName() {
        return $this->model->getHostName() . SPACE . $this->getModel();
    }

    public function getCPUUsage() {
        return $this->model->getCPUUsage() > 1 ? CPU_USAGE_100 : ($this->model->getCPUUsage() * 100) . PERCENTAGE;
    }

    public function getMemoryUsage() {
        $memoryUsageArray = $this->model->getMemoryUsage();
        $totalMemory = str_replace(KB_LOWER_CASE, SPACE, str_replace(MEMORY_TOTAL, SPACE, $memoryUsageArray[0]));
        $freeMemory = str_replace(KB_LOWER_CASE, SPACE, str_replace(MEMORY_FREE, SPACE, $memoryUsageArray[1]));
        return ceil((($totalMemory - $freeMemory) / $totalMemory) * 100) . PERCENTAGE;
    }

    function getUpTime() {
        $upTimeResult = $this->model->getUpTime();
        $days = sprintf(DATE_FORMAT, ($upTimeResult / (3600 * 24)));
        $hours = sprintf(DATE_FORMAT, (($upTimeResult % (3600 * 24)) / 3600));
        $min = sprintf(DATE_FORMAT, ($upTimeResult % (3600 * 24) % 3600) / 60);
        return array(
            DAYS => $days,
            HOURS => $hours,
            MINUTES => $min
        );
    }

}