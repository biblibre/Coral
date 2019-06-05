<?php
	$alertEmailAddressID = $_GET['alertEmailAddressID'];

	if ($alertEmailAddressID){
		$instance = new AlertEmailAddress(new NamedArguments(array('primaryKey' => $alertEmailAddressID)));
	}else{
		$instance = new AlertEmailAddress();
	}
?>
		<div id='div_updateForm'>

		<input type='hidden' id='editAlertEmailAddressID' value='<?php echo $alertEmailAddressID; ?>'>

		<div class='formTitle 245'><span class='headerText marginL7'><?php if ($alertEmailAddressID){ echo _("Edit Alert Email Address"); } else { echo _("Add Alert Email Address"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 250">
		<tr>
		<td>

			<table class='noBorder 200 margin10'>
			<td><input type='text' id='emailAddress' value='<?php echo $instance->emailAddress; ?>' class='190'/></td>
			</td>
			</tr>
			</table>

		</td>
		</tr>
		</table>
		<div class='smallDarkRedText' id='div_form_error'>&nbsp;</div>
		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' id ='submitAddUpdate' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="window.parent.tb_remove(); return false;" class='cancel-button'></td>
			</tr>
		</table>


		</form>
		</div>

		<script type="text/javascript">
		   //attach enter key event to new input and call add data when hit
		   $('#emailAddress').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitAdminAlertEmail();
				   }
		});


		   $('#submitAddUpdate').click(function () {
			       window.parent.submitAdminAlertEmail();
		   });


	</script>
