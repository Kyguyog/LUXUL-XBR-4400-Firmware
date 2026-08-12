<?php

class Multiwanpolicy_Controller extends Controller {

    public function __construct() {
        parent::__construct();

        $this->Load_View(MULTI_WAN_POLICY. DS . MULTI_WAN_POLICY);
        $this->Load_Helper(HELPER);

    }

    public function display() {
        $this->addHeader();
        $this->addLeftNav();
        $this->addContent();

        if (isset($_POST[SAVE_BUTTON])) {
            $this->save();
            header(LOCATION.MULTI_WAN_SETTING_PAGE);
        }
    }

    public function addContent() {
        $multiwan_policy = EMPTY_STRING;
        $multiwan_polocy_view = new View();

        $multiwan_polocy_view->Assign(MULTI_WAN_WIZARD_STATUS, $this->getMultiWanWizardStatus());
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_OPTIONS, $this->helper->getMultiWanPolicyOptions(MULTI_WAN_POLICY_BALANCED_KEY));

        $multiwan_polocy_view->Assign(PROTOCAL_OPTIONS, $this->getProtocalOptions());

        $multiwan_polocy_view->Assign(WAN.WAN3, $this->getMwan3WanStatus(WAN3));
        $multiwan_polocy_view->Assign(WAN.WAN4, $this->getMwan3WanStatus(WAN4));

        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_BALANCED_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_BALANCED_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_BALANCED_2_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_BALANCED_2_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_BALANCED_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_BALANCED_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_BALANCED_2_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_BALANCED_2_KEY));

        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_FAILOVER_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_FAILOVER_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_FAILOVER_2_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_FAILOVER_2_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_FAILOVER_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_FAILOVER_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_FAILOVER_2_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_FAILOVER_2_KEY));

        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLE_WAN_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLWAN_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLE_WAN_2_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_2_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLWAN_2_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_2_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLE_WAN_3_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_3_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLWAN_3_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_3_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLE_WAN_4_MEMBER_INFO, $this->getMultiWanMemberInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_4_KEY));
        $multiwan_polocy_view->Assign(MULTI_WAN_POLICY_SINGLWAN_4_RULE_INFO, $this->getMultiWanRuleInfoByPolicy(MULTI_WAN_POLICY_SINGLE_WAN_4_KEY));

        $multiwan_policy .= $multiwan_polocy_view->Render(MULTI_WAN_POLICY.DS.SETUP, FALSE);
        $this->Assign(MULTI_WAN_POLICY, $multiwan_policy);
    }

    public function getProtocalOptions() {
        $options = array(
            PROTOCAL_ALL_KEY => PROTOCAL_ALL_VAL,
            PROTOCAL_TCP_KEY => PROTOCAL_TCP_VAL,
            PROTOCAL_UDP_KEY => PROTOCAL_UDP_VAL,
        );

        return $this->helper->selectOption($options, PROTOCAL_ALL_KEY);
    }

    public function save() {
        $policyName = $_POST[MULTI_WAN_POLICY_OPTIONS];

        $this->saveMultiWanMemberInfoByPolicy($policyName);
        $this->saveMultiWanRuleInfoByPolicy($policyName, $_POST[MULTI_WAN_RULE_INFO.ucwords($policyName)]);

        $this->saveRebootRequired();
    }

    public function delete($ruleName) {
        $this->deleteMultiWanRule(trim($ruleName));
        $this->saveRebootRequired();

        $this->commit();

        header(LOCATION.MULTIWAN_POLICY_PAGE);
    }

}