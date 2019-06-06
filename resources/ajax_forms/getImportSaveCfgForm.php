<?php
	$configName = (($_GET["configName"]=="__NEW")?"":$_GET["configName"]);
?>
		<div id='div_updateForm'>

		<div class='formTitle 245'><span class='headerText marginL7'><?php echo _("Save Import Configuration");?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 250" >
		<tr>
		<td>

			<table class='noBorder 200 margin10'>
			<tr>
			<td><?php echo _("Name:");?></td><td><input type='text' id='saveConfigName' value='<?php echo $configName;?>' class='250'/></td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

		<br />
		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("save");?>' id ='submitAddUpdate' onclick='saveConfiguration();' class='save-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel")?>' onclick="window.parent.tb_remove(); return false;" class='cancel-button'></td>
			</tr>
		</table>


		</form>
		</div>
