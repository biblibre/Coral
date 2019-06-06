<?php
		$className = $_GET['className'];
		$updateID = $_GET['updateID'];

		if ($updateID){
			$instance = new $className(new NamedArguments(array('primaryKey' => $updateID)));
		}else{
			$instance = new $className();
		}
?>
		<div id='div_updateForm'>

		<input type='hidden' id='editClassName' value='<?php echo $className; ?>'>
		<input type='hidden' id='editUpdateID' value='<?php echo $updateID; ?>'>

		<div class='formTitle 245'><span class='headerText marginL7'><?php if ($updateID){ echo _("Edit ") . preg_replace("/[A-Z]/", " \\0" , $className); } else { echo _("Add ") . preg_replace("/[A-Z]/", " \\0" , $className); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 250">
		<tr>
		<td>

			<table class='noBorder 200 margin10'>
			<tr>
			<td><input type="text" id="updateVal" value="<?php echo $instance->shortName; ?>" class="190"></td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

		<br />
		<table class='noBorderTable 125'>
			<tr>

				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitDetailedSubjectForm' id ='submitDetailedSubjectForm' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="window.parent.tb_remove(); return false;" class='cancel-button'></td>
			</tr>
		</table>


		</form>
		</div>

		<script type="text/javascript" src="js/forms/detailedSubjectForm.js?random=<?php echo rand(); ?>"></script>
