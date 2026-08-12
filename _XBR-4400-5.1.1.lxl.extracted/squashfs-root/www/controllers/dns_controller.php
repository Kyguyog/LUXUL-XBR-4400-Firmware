<?php

class Dns_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(DNS . DS . DNS);
        $this->Load_Model(DNS);
        $this->Load_Helper(HELPER);
    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();
        $this->addHelpMessage(DNS);

        if (isset($_POST[SAVE_BUTTON])) {
            $this->save();
        } else if (isset($_POST[REBOOT_BUTTON])) {
            $this->reboot();
            header(LOCATION . REBOOT_PAGE . DS . DNS);
        }
    }

    public function addContent() {
        $this->addDNSView();
    }

    public function addDNSView() {
        $dns = EMPTY_STRING;
        $dns_view = new View();

        $this->assignRebootRequireView($dns_view);
        $this->assignDNSStatus($dns_view);
        $this->assignDNSEnabledInfo($dns_view);

        $dns .= $dns_view->Render(DNS . DS . SETUP, FALSE);
        $this->Assign(DNS, $dns);
    }

    public function assignDNSStatus($view) {
        $view->Assign(DNS_STATUS, $this->getDNSStatusOptions());
    }

    public function assignDNSEnabledInfo($view) {
        $view->Assign(SERVICE_PROVIDER, $this->getServiceProviderOptions());
        $view->Assign(DNS_HOST_NAME, $this->getDNSHostname());
        $view->Assign(DNS_USER_NAME, $this->getDNSUsername());
        $view->Assign(DNS_PASSWORD, $this->getDNSPassword());
        $view->Assign(DNS_INTERVAL, $this->getDNSInterval());
        $view->Assign(DNS_UPDATE_INTERVAL, $this->getDNSUpdateInterval());
    }

    public function getDNSStatusOptions() {
        $options = array(
            DNS_STATUS_DISABLED_KEY => DNS_STATUS_DISABLED_VAL,
            DNS_STATUS_ENABLED_KEY => DNS_STATUS_ENABLED_VAL
        );

        return $this->helper->selectOption($options, $this->getDNSStatus());
    }

    public function getDNSStatus() {
        return $this->model->getDNSStatus();
    }

    public function getServiceProviderOptions() {
        $options = array(
            DNS_SERVICE_PROVIDER_NO_IP => DNS_SERVICE_PROVIDER_NO_IP,
            DNS_SERVICE_PROVIDER_DYNDS => DNS_SERVICE_PROVIDER_DYNDS,
            DNS_SERVICE_PROVIDER_FREEDNS => DNS_SERVICE_PROVIDER_FREEDNS
        );

        return $this->helper->selectOption($options, $this->getServiceProvider());
    }

    public function getServiceProvider() {
        return $this->model->getServiceProvider();
    }

    public function getDNSHostname() {
        return $this->model->getDNSHostname();
    }

    public function getDNSUsername() {
        return $this->model->getDNSUsername();
    }

    public function getDNSPassword() {
        return $this->model->getDNSPassword();
    }

    public function getDNSInterval() {
        return $this->model->getDNSInterval();
    }

    public function getDNSUpdateInterval() {
        return $this->model->getDNSUpdateInterval();
    }

    public function save() {
        $this->saveDynamicDnsInfo();
        $this->saveDNSStatusInfo();

        $this->saveRebootRequired();
        $this->commit();
        $this->runHotplugScript();
        header(LOCATION . DNS_PAGE);
    }

    public function saveDynamicDnsInfo() {
        $this->saveDNSService();
        $this->saveDNSInterface();
        $this->saveDNSForceUnit();
        $this->saveDNSCheckUnit();
        $this->saveDNSRetryInterval();
        $this->saveDNSRetryUnit();
        $this->saveDNSIPSource();
        $this->saveDNSIPUrl();
    }

    public function saveDNSStatusInfo() {
        $this->saveDNSStatus();
        $this->saveServiceProvider();
        $this->saveDNSHostname();
        $this->saveDNSUsername();
        $this->saveDNSPassword();
        $this->saveDNSInterval();
        $this->saveDNSUpdateInterval();
    }

    public function saveDNSService() {
        $this->model->setDNSService();
    }

    public function saveDNSInterface() {
        $this->model->setDNSInterface();
    }

    public function saveDNSForceUnit() {
        $this->model->setDNSForceUnit();
    }

    public function saveDNSCheckUnit() {
        $this->model->setDNSCheckUnit();
    }

    public function saveDNSRetryInterval() {
        $this->model->setDNSRetryInterval();
    }

    public function saveDNSRetryUnit() {
        $this->model->setDNSRetryUnit();
    }

    public function saveDNSIPSource() {
        $this->model->setDNSIPSource();
    }

    public function saveDNSIPUrl() {
        $this->model->setDNSIPUrl();
    }

    public function saveDNSStatus() {
        $this->model->setDNSStatus($_POST[DNS_STATUS]);
    }

    public function saveServiceProvider() {
        $this->model->setServiceProvider($_POST[SERVICE_PROVIDER]);
    }

    public function saveDNSHostname() {
        $this->model->setDNSHostname($_POST[DNS_HOST_NAME]);
    }

    public function saveDNSUsername() {
        $this->model->setDNSUsername($_POST[DNS_USER_NAME]);
    }

    public function saveDNSPassword() {
        $this->model->setDNSPassword($_POST[DNS_PASSWORD]);
    }

    public function saveDNSInterval() {
        $this->model->setDNSInterval($_POST[DNS_INTERVAL]);
    }

    public function saveDNSUpdateInterval() {
        $this->model->setDNSUpdateInterval($_POST[DNS_UPDATE_INTERVAL]);
    }

    public function runHotplugScript() {
        $this->model->runHotplugScript();
    }

}