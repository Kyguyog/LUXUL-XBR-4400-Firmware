<h2>Internet / Multi-WAN List</h2>

<br />
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="multiWan">WAN</label>
        <a id="multi_wan_help" class="help-icon"></a>
    </div>
    <input type="button" id="btnMultiWan" value="Edit WAN" class="cta-button">
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="multiWan2">WAN2</label>
        <a id="multi_wan2_help" class="help-icon"></a>
    </div>
    <input type="button" id="btnMultiWan2" value="Edit WAN2" class="cta-button">
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="multiWan3">WAN3</label>
        <a id="multi_wan3_help" class="help-icon"></a>
    </div>
    <input type="button" id="btnMultiWan3" value="<?php if($data[WAN.WAN3]) { echo  "Edit WAN3"; } else {echo "Add WAN3";} ?>" class="cta-button">
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="multiWan4">WAN4</label>
        <a id="multi_wan4_help" class="help-icon"></a>
    </div>
    <input type="button" id="btnMultiWan4" value="<?php if($data[WAN.WAN4]) { echo  "Edit WAN4"; } else {echo "Add WAN4";} ?>" class="cta-button">
</div>