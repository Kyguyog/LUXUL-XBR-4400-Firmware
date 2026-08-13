<h2>System Log</h2>
<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="sysLogSizeOptions">System Log Size</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <select name="sysLogSizeOptions" type="text" id="sysLogSizeOptions">
            <?= $data[SYSTEM_LOG_OPTIONS]; ?>
        </select>
    </div>
</div>

<div class="form-item clearfix">
    <div class="form-item-label">
        <label for="saveToFile">Save to File</label>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="form-item-input">
        <input type="submit" id="btnSave" name="btnSave" value="Save" class="cta-button"/>
    </div>
</div>

<div class="systemLogContainer">
    <table>
        <?php foreach ($data[LOG_MSG] as $key => $message) { ?>
            <tr>
                <td><?php echo $message; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>