<?php

class Routerlimits_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(ROUTER_LIMITS . DS . ROUTER_LIMITS);
        $this->Load_Model(ROUTER_LIMITS);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(ROUTER_LIMITS);

        if (isset($_POST[APPLY_BUTTON])) {
            $this->save();
        }
    }

    public function addContent() {
        $this->addRouterLimitsView();
    }

    public function addRouterLimitsView() {
        $router_limits = EMPTY_STRING;
        $router_limits_view = new View();

        $router_limits_view->Assign(ROUTER_LIMITS_OPTIONS, $this->getRouterLimitsOptions());
        $router_limits_view->Assign(ROUTER_LIMITS_STATUS, $this->getRouterLimitsStatus());
        $router_limits_view->Assign(ROUTER_LIMITS_DEVICE_ID, $this->getRouterLimitsDeviceId());

        $router_limits .= $router_limits_view->Render(ROUTER_LIMITS . DS . SETUP, FALSE);
        $this->Assign(ROUTER_LIMITS, $router_limits);
    }

    public function getRouterLimitsOptions() {
        $options=array(
            ROUTER_LIMITS_DISABLED_KEY => ROUTER_LIMITS_DISABLED_VAL,
            ROUTER_LIMITS_ENABLED_KEY => ROUTER_LIMITS_ENABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getRouterLimits());
    }

    public function getRouterLimitsStatus() {
        return $this->model->getRouterLimitsStatus();
    }

    public function getRouterLimitsDeviceId() {
        return $this->model->getRouterLimitsDeviceId();
    }

    public function save() {
        if ($_POST[ROUTER_LIMITS_OPTIONS] == ROUTER_LIMITS_ENABLED_KEY) {
            $this->saveRouterLimits($_POST[ROUTER_LIMITS_OPTIONS]);
            $this->saveWanAccelerationStatus(WAN_ACCELERATION_DISABLED_KEY);
            $this->commit();

            $this->restartLuxulCtf();
            $this->startTrlc();

            header(LOCATION . REBOOT_PAGE . DS . ROUTER_LIMITS);
        } else {
            $this->saveRouterLimits($_POST[ROUTER_LIMITS_OPTIONS]);
            $this->commit();

            $this->stopTrlc();
            header(LOCATION . PARENTAL_CONTROL_PAGE);
        }
    }

    public function saveRouterLimits($value) {
        $this->model->setRouterLimits($value);
    }

    public function startTrlc() {
        $this->model->startTrlc();
    }

    public function stopTrlc() {
        $this->model->stopTrlc();
    }
}