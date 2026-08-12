<?php

class Helper {

     public function selectOption($options, $selectedValue) {
        $strSelect = EMPTY_STRING;

        foreach($options as $key=>$value){
            $selectedStr=EMPTY_STRING;
            if($selectedValue==$key) {
                $selectedStr=SELECT_OPTIONS_SELECTED;
            }

            $strSelect.="<option $selectedStr value='$key' >$value</option>";
        }
        return $strSelect;
    }

    public function getMultiWanPolicyOptions($multiwanPolicyName) {
        $options=array(
            MULTI_WAN_POLICY_BALANCED_KEY => MULTI_WAN_POLICY_BALANCED_VAL,
            MULTI_WAN_POLICY_FAILOVER_KEY => MULTI_WAN_POLICY_FAILOVER_VAL,
            MULTI_WAN_POLICY_SINGLE_WAN_KEY => MULTI_WAN_POLICY_SINGLE_WAN_VAL,
//            MULTI_WAN_POLICY_BALANCED_2_KEY => MULTI_WAN_POLICY_BALANCED_2_VAL,
//            MULTI_WAN_POLICY_FAILOVER_2_KEY => MULTI_WAN_POLICY_FAILOVER_2_VAL,
//            MULTI_WAN_POLICY_SINGLE_WAN_2_KEY => MULTI_WAN_POLICY_SINGLE_WAN_2_VAL,
//            MULTI_WAN_POLICY_SINGLE_WAN_3_KEY => MULTI_WAN_POLICY_SINGLE_WAN_3_VAL,
//            MULTI_WAN_POLICY_SINGLE_WAN_4_KEY => MULTI_WAN_POLICY_SINGLE_WAN_4_VAL
        );

        return $this->selectOption($options, $multiwanPolicyName);
    }

}