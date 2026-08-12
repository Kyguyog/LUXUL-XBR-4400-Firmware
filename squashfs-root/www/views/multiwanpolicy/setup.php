<h2>Multi-WAN Policy Configuration<a id="multi_wan_policy_help" class="help-icon"></a></h2>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="multiWanPolicyOptions">Policy</label>&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="multiWanPolicyOptions" type="text" id="multiWanPolicyOptions"
                help="multi_wan_policy_options_help">
            <?= $data[MULTI_WAN_POLICY_OPTIONS]; ?>
        </select>
    </div>
</div>

<div id="balancedDiv" style="display: none">
    <h2>Members</h2>

    <table class="data-grid">
        <thead>
        <tr>
            <th style="width: 20%">Interface</th>
            <th style="width: 40%">Common Name</th>
            <th style="width: 20%">Weight</th>
            <th style="width: 20%">Select</th>
        </tr>
        </thead>

        <?php foreach ($data[MULTI_WAN_POLICY_BALANCED_MEMBER_INFO] as $interfaceName => $multiwanMemberInfo) { ?>
            <tr class="dataInput">
                <td style="text-align: center"><?php echo $interfaceName ?></td>
                <td><?php echo $multiwanMemberInfo[WAN_NAME]; ?></td>
                <td>
                    <?php if (isset($multiwanMemberInfo[MEMBER_WEIGHT])) { ?>
                        <input type=text name='memberWeight<?php echo strtoupper($interfaceName) ?>_Balanced' class="memberWeight_Balanced"
                               id='memberWeight<?php echo strtoupper($interfaceName) ?>_Balanced' help="member_weight_help"
                               value="<?php echo $multiwanMemberInfo[MEMBER_WEIGHT]; ?>"/>
                    <?php } else {
                        echo EMPTY_STRING;
                    } ?>
                </td>
                <td style="text-align: center">
                    <input type="checkbox" id="check<?php echo strtoupper($interfaceName) ?>_Balanced" name="check<?php echo strtoupper($interfaceName) ?>_Balanced"
                           class="checkboxWanMember_Balanced"
                           <?php if (isset($multiwanMemberInfo[MEMBER_WEIGHT])) echo CHECKBOX_CHECKED; else echo EMPTY_STRING; ?>
                           style="margin-bottom: 0" />
                </td>
            </tr>
        <?php } ?>
    </table>

    <hr/>
    <h2>Add Rule</h2>
    <table class="data-grid" id="addRuleBalanced">
        <tr>
            <th style="width: 15%">Rule Name</th>
            <th style="width: 15%">Source Address</th>
            <th style="width: 15%">Source Ports</th>
            <th style="width: 15%">Destination Address</th>
            <th style="width: 15%">Destination Ports</th>
            <th style="width: 5%">Protocols</th>
            <th>Modify</th>
        </tr>
        <tr style="text-align: center">
            <td><input type="text" id="addBalancedRuleName" autocomplete="off"></td>
            <td><input type="text" id="addBalancedSrcAddr" autocomplete="off"></td>
            <td><input type="text" id="addBalancedSrcPort" autocomplete="off"></td>
            <td><input type="text" id="addBalancedDestAddr" autocomplete="off"></td>
            <td><input type="text" id="addBalancedDestPort" autocomplete="off"></td>
            <td>
                <select type="text" id="addBalancedProtoOptions">
                    <?= $data[PROTOCAL_OPTIONS]; ?>
                </select>
            </td>
            <td><input id="addBalancedRule" type="button" class="cta-button" value="Add">&nbsp
                <input id="cancel" type="button" class="cta-button" value="Cancel">
            </td>
        </tr>
    </table>

    <br/><br/>
    <hr/>

    <h2>Active Rules</h2>
    <table class="data-grid" id="addToRulesBalanced">
        <thead>
        <tr>
            <th style="width: 15%">Rule Name</th>
            <th style="width: 15%">Source Address</th>
            <th style="width: 15%">Source Ports</th>
            <th style="width: 15%">Destination Address</th>
            <th style="width: 15%">Destination Ports</th>
            <th style="width: 5%">Protocols</th>
            <th>Modify</th>
        </tr>
        </thead>

        <?php if (count($data[MULTI_WAN_POLICY_BALANCED_RULE_INFO]) > 0) {
            foreach($data[MULTI_WAN_POLICY_BALANCED_RULE_INFO] as $key=>$ruleInfo) {
            ?>
            <tr class="dataInput" style='text-align:center'>
                <td>
                    <?php echo $ruleInfo[RULE_NAME] ?>
                </td>
                <td><?php echo $ruleInfo[SOURCE_ADDRESS] ?></td>
                <td><?php echo $ruleInfo[SOURCE_PORT] ?></td>
                <td><?php echo $ruleInfo[DESTINATION_ADDRESS] ?></td>
                <td><?php echo $ruleInfo[DESTINATION_PORT] ?></td>
                <td><?php echo $ruleInfo[PROTOCAL] ?></td>
                <?php
                    if($ruleInfo[RULE_NAME] != "default_rule") { ?>
                        <td id="btnModify_<?php echo $ruleInfo[RULE_NAME];?>"></td>
                <?php } else { ?>
                        <td></td>
                <?php } ?>

            </tr>
        <?php }} ?>
    </table>

    <input type="hidden" name ="ruleInfoBalanced" id="ruleInfoBalanced" value="">

</div>

<div id="failoverDiv" style="display: none">
    <h3>Members</h3>

    <table class="data-grid">
        <thead>
        <tr>
            <th style="width: 20%">Interface</th>
            <th style="width: 40%">Common Name</th>
            <th style="width: 20%">Priority</th>
            <th style="width: 20%">Select</th>
        </tr>
        </thead>

        <?php foreach ($data[MULTI_WAN_POLICY_FAILOVER_MEMBER_INFO] as $interfaceName => $multiwanMemberInfo) { ?>
            <tr class="dataInput">
                <td style="text-align: center"><?php echo $interfaceName ?></td>
                <td><?php echo $multiwanMemberInfo[WAN_NAME]; ?></td>
                <td>
                    <?php if (isset($multiwanMemberInfo[MEMBER_PRIORITY])) { ?>
                        <input type=text name='memberPriority<?php echo strtoupper($interfaceName) ?>_Failover'
                               id='memberPriority<?php echo strtoupper($interfaceName) ?>_Failover' help="group_priority_help" class="memberPriority_Failover"
                               value="<?php echo $multiwanMemberInfo[MEMBER_PRIORITY]; ?>"/>
                    <?php } else {
                        echo EMPTY_STRING;
                    } ?>
                </td>
                <td style="text-align: center">
                    <input type="checkbox" id="check<?php echo strtoupper($interfaceName) ?>_Failover" name="check<?php echo strtoupper($interfaceName) ?>_Failover"
                           class="checkboxWanMember_Failover" <?php if (isset($multiwanMemberInfo[MEMBER_PRIORITY])) echo CHECKBOX_CHECKED; else echo EMPTY_STRING; ?>
                           style="margin-bottom: 0">
                </td>
            </tr>
        <?php } ?>
    </table>

    <hr/>
    <h2>Add Rule</h2>
    <table class="data-grid" id="addRuleFailover">
        <tr>
            <th style="width: 15%">Rule Name</th>
            <th style="width: 15%">Source Address</th>
            <th style="width: 15%">Source Ports</th>
            <th style="width: 15%">Destination Address</th>
            <th style="width: 15%">Destination Ports</th>
            <th style="width: 5%">Protocols</th>
            <th>Modify</th>
        </tr>
        <tr style="text-align: center">
            <td><input type="text" id="addFailoverRuleName" autocomplete="off"></td>
            <td><input type="text" id="addFailoverSrcAddr" autocomplete="off"></td>
            <td><input type="text" id="addFailoverSrcPort" autocomplete="off"></td>
            <td><input type="text" id="addFailoverDestAddr" autocomplete="off"></td>
            <td><input type="text" id="addFailoverDestPort" autocomplete="off"></td>
            <td>
                <select type="text" id="addFailoverProtoOptions">
                    <?= $data[PROTOCAL_OPTIONS]; ?>
                </select>
            </td>
            <td><input id="addFailoverRule" type="button" class="cta-button" value="Add">&nbsp
                <input id="cancel" type="button" class="cta-button" value="Cancel">
            </td>
        </tr>
    </table>

    <br/><br/>
    <hr/>

    <h2>Active Rules</h2>
    <table class="data-grid" id="addToRulesFailover">
        <thead>
        <tr>
            <th style="width: 15%">Rule Name</th>
            <th style="width: 15%">Source Address</th>
            <th style="width: 15%">Source Ports</th>
            <th style="width: 15%">Destination Address</th>
            <th style="width: 15%">Destination Ports</th>
            <th style="width: 5%">Protocols</th>
            <th>Modify</th>
        </tr>
        </thead>

        <?php if (count($data[MULTI_WAN_POLICY_FAILOVER_RULE_INFO]) > 0) {
            foreach($data[MULTI_WAN_POLICY_FAILOVER_RULE_INFO] as $key=>$ruleInfo) {
                ?>
                <tr class="dataInput" style='text-align:center'>
                    <td>
                        <?php echo $ruleInfo[RULE_NAME] ?>
                    </td>
                    <td><?php echo $ruleInfo[SOURCE_ADDRESS] ?></td>
                    <td><?php echo $ruleInfo[SOURCE_PORT] ?></td>
                    <td><?php echo $ruleInfo[DESTINATION_ADDRESS] ?></td>
                    <td><?php echo $ruleInfo[DESTINATION_PORT] ?></td>
                    <td><?php echo $ruleInfo[PROTOCAL] ?></td>
                    <?php
                    if($ruleInfo[RULE_NAME] != "default_rule") { ?>
                        <td id="btnModify_<?php echo $ruleInfo[RULE_NAME];?>"></td>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>
                </tr>
            <?php }} ?>
    </table>

    <input type="hidden" name ="ruleInfoFailover" id="ruleInfoFailover" value="">

</div>

<div id="singleWanDiv" style="display: none">
    <h3>Members</h3>

    <table class="data-grid">
        <thead>
        <tr>
            <th style="width: 20%">Interface</th>
            <th style="width: 40%">Common Name</th>
            <th style="width: 20%">Priority</th>
            <th style="width: 20%">Select</th>
        </tr>
        </thead>

        <?php

        foreach ($data[MULTI_WAN_POLICY_SINGLE_WAN_MEMBER_INFO] as $interfaceName => $multiwanMemberInfo) {
            if ($multiwanMemberInfo[MEMBER_PRIORITY] != EMPTY_STRING) {
                ?>
                <tr class="dataInput">
                    <td style="text-align: center"><?php echo $interfaceName ?></td>
                    <td><?php echo $multiwanMemberInfo[WAN_NAME]; ?></td>
                    <td>
                        <?php if (isset($multiwanMemberInfo[MEMBER_PRIORITY])) { ?>
                            <input type=text name='memberPriority<?php echo strtoupper($interfaceName) ?>_Singlewan' class="memberPriority_Singlewan"
                                   id='memberPriority<?php echo strtoupper($interfaceName) ?>_Singlewan' help="group_priority_help"
                                   value="<?php echo $multiwanMemberInfo[MEMBER_PRIORITY]; ?>"/>
                        <?php } else {
                            echo EMPTY_STRING;
                        } ?>
                    </td>
                    <td style="text-align: center">
                        <input type="checkbox" id="check<?php echo strtoupper($interfaceName) ?>_Singlewan" name="check<?php echo strtoupper($interfaceName) ?>_Singlewan"
                               class="checkboxWanMember_Singlewan" <?php if (isset($multiwanMemberInfo[MEMBER_PRIORITY])) echo CHECKBOX_CHECKED; else echo EMPTY_STRING; ?>
                               style="margin-bottom: 0">
                    </td>
                </tr>
            <?php }
        } ?>
    </table>

    <hr/>
    <h2>Add Rule</h2>
    <table class="data-grid" id="addRuleSinglewan">
        <tr>
            <th style="width: 15%">Rule Name</th>
            <th style="width: 15%">Source Address</th>
            <th style="width: 15%">Source Ports</th>
            <th style="width: 15%">Destination Address</th>
            <th style="width: 15%">Destination Ports</th>
            <th style="width: 5%">Protocols</th>
            <th>Modify</th>
        </tr>
        <tr style="text-align: center">
            <td><input type="text" id="addSinglewanRuleName" autocomplete="off"></td>
            <td><input type="text" id="addSinglewanSrcAddr" autocomplete="off"></td>
            <td><input type="text" id="addSinglewanSrcPort" autocomplete="off"></td>
            <td><input type="text" id="addSinglewanDestAddr" autocomplete="off"></td>
            <td><input type="text" id="addSinglewanDestPort" autocomplete="off"></td>
            <td>
                <select type="text" id="addSinglewanProtoOptions">
                    <?= $data[PROTOCAL_OPTIONS]; ?>
                </select>
            </td>
            <td><input id="addSinglewanRule" type="button" class="cta-button" value="Add">&nbsp
                <input id="cancel" type="button" class="cta-button" value="Cancel">
            </td>
        </tr>
    </table>

    <br/><br/>
    <hr/>

    <h2>Active Rules</h2>
    <table class="data-grid" id="addToRulesSinglewan">
        <thead>
        <tr>
            <th style="width: 15%">Rule Name</th>
            <th style="width: 15%">Source Address</th>
            <th style="width: 15%">Source Ports</th>
            <th style="width: 15%">Destination Address</th>
            <th style="width: 15%">Destination Ports</th>
            <th style="width: 5%">Protocols</th>
            <th>Modify</th>
        </tr>
        </thead>

        <?php if (count($data[MULTI_WAN_POLICY_SINGLWAN_RULE_INFO]) > 0) {
            foreach($data[MULTI_WAN_POLICY_SINGLWAN_RULE_INFO] as $key=>$ruleInfo) {
                ?>
                <tr class="dataInput" style='text-align:center'>
                    <td>
                        <?php echo $ruleInfo[RULE_NAME] ?>
                    </td>
                    <td><?php echo $ruleInfo[SOURCE_ADDRESS] ?></td>
                    <td><?php echo $ruleInfo[SOURCE_PORT] ?></td>
                    <td><?php echo $ruleInfo[DESTINATION_ADDRESS] ?></td>
                    <td><?php echo $ruleInfo[DESTINATION_PORT] ?></td>
                    <td><?php echo $ruleInfo[PROTOCAL] ?></td>
                    <?php
                    if($ruleInfo[RULE_NAME] != "default_rule") { ?>
                        <td id="btnModify_<?php echo $ruleInfo[RULE_NAME];?>"></td>
                    <?php } else { ?>
                        <td></td>
                    <?php } ?>
                </tr>
            <?php }} ?>
    </table>

    <input type="hidden" name ="ruleInfoSinglewan" id="ruleInfoSinglewan" value="">

</div>

<input type="hidden" id="multiWanWizardStatus" value="<?= $data[MULTI_WAN_WIZARD_STATUS]; ?>">
<input type="hidden" id="multiWan3Status" value="<?= $data[WAN . WAN3]; ?>">
<input type="hidden" id="multiWan4Status" value="<?= $data[WAN . WAN4]; ?>">

<div class="wizard-nav">
    <input type="submit" name="btnSave" id="btnApply" value="Save" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>
