<?php

class Timezone_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(TIMEZONE . DS . TIMEZONE);
        $this->Load_Model(TIMEZONE);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(TIMEZONE);

        if (isset($_POST[APPLY_BUTTON])) {
            $this->apply();
        }
    }

    public function addContent() {
        $this->addTimezoneView();
    }

    public function addTimezoneView() {
        $timezone = EMPTY_STRING;
        $timezone_view = new View();

        $timezone_view->Assign(TIMEZONE_FLAG, $this->getTimeZoneFlag());
        $timezone_view->Assign(CURRENT_TIME, $this->getCurrentTime());
        $timezone_view->Assign(TIMEZONE_OPTIONS, $this->getTimeZoneOptions());

        $this->deleteTimeZoneFlag();

        $timezone .= $timezone_view->Render(TIMEZONE . DS . SETUP, FALSE);
        $this->Assign(TIMEZONE, $timezone);
    }

    public function getTimeZoneOptions() {
        $options = array(
            EMPTY_STRING => SELECT_TIME_ZONE,
            TIMEZONE_KWAJALEIN_KEY => TIMEZONE_KWAJALEIN_VAL,
            TIMEZONE_MIDWAY_ISLAND_KEY => TIMEZONE_MIDWAY_ISLAND_VAL,
            TIMEZONE_HAWAII_KEY => TIMEZONE_HAWAII_VAL,
            TIMEZONE_ALASKA_KEY => TIMEZONE_ALASKA_VAL,
            TIMEZONE_PACIFIC_KEY => TIMEZONE_PACIFIC_VAL,
            TIMEZONE_ARIZONA_KEY => TIMEZONE_ARIZONA_VAL,
            TIMEZONE_MOUNTAIN_KEY => TIMEZONE_MOUNTAIN_VAL,
            TIMEZONE_MEXICO_KEY => TIMEZONE_MEXICO_VAL,
            TIMEZONE_CENTRAL_KEY => TIMEZONE_CENTRAL_VAL,
            TIMEZONE_PANAMA_KEY => TIMEZONE_PANAMA_VAL,
            TIMEZONE_EASTERN_KEY => TIMEZONE_EASTERN_VAL,
            TIMEZONE_PUERTO_RICO_KEY => TIMEZONE_PUERTO_RICO_VAL,
            TIMEZONE_HALIFAX_KEY => TIMEZONE_HALIFAX_VAL,
            TIMEZONE_NEWFOUNDLAND_KEY => TIMEZONE_NEWFOUNDLAND_VAL,
            TIMEZONE_BRAZIL_EAST_KEY => TIMEZONE_BRAZIL_EAST_VAL,
            TIMEZONE_ARGENTINA_KEY => TIMEZONE_ARGENTINA_VAL,
            TIMEZONE_SOUTH_GEORGIA_KEY => TIMEZONE_SOUTH_GEORGIA_VAL,
            TIMEZONE_AZORES_KEY => TIMEZONE_AZORES_VAL,
            TIMEZONE_UK_KEY => TIMEZONE_UK_VAL,
            TIMEZONE_FRANCE_GERMANY_POLAND_KEY => TIMEZONE_FRANCE_GERMANY_POLAND_VAL,
            TIMEZONE_GREECE_FINLAND_UKRAINE_KEY => TIMEZONE_GREECE_FINLAND_UKRAINE_VAL,
            TIMEZONE_SOUTH_AFRICA_KEY => TIMEZONE_SOUTH_AFRICA_VAL,
            TIMEZONE_IRAQ_JORDAN_KUWAIT_KEY => TIMEZONE_IRAQ_JORDAN_KUWAIT_VAL,
            TIMEZONE_MOSCOW_KEY => TIMEZONE_MOSCOW_VAL,
            TIMEZONE_DUBAI_KEY => TIMEZONE_DUBAI_VAL,
            TIMEZONE_PAKISTAN_KEY => TIMEZONE_PAKISTAN_VAL,
            TIMEZONE_INDIA_KEY => TIMEZONE_INDIA_VAL,
            TIMEZONE_BANGLADESH_KEY => TIMEZONE_BANGLADESH_VAL,
            TIMEZONE_RUSSIA_THAILAND_KEY => TIMEZONE_RUSSIA_THAILAND_VAL,
            TIMEZONE_CHINA_HK_TAIWAN_KEY => TIMEZONE_CHINA_HK_TAIWAN_VAL,
            TIMEZONE_JAPAN_KOREA_KEY => TIMEZONE_JAPAN_KOREA_VAL,
            TIMEZONE_AUSTRALIA_KEY => TIMEZONE_AUSTRALIA_VAL,
            TIMEZONE_AUSTRALIA_SYDNEY_KEY => TIMEZONE_AUSTRALIA_SYDNEY_VAL,
            TIMEZONE_NEW_ZEALAND_KEY => TIMEZONE_NEW_ZEALAND_VAL
        );

        return $this->helper->selectOption($options, $this->getTimeZone());
    }

    public function getTimeZone() {
        return $this->model->getTimeZone();
    }

    public function getTimeZoneFlag() {
        return $this->model->getTimeZoneFlag();
    }

    public function apply() {
        $this->saveTimeZone();
        $this->commit();
        $this->saveTimeZoneFlag();

        $this->restartSystem();
        header(LOCATION . TIMEZONE_PAGE);
    }

    public function saveTimeZone() {
        $this->model->setTimeZone($_POST[TIMEZONE_OPTIONS]);
    }

    public function saveTimeZoneFlag() {
        $this->model->setTimeZoneFlag();
    }

    public function deleteTimeZoneFlag() {
        $this->model->deleteTimeZoneFlag();
    }

}