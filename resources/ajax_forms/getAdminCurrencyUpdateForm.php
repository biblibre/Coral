<?php
	$updateID = $_GET['updateID'];

	if ($updateID){
		$instance = new Currency(new NamedArguments(array('primaryKey' => $updateID)));
	}else{
		$instance = new Currency();
	}
?>
		<div id='div_updateForm'>

		<input type='hidden' id='editCurrencyCode' value='<?php echo $updateID; ?>'>

		<div class='formTitle 245'><span class='headerText marginL7' ><?php if ($updateID){ echo _("Edit Currency"); } else { echo _("Add Currency"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 250">
		<tr>
		<td>

			<table class='noBorder 200 margin10'>
			<tr>
			<td><?php echo _("Code");?></td><td><input type='text' id='currencyCode' value='<?php echo $instance->currencyCode; ?>' class='150'/></td>
			</tr>
			<tr>
			<td><?php echo _("Name");?></td><td><input type='text' id='shortName' value='<?php echo $instance->shortName; ?>' class='150'/></td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

		<br />
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
		   $('#currencyCode').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitCurrencyData();
				   }
		});

		   $('#shortName').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitCurrencyData();
				   }
		});

		   $('#submitAddUpdate').click(function () {
			       window.parent.submitCurrencyData();
		   });


	</script>
