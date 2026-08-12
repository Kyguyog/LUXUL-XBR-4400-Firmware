<?php

class Advance_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(ADVANCE . DS . ADVANCE);
        $this->Load_Model(ADVANCE);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(ADVANCE);

        if (isset($_POST[SAVE_WAN_ACCELERATION])) {
            $this->saveWanAccelerationStatus($_POST[WAN_ACCELERATION_OPTIONS]);
            $this->commit();
            $this->restartLuxulCtf();
            header(LOCATION . ADVANCE_PAGE);

        } else if (isset($_POST[SAVE_WAN_PING])) {
            $this->saveWanPingStatus();
            $this->saveRebootRequired();
            $this->commit();

            header(LOCATION . ADVANCE_PAGE);

        } else if (isset($_POST[SAVE_IPV6_WAN])) {
            $this->saveWanIpv6(EMPTY_STRING, $_POST[IPV6_STATUS_OPTIONS]);
            $this->saveRebootRequired();
            $this->commit();

            header(LOCATION . ADVANCE_PAGE);
        } else if (isset($_POST[SAVE_PPTP_PASSTHRU])) {
            $this->savePPTPPassthruInfo();
            $this->saveRebootRequired();
            $this->commit();

            header(LOCATION . ADVANCE_PAGE);
        } else if (isset($_POST[SAVE_PORT_MONITORING])) {
            $this->savePortMonitor($_POST[PORT_MONITORING_OPTIONS]);
            $this->saveRebootRequired();
            $this->commit();

            header(LOCATION . ADVANCE_PAGE);
        } else if (isset($_POST[SAVE_WAN_DELAY])) {
            $this->saveWanDelay($_POST[WAN_DELAY]);
            $this->saveRebootRequired();
            $this->commit();

            header(LOCATION . ADVANCE_PAGE);
        } else if (isset($_POST[SAVE_BLOCK_SELF_ASSIGNED_IP])) {
            $this->saveBlockSelfAssignedIp();
        }

        else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . ADVANCE);
        }
    }

    public function addContent() {
        $this->addAdvanceView();
    }

    public function addAdvanceView() {
        $advance = EMPTY_STRING;
        $advance_view = new View();

        $this->assignRebootRequireView($advance_view);
        $this->assignWanAccelationOptions($advance_view);
        $this->assignWanPingOptions($advance_view);
        $this->assignIPV6StatusInfo($advance_view, EMPTY_STRING);
        $this->assignPPTPPathruInfo($advance_view);
        $this->assignPortMonitoringOptions($advance_view);
        $this->assignWanDelay($advance_view) ;
        $this->assignBlockSelfAssignedIp($advance_view);

        $advance .= $advance_view->Render(ADVANCE . DS . SETUP, FALSE);
        $this->Assign(ADVANCE, $advance);
    }

    public function assignWanAccelationOptions($view) {
        $view->Assign(WAN_ACCELERATION_OPTIONS, $this->getWanAccelerationOptions());
        $view->Assign(ROUTER_LIMITS_STATUS, $this->getRouterLimits() == ROUTER_LIMITS_ENABLED_KEY ? TRUE : FALSE);
        $view->Assign(MULTI_WAN_STATUS, $this->getMultiWanStatus() == MULTI_WAN_STATUS_ENABLED_KEY ? TRUE : FALSE);
    }

    public function assignWanPingOptions($view) {
        $view->Assign(WAN_PING_OPTIONS, $this->getWanPingOptions());
    }

    public function assignPPTPPathruInfo($view) {
        $view->Assign(PPTP_PASSTHRU_OPTIONS, $this->getPPTPPassthruOptions());
        $view->Assign(SERVER_ADDR, $this->getServerAddr());
    }

    public function assignPortMonitoringOptions($view) {
        $view->Assign(PORT_MONITORING_OPTIONS, $this->getPortMonitorOptions());
    }

    public function assignWanDelay($view) {
        $view->Assign(WAN_DELAY, $this->getWanDelay());
    }

    public function assignBlockSelfAssignedIp($view) {
        $view->Assign(BLOCK_SELF_ASSIGNED_IP_OPTIONS, $this->getBlockSelfAssignedIpOptions());
    }

    public function getPortMonitorOptions() {
        $options = array(
            PORT_MONITOR_ENABLED_KEY => PORT_MONITOR_ENABLED_VAL,
            PORT_MONITOR_DISABLED_KEY => PORT_MONITOR_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getPortMonitor());
    }

    public function getWanAccelerationOptions() {
        $options = array(
            WAN_ACCELERATION_ENABLED_KEY => WAN_ACCELERATION_ENABLED_VAL,
            WAN_ACCELERATION_DISABLED_KEY => WAN_ACCELERATION_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getWanAccelerationStatus());
    }

    public function getWanAccelerationStatus() {
        return $this->model->getWanAccelerationStatus();
    }

    public function getWanPingOptions() {
        $options = array(
            WAN_PING_ENABLED_KEY => WAN_PING_ENABLED_VAL,
            WAN_PING_DISABLED_KEY => WAN_PING_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getWanPingStatus());
    }

    public function getWanPingStatus() {
        return $this->model->getWanPingStatus();
    }

    public function getIPV6WanOptions() {
        $options = array(
            IPV6_WAN_ENABLED_KEY => IPV6_WAN_ENABLED_VAL,
            IPV6_WAN_DISABLED_KEY => IPV6_WAN_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getIPV6WanStatus());
    }

    public function getIPV6WanStatus() {
        return $this->model->getIPV6WanStatus();
    }

    public function getPPTPPassthruOptions() {
        $options = array(
            PPTP_PASSTHRU_ENABLED_KEY => PPTP_PASSTHRU_ENABLED_VAL,
            PPTP_PASSTHRU_DISABLED_KEY => PPTP_PASSTHRU_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getPPTPPassthruStatus());
    }

    public function getBlockSelfAssignedIpOptions() {
        $options = array(
            BLOCK_SELF_ASSIGNED_IP_ENABLED_KEY => BLOCK_SELF_ASSIGNED_IP_ENABLED_VAL,
            BLOCK_SELF_ASSIGNED_IP_DISABLED_KEY => BLOCK_SELF_ASSIGNED_IP_DISABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getBlockSelfAssignedIp());
    }

    public function getPPTPPassthruStatus() {
        return $this->model->getPPTPPassthruStatus();
    }

    public function getServerAddr() {
        return $this->model->getServerAddr();
    }

    public function getPortMonitor() {
        return $this->model->getPortMonitor();
    }

    public function getWanDelay() {
        return $this->model->getWanDelay();
    }

    public function getBlockSelfAssignedIp() {
        return $this->model->getBlockSelfAssignedIp();
    }

    public function saveWanPingStatus() {
        $this->model->setWanPingStatus($_POST[WAN_PING_OPTIONS]);
    }

    public function saveIPV6WanStatus() {
        $this->model->setIPV6WanStatus($_POST[IPV6_WAN_OPTIONS]);
    }

    public function savePPTPPassthruInfo() {
        $this->savePPTPPassthruStatus();
        $this->deletePPTPInfo();

        if ($_POST[PPTP_PASSTHRU_OPTIONS] == PPTP_PASSTHRU_ENABLED_KEY) {
            $this->saveFirewallUserInfo($_POST[SERVER_ADDR]);
            $this->saveFirewallRedirect($_POST[SERVER_ADDR]);
        }
    }

    public function savePPTPPassthruStatus() {
        $this->model->setPPTPPassthruStatus($_POST[PPTP_PASSTHRU_OPTIONS]);
    }

    public function saveWanDelay($value) {
        $this->model->setWanDelay($value);
    }

    public function deletePPTPInfo() {
        $this->deleteFireWallUserInfo();
        $this->deleteFirewallRedirectByName(PPTP_PASSTHRU, PORT_FORWARD_NO);
    }

    public function saveFirewallUserInfo($serverAddr) {
        $this->model->saveFirewallUserInfo($serverAddr);
    }

    public function saveFirewallRedirect($serverAddr) {
        $this->addFirewallRedirect();
        $this->saveFirewallRedirectSrc();
        $this->saveFirewallRedirectPortForward(PORT_FORWARD_NO);
        $this->saveFirewallRedirectProto(PROTOCAL_BOTH_KEY);
        $this->saveFirewallRedirectSrcPort(PORT_1723);
        $this->saveFirewallRedirectDestPort(PORT_1723);
        $this->saveFirewallRedirectTarget();
        $this->saveFirewallRedirectDest();
        $this->saveFirewallRedirectDestIp($serverAddr);
        $this->saveFirewallRedirectName(PPTP_PASSTHRU);
    }

    public function saveBlockSelfAssignedIp() {
        if (urldecode($_POST[BLOCK_SELF_ASSIGNED_IP_OPTIONS]) == BLOCK_SELF_ASSIGNED_IP_ENABLED_KEY) {
            $this->addFirewallRule();
            $this->saveFirewallRuleName(SELF_ASSIGNED_IP);
            $this->saveFirewallRuleSrc(LAN);
            $this->saveFirewallRuleSrcIp(SELF_ASSIGNED_IP_DEFAULT);
            $this->saveFirewallRuleProto(PROTOCAL_ALL_KEY);
            $this->saveFirewallRuleTarget(DROP);

        } else {
            $this->deleteFirewallRuleByName(SELF_ASSIGNED_IP);
        }

        $this->saveRebootRequired();
        $this->commit();

        header(LOCATION . ADVANCE_PAGE);
    }

    public function deleteFireWallUserInfo() {
        $this->model->deleteFireWallUserInfo();
    }

    public function restartLuxulCtf() {
        $this->model->restartLuxulCtf();
    }

}