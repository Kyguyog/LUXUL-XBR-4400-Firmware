<?php

class Webfilter_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(WEB_FILTER . DS . WEB_FILTER);
        $this->Load_Model(WEB_FILTER);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(WEB_FILTER);

        if (isset($_POST[APPLY_BUTTON])) {
            $this->save();
            header(LOCATION . WEB_FILTER_PAGE);
        }
    }

    public function addContent() {
        $this->addWebFilterView();
    }

    public function addWebFilterView() {
        $web_filter = EMPTY_STRING;
        $web_filter_view = new View();

        $this->assignWebFilteringOptionsView($web_filter_view);
        $this->assignWebFilteringInfoView($web_filter_view);

        $web_filter .= $web_filter_view->Render(WEB_FILTER . DS . SETUP, FALSE);
        $this->Assign(WEB_FILTER, $web_filter);
    }

    public function assignWebFilteringOptionsView($view) {
        $view->Assign(WEB_FILTERING_OPTIONS, $this->getWebFilteringOptions());
    }

    public function assignWebFilteringInfoView($view) {
        $check1 = $check2 = $check3 = $check3PriDNS = $check3SecondaryDNS = EMPTY_STRING;

        $wanPriDns = $this->getWANPriDNS(EMPTY_STRING);
        $wanSecondaryDns = $this->getWANSecondaryDNS(EMPTY_STRING);

        if ($wanPriDns == PRIMARY_DNS_208_67_222_222 && $wanSecondaryDns == SECONDARY_DNS_208_67_220_220) {
            $check1 = CHECKBOX_CHECKED;
        } else if ($wanPriDns == PRIMARY_DNS_208_67_222_123 && $wanSecondaryDns == SECONDARY_DNS_208_67_220_123) {
            $check2 = CHECKBOX_CHECKED;
        } else if ($wanPriDns != DEFAULT_PRIMARY_DNS) {
            $check3 = CHECKBOX_CHECKED;
            $check3PriDNS = $wanPriDns;
            $check3SecondaryDNS = $wanSecondaryDns;
        }

        $view->Assign(CHECK_BOX_1, $check1);
        $view->Assign(CHECK_BOX_2, $check2);
        $view->Assign(CHECK_BOX_3, $check3);
        $view->Assign(CHECK_BOX_3_PRIMARY_DNS, $check3PriDNS);
        $view->Assign(CHECK_BOX_3_SECONDARY_DNS, $check3SecondaryDNS);
    }

    public function getWebFilteringOptions() {
        $options = array(
            WEB_FILTERING_STATUS_DISABLED_KEY => WEB_FILTERING_STATUS_DISABLED_VAL,
            WEB_FILTERING_STATUS_ENABLED_KEY => WEB_FILTERING_STATUS_ENABLED_VAL,
        );

        return $this->helper->selectOption($options, $this->getWebFilteringStatus());
    }

    public function getWebFilteringStatus() {
        return $this->model->getWebFilteringStatus();
    }

    public function save() {
        if ($_POST[WEB_FILTERING_OPTIONS] == WEB_FILTERING_STATUS_ENABLED_KEY) {
            $this->saveWebFilteringStatus($_POST[WEB_FILTERING_OPTIONS]);
            $this->saveWebFilteringInfo(isset($_POST[CHECK_BOX_1]), isset($_POST[CHECK_BOX_2]), isset($_POST[CHECK_BOX_3]));

        } else {
            $this->deleteWebFilteringInfo();
        }

        $this->commit();
        $this->reloadNetwork();
        $this->reloadDnsMask();
    }

    public function saveWebFilteringStatus($value) {
        $this->model->setWebFilteringStatus($value);
    }

    public function saveWebFilteringInfo($checkBox1, $checkBox2, $checkBox3) {
        $networkDns = $dhcpLanOption = EMPTY_STRING;

        if ($checkBox1) {
            $networkDns = PRIMARY_DNS_208_67_222_222 . SPACE . SECONDARY_DNS_208_67_220_220;
            $dhcpLanOption = WEB_FILTERING_DHCP_OPTION_PREFIX_6 . COMMA . PRIMARY_DNS_208_67_222_222 . SPACE . WEB_FILTERING_DHCP_OPTION_PREFIX_6 . COMMA . SECONDARY_DNS_208_67_220_220;
        } else if ($checkBox2) {
            $networkDns = PRIMARY_DNS_208_67_222_123 . SPACE . SECONDARY_DNS_208_67_220_123;
            $dhcpLanOption = WEB_FILTERING_DHCP_OPTION_PREFIX_6 . COMMA . PRIMARY_DNS_208_67_222_123 . SPACE . WEB_FILTERING_DHCP_OPTION_PREFIX_6 . COMMA . SECONDARY_DNS_208_67_220_123;
        } else if ($checkBox3) {
            $networkDns = $_POST[CHECK_BOX_3_PRIMARY_DNS] . SPACE . $_POST[CHECK_BOX_3_SECONDARY_DNS];
            $dhcpLanOption = WEB_FILTERING_DHCP_OPTION_PREFIX_6 . COMMA . $_POST[CHECK_BOX_3_PRIMARY_DNS] . SPACE . WEB_FILTERING_DHCP_OPTION_PREFIX_6 . COMMA . $_POST[CHECK_BOX_3_SECONDARY_DNS];
        }

        $this->saveLanDns($networkDns);
        $this->saveWanDns(EMPTY_STRING, $networkDns);
        $this->saveWanPeerDns(EMPTY_STRING);
        $this->saveDhcpLanOption($dhcpLanOption);
    }

    public function deleteWebFilteringInfo() {
        $this->deleteLanDns();
        $this->deleteWanDns(EMPTY_STRING);
        $this->deleteWanPeerDns(EMPTY_STRING);
        $this->deleteDhcpLanOption();
        $this->deleteWebFilteringStatus();
    }

    public function saveDhcpLanOption($value) {
        $this->model->setDhcpLanOption($value);
    }

    public function deleteDhcpLanOption() {
        $this->model->deleteDhcpLanOption();
    }

    public function deleteWebFilteringStatus() {
        $this->model->deleteWebFilteringStatus();
    }

    public function reloadNetwork() {
        $this->model->reloadNetwork();
    }

    public function reloadDnsMask() {
        $this->model->reloadDnsMask();
    }

}