<?php

class Led_Controller extends Controller{

    public function __construct() {
        parent::__construct();

        $this->Load_View(LED.DS.LED);
        $this->Load_Model(LED);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(LED);
    }

    public function addContent() {
        $led = EMPTY_STRING;
        $led_view = new View();

        $ledMessage = FALSE;

        if ($this->getLEDStatus() == LED_STATUS_ON_VAL) {
            $ledMessage = TRUE;
        }

        $ledStatusOptions = $this->getLEDStatusOptions();

        $led_view->Assign('ledStatusOptions', $ledStatusOptions);
        $led_view->Assign('ledMessage', $ledMessage);

        $led .= $led_view->Render(LED.DS.LED_CONTROL, FALSE);
        $this->Assign(LED, $led);

    }

    public function getLEDStatusOptions() {
        $options=array(
            LED_STATUS_ON_VAL => LED_STATUS_ON_VAL,
            LED_STATUS_OFF_VAL => LED_STATUS_OFF_VAL,
        );

        return $this->helper->selectOption($options, $this->getLEDStatus());
    }

    public function getLEDStatus() {
        return $this->model->getLEDStatus() == LED_STATUS_ON_KEY ? LED_STATUS_ON_VAL : LED_STATUS_OFF_VAL;
    }

    public function save($ledStatus) {
        $this->saveLEDStatus($ledStatus);
        $this->commit();

        $this->updateLEDStatus();

        header(LOCATION.LED_CONTROL_PAGE);
    }

    public function saveLEDStatus($ledStatus) {
        $this->model->setLEDStatus($ledStatus == LED_STATUS_ON_VAL ? LED_STATUS_ON_KEY : LED_STATUS_OFF_KEY);
    }

    public function updateLEDStatus() {
        $this->model->updateLEDStatus();
    }

    public function commit() {
        $this->model->commit();
    }
}