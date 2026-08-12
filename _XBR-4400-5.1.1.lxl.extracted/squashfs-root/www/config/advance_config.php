<?php

class Advance_Config {
    private static $instance;
    private $constants = array(
        'FIREWALL_RULE_TARGET' => 'firewall.@rule[1].target',
        'LUXUL_DYNAMIC_PPTP_PASSTHRU' => 'luxul.dynamic.pptppassthru',
        'GET_SERVER_ADDR_COMMAND' => 'cat /etc/firewall.user | grep \'p gre\' | cut -d \' \' -f11',
        'RESTART_LUXUL_CTF_COMMAND' => '/etc/init.d/luxulctf restart > /dev/null 2>&1 &',
        'FIREWALL_USER_MSG1' => "iptables -t nat -A prerouting_wan_rule -p gre -j DNAT --to ",
        'FIREWALL_USER_MSG2_PART1' => "iptables -A forwarding_wan_rule -p gre -d ",
        'FIREWALL_USER_MSG2_PART2' => " -j ACCEPT",
        'LUXUL_BETA_WAN_DELAY' => 'luxul.beta.wan_delay',
        'GET_BLOCK_SELF_ASSIGNED_IP_RULE_COMMAND' => 'uci show firewall |grep \'rule\' |grep \'Self\'',
    );

    /**
     * @return Advance_Config
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