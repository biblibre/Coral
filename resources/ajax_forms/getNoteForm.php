<?php
	$entityID = isset($_GET['entityID']) ? $_GET['entityID'] : null;
	if (isset($_GET['resourceNoteID'])) $resourceNoteID = $_GET['resourceNoteID']; else $resourceNoteID = '';
		if (isset($_GET['tab'])) $tabName = $_GET['tab']; else $tabName = '';
	$resourceNote = new ResourceNote(new NamedArguments(array('primaryKey' => $resourceNoteID)));

		//get all note types for output in drop down
		$noteTypeArray = array();
		$noteTypeObj = new NoteType();
		$noteTypeArray = $noteTypeObj->allAsArrayForDD();
?>
		<div id='div_noteForm'>
		<form id='noteForm'>
		<input type='hidden' name='editEntityID' id='editEntityID' value='<?php echo $entityID; ?>'>
		<input type='hidden' name='editResourceNoteID' id='editResourceNoteID' value='<?php echo $resourceNoteID; ?>'>
		<input type='hidden' name='tab' id='tab' value='<?php echo $tabName; ?>'>

		<div class='formTitle 395'><span class='headerText marginL7'><?php if ($resourceNoteID){ echo _("Edit Note"); } else { echo _("Add Note"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 400">
		<tr>
		<td>

			<table class='noBorder 360 margin1015'>
			<tr>
			<td class='verticalAlignT textAlignL border0'><label for='noteTypeID'><b><?php echo _("Note Type:");?></b></label></td>
			<td class='verticalAlignT textAlignL border0'>

			<select name='noteTypeID' id='noteTypeID'>
			<option value=''></option>
			<?php
			foreach ($noteTypeArray as $noteType){
				if (!(trim(strval($noteType['noteTypeID'])) != trim(strval($resourceNote->noteTypeID)))){
					echo "<option value='" . $noteType['noteTypeID'] . "' selected>" . $noteType['shortName'] . "</option>\n";
				}else{
					echo "<option value='" . $noteType['noteTypeID'] . "'>" . $noteType['shortName'] . "</option>\n";
				}
			}
			?>
			</select>

			</td>
			</tr>

			<tr>
			<td class='verticalAlignT textAlignL'><label for='noteText'><b><?php echo _("Notes:");?></b></label></td>
			<td><textarea rows='5' id='noteText' name='noteText' class='270'><?php echo $resourceNote->noteText; ?></textarea><span class='smallDarkRedText' id='span_error_noteText'></span></td>
			</td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

		<br />
		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitResourceNoteForm' id ='submitResourceNoteForm' class='submit-button'></td>
				<td class='textAlignL' ><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" class='cancel-button'></td>
			</tr>
		</table>


		</form>
		</div>

		<script type="text/javascript" src="js/forms/resourceNoteForm.js?random=<?php echo rand(); ?>"></script>
