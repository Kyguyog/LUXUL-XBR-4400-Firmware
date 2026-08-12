<label>Command Line</label>
<input type="text" name="<?= COMMAND; ?>" value="<?= htmlspecialchars($data[COMMAND], ENT_QUOTES, 'UTF-8'); ?>" id="command" style="width: 420px;">

<input type="submit" name="btnRun" id="btnRun" value="Run" class="cta-button">

<br /><br />

<textarea id="results" readonly="readonly" style="width: 100%; height: 360px; font-family: monospace; white-space: pre;"><?= htmlspecialchars($data[RESULTS], ENT_QUOTES, 'UTF-8'); ?></textarea>
