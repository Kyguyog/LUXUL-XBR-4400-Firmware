<?php

class Iperf_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(IPERF . DS . IPERF);
        $this->Load_Model(IPERF);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $iperfMessage = EMPTY_STRING;

        if(isset($_POST[START_BUTTON]) ){
            $this->startIperf($_POST[RUN_FOR] * 60);
            $iperfMessage = IPERF_RUN_FOR_MSG.$_POST[RUN_FOR].SPACE;
            $iperfMessage .= $_POST[RUN_FOR] > 1 ? HOURS : HOUR;

        } else if (isset($_POST[STOP_BUTTON]) ) {
            $this->stopIperf();
            $iperfMessage = IPERF_STOPPED_MSG;
        }

        $this->addHeader();
        $this->addLeftNav();
        $this->addContent($iperfMessage);
        $this->addHelpMessage(IPERF);
    }

    public function addContent($iperfMessage) {
        $iperf = EMPTY_STRING;
        $iperf_view = new View();

        $iperfStatus = FALSE;
        $iperfStatusVal = $this->getIperfStatusVal();

        if ($this->model->getIperfStatus()) {
            $iperfStatus = TRUE;
        }

        $iperfHoursOptions = $this->getIperfHoursOptions();

        $iperf_view->Assign(IPERF_STATUS_VAL, $iperfStatusVal);
        $iperf_view->Assign(IPERF_STATUS, $iperfStatus);
        $iperf_view->Assign(IPERF_HOURS_OPTIONS, $iperfHoursOptions);
        $iperf_view->Assign(IPERF_MSG, $iperfMessage);


        $iperf .= $iperf_view->Render(IPERF . DS . INFO, FALSE);
        $this->Assign(IPERF, $iperf);

    }

    public function getIperfStatusVal() {
        return $this->model->getIperfStatus() == FALSE ? IPERF_NOT_RUNNING : IPERF_RUNNING;
    }

    public function getIperfHoursOptions() {
        $options = array(
            HOUR_1_KEY => HOUR_1_VAL,
            HOUR_2_KEY => HOUR_2_VAL,
            HOUR_3_KEY => HOUR_3_VAL
        );

        return $this->helper->selectOption($options, HOUR_1_KEY);
    }

    public function startIperf($minutes) {
        $this->model->startIperf($minutes);
        sleep(10);
    }

    public function stopIperf() {
        $this->model->stopIperf();
    }

}