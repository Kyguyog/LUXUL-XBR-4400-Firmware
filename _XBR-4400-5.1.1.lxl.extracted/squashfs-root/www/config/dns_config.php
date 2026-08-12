<?php

class Dns_Config {
    private static $instance;
    private $constants = array(
        'DNS_STATUS' => 'ddns.myddns.enabled',
        'DNS_SERVICE_PROVIDER' => 'ddns.myddns.service_name',
        'DNS_HOST_NAME' => 'ddns.myddns.domain',
        'DNS_USER_NAME' => 'ddns.myddns.username',
        'DNS_PASSWORD' => 'ddns.myddns.password',
        'DNS_INTERVAL' => 'ddns.myddns.check_interval',
        'DNS_UPDATE_INTERVAL' => 'ddns.myddns.force_interval',
        'DNS' => 'ddns.myddns',
        'SERVICE' => 'service',
        'DNS_INTERFACE' => 'ddns.myddns.interface',
        'DNS_INTERFACE_WAN' => 'wan',
        'DNS_FORCE_UNIT' => 'ddns.myddns.force_unit',
        'DNS_FORCE_UNIT_DAYS' => 'days',
        'DNS_CHECK_UNIT' => 'ddns.myddns.check_unit',
        'DNS_CHECK_UNIT_MINUTES' => 'minutes',
        'DNS_RETRY_INTERVAL' => 'ddns.myddns.retry_interval',
        'DNS_RETRY_INTERVAL_60' => '60',
        'DNS_RETRY_UNIT' => 'ddns.myddns.retry_unit',
        'DNS_RETRY_UNIT_SECONDS' => 'seconds',
        'DNS_IP_SOURCE' => 'ddns.myddns.ip_source',
        'DNS_IP_SOURCE_WEB' => 'web',
        'DNS_IP_URL' => 'ddns.myddns.ip_url',
        'DNS_IP_URL_CHECKIP_DNS' => 'http://checkip.dyndns.com/',
        'HOTPLUG_SCRIPT' => 'ACTION=ifup INTERFACE=wan /sbin/hotplug-call iface'
    );

    /**
     * @return Dns_Config
     */
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get($name) {
        if (!isset($this->constants[$name]))
            throw new Exception(UNKNOWN_CONSTANTS . $name);
        return $this->constants[$name];
    }

    public function __set($name, $value) {
        $this->constants[$name] = $value;
    }

}