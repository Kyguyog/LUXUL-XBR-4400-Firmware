<h2>Router Limits Web Management System</h2>

<p style="width: 80%">Easily manage screen time, enforce content filters, and track device internet use through a powerful cloud-based interface. Learn more at
    <a href="https://rlgo.co/learnmoreluxul" target="_blank">routerlimits.com.</a>
</p>

<div id="routerLimitsLogDiv">
    <img src="../../public/img/routerlimits.png" height="120" width="100" >
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="routerLimitsOptions">Router Limits System</label>
        <a id="router_limits_options_help" class="help-icon"></a>
    </div>
    <div class="form-item-input">
        <select name="routerLimitsOptions" type="text" id="routerLimitsOptions" help="router_limits_options_help">
            <?= $data[ROUTER_LIMITS_OPTIONS]; ?>
        </select>
    </div>
</div>

<div id="routerLimitsEnabledDiv" style="display: none">
    <hr/>

    <div class="form-item clearfix">
        <div class="form-item-label">
            <label for="routerLimitsStatus">Current Status</label>
            <a id="router_limits_status_help" class="help-icon"></a>
        </div>
        <?php if ($data[ROUTER_LIMITS_STATUS] == ROUTER_LIMITS_STATUS_CONNECTING_KEY) {
            ?>
            <div class="form-item-input-text">
                <?php echo ROUTER_LIMITS_STATUS_CONNECTING_VAL; ?>
            </div>
        <?php } else if ($data[ROUTER_LIMITS_STATUS] == ROUTER_LIMITS_STATUS_READY_KEY){ ?>
            <div class="form-item-input-text">
                <?php echo ROUTER_LIMITS_STATUS_READY_VAL; ?>
            </div>

            <input type="submit" name="activateRouterLimits" id="activateRouterLimits" value="Activate" class="cta-button">

            <div class="form-item clearfix">
                <div class="form-item-label">
                    <label for="routerLimitsDeviceId">Pairing Code</label>
                    <a id="router_limits_device_id_help" class="help-icon"></a>
                </div>
                <div class="form-item-input-text" id="deviceId">
                    <?= $data[ROUTER_LIMITS_DEVICE_ID]; ?>
                </div>
            </div>

            <hr />
        <?php } else if ($data[ROUTER_LIMITS_STATUS] == ROUTER_LIMITS_STATUS_ONLINE_KEY){ ?>
            <div class="form-item-input-text">
                <?php echo ROUTER_LIMITS_STATUS_ONLINE_VAL; ?>
            </div>

            <input type="submit" name="manageRouterLimits" id="manageRouterLimits" value="Manage Account" class="cta-button">

            <div class="form-item clearfix">
                <div class="form-item-label">
                    <label for="routerLimitsDeviceId">Paring Code</label>
                    <a id="router_limits_device_id_help" class="help-icon"></a>
                </div>
                <div class="form-item-input-text">
                    <?= $data[ROUTER_LIMITS_DEVICE_ID]; ?>
                </div>
            </div>

            <hr />
        <?php } ?>
    </div>

</div>

<div class="wizard-nav">
    <input type="submit" name="btnApply" id="btnApply" value="Apply" class="cta-button">
    <input type="submit" name="btnCancel" id="btnCancel" value="Cancel" class="cta-button">
    <input type="submit" name="btnRefresh" value="Refresh" class="cta-button" id="Refresh">
</div>

