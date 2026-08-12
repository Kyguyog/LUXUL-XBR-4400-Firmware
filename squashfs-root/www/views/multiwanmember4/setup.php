<h2>Multi-WAN Member Configuration - GROUP 4</h2>

<br />
<h3>Members</h3>

<table class="data-grid" >
    <thead>
    <tr>
        <th style="width: 40%">Interface</th>
        <th style="width: 20%">Priority</th>
        <th style="width: 20%">Weight</th>
        <th style="width: 20%">Select</th>
    </tr>
    </thead>

    <?php foreach ($data[MULTI_WAN_MEMBER_INFO] as $interfaceName => $multiwanMemberInfo) { ?>
        <tr class="dataInput" style='text-align:center'>
            <td style="text-align: center"><?php echo $interfaceName ?></td>
            <td>
                <?php if(isset($multiwanMemberInfo[MEMBER_PRIORITY])) {?>
                    <input type=text name='groupPriority<?php echo strtoupper($interfaceName) ?>' id='groupPriority<?php echo strtoupper($interfaceName) ?>' help="group_priority_help" value="<?php echo $multiwanMemberInfo[MEMBER_PRIORITY]; ?>"/>
                <?php } else { echo EMPTY_STRING; }?>
            </td>
            <td>
                <?php if(isset($multiwanMemberInfo[MEMBER_WEIGHT])) {?>
                    <input type=text name='groupWeight<?php echo strtoupper($interfaceName) ?>' id='groupWeight<?php echo strtoupper($interfaceName) ?>' help="group_weight_help" value="<?php echo $multiwanMemberInfo[MEMBER_WEIGHT]; ?>"/>
                <?php } else { echo EMPTY_STRING; }?>            </td>
            <td style="text-align: center">
                <input type="checkbox" id="check<?php echo strtoupper($interfaceName) ?>" class="checkboxWanMember" <?php if(isset($multiwanMemberInfo[MEMBER_PRIORITY])) echo CHECKBOX_CHECKED; else echo EMPTY_STRING; ?> style="margin-bottom: 0">
            </td>
        </tr>
    <?php } ?>
</table>

<input type="hidden" id="multiWanWizardStatus" value="<?= $data[MULTI_WAN_WIZARD_STATUS]; ?>">

<div class="wizard-nav">
    <input type="submit" name="btnNext" id="btnNext" value="Next" class="cta-button">
    <input type="button" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
</div>