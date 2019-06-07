<?php
$downtimeID = is_numeric($_GET['downtimeID']) ? $_GET['downtimeID']:null;

if ($downtimeID) {
	$downtime = new Downtime(new NamedArguments(array('primaryKey' => $downtimeID)));

?>
<form id="resolveDowntimeForm">
	<input name="downtimeID" type="hidden" value="<?php echo $downtime->downtimeID;?>" />
	<table class="thickboxTable thickboxTitleImgAlt w98">
		<tr>
			<td colspan="2">
				<h1>Resolve Downtime</h1>
			</td>
		</tr>
		<tr>
			<td>
				<label>Downtime Resolution:</label>
			</td>
			<td>
				<div>
					<div><i>Date</i></div>
					<input class="date-pick" type="text" name="endDate" id="endDate" />
					<span id='span_error_endDate' class='smallDarkRedText updateDowntimeError'></span>
				</div>
				<div class='clearingBoth'>
					<div><i>Time</i></div>
<?php
echo buildTimeForm("endTime");
?>
					<span id='span_error_endDate' class='smallDarkRedText updateDowntimeError'></span>
				</div>
			</td>
		</tr>
		<tr>
			<td><label>Note:</label></td>
			<td>
				<textarea name="note"><?php echo $downtime->note;?></textarea>
			</td>
		</tr>
	</table>
	<table class='noBorderTable 125'>
		<tr>
			<td class='textAlignL' ><input type='button' value='submit' name='submitUpdatedDowntime' id='submitUpdatedDowntime'></td>
			<td class='textAlignR'><input type='button' value='cancel' onclick="tb_remove();"></td>
		</tr>
	</table>
</form>
<?php
} else {
?>
		<div>
			Unable to retrieve Downtime.
		</div>
		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignR'><input type='button' value='cancel' onclick="tb_remove();"></td>
			</tr>
		</table>
<?php
}
