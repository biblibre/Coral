<?php
	$resourceID = $_GET['resourceID'];
	$resourceAcquisitionID = $_GET['resourceAcquisitionID'];
	if (isset($_GET['attachmentID'])) $attachmentID = $_GET['attachmentID']; else $attachmentID = '';
	$attachment = new Attachment(new NamedArguments(array('primaryKey' => $attachmentID)));

		//get all attachment types for output in drop down
		$attachmentTypeArray = array();
		$attachmentTypeObj = new AttachmentType();
		$attachmentTypeArray = $attachmentTypeObj->allAsArray();
?>
		<div id='div_attachmentForm'>
		<form id='attachmentForm'>
		<input type='hidden' name='editResourceID' id='editResourceID' value='<?php echo $resourceID; ?>'>
		<input type='hidden' name='editResourceAcquisitionID' id='editResourceAcquisitionID' value='<?php echo isset($resourceAcquisitionID) ? $resourceAcquisitionID : $attachment->resourceAcquisitionID; ?>'>
		<input type='hidden' name='editAttachmentID' id='editAttachmentID' value='<?php echo $attachmentID; ?>'>

		<div class='formTitle 345'><span class='headerText marginL7'><?php if ($attachmentID){ echo _("Edit Attachment"); } else { echo _("Add Attachment"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 350">
		<tr>
		<td>

			<table class='noBorder 310 margin1015'>

			<tr>
			<td class="verticalAlignT textAlignL"><label for='shortName'><b><?php echo _("Name:");?></b></label></td>
			<td>
			<input type='text' class='changeInput' id='shortName' name='shortName' value = '<?php echo $attachment->shortName; ?>' class='230'/><span id='span_error_shortName' class='smallDarkRedText'></span>
			</td>
			</tr>

			<tr>

			<td class='verticalAlignT textAlignL border0'><label for='attachmentTypeID'><b><?php echo _("Type:");?></b></label></td>
			<td >

			<select name='attachmentTypeID' id='attachmentTypeID'>
			<option value=''></option>
			<?php
			foreach ($attachmentTypeArray as $attachmentType){
				if (!(trim(strval($attachmentType['attachmentTypeID'])) != trim(strval($attachment->attachmentTypeID)))){
					echo "<option value='" . $attachmentType['attachmentTypeID'] . "' selected>" . $attachmentType['shortName'] . "</option>\n";
				}else{
					echo "<option value='" . $attachmentType['attachmentTypeID'] . "'>" . $attachmentType['shortName'] . "</option>\n";
				}
			}
			?>
			</select>
			<span id='span_error_attachmentTypeID' class='smallDarkRedText'></span>
			</td>
			</tr>

			<tr>
			<td class='textAlignL verticalAlignT'><label for="uploadAttachment"><b><?php echo _("File:");?></b></label></td>
			<td>
			<?php

			//if editing
			if ($attachmentID){
				echo "<div id='div_uploadFile'>" . $attachment->attachmentURL . "<br /><a href='javascript:replaceFile();'>"._("replace with new file")."</a>";
				echo "<input type='hidden' id='upload_button' name='upload_button' value='" . $attachment->attachmentURL . "'></div>";

			//if adding
			}else{
				echo "<div id='div_uploadFile'><input type='file' name='upload_button' id='upload_button' /></div>";
			}


			?>
			<span id='div_file_message'></span>
			</td>
			</tr>

			<tr>
			<td class='textAlignL verticalAlignT'><label for='descriptionText'><b><?php echo _("Details:");?></b></label></td>
			<td><textarea rows='5' class='changeInput 230' id='descriptionText' name='descriptionText'><?php echo $attachment->descriptionText; ?></textarea></td>
			</td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

		<br />
		<table class='noBorderTable 125'>
			<tr>
				<td class="textAlignL"><input type='button' value='<?php echo _("submit");?>' name='submitAttachmentForm' id ='submitAttachmentForm' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" class='cancel-button'></td>
			</tr>
		</table>


		</form>
		</div>

		<script type="text/javascript" src="js/forms/attachmentForm.js?random=<?php echo rand(); ?>"></script>
