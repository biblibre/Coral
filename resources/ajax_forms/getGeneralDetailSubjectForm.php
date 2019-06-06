<?php
	if (isset($_GET['generalSubjectID'])) $generalSubjectID = $_GET['generalSubjectID']; else $generalSubjectID = '';
	$generalSubject = new GeneralSubject(new NamedArguments(array('primaryKey' => $generalSubjectID)));


		//get all users for output in drop down
		$allDetailedSubjectArray = array();
		$detailedSubjectObj = new DetailedSubject();
		$allDetailedSubjectArray = $detailedSubjectObj->allAsArray();

		//get Detail Subjects already set up for this General subject in case it's an edit
		$dsSubjectArray = $generalSubject->getDetailedSubjects();
?>
		<div id='div_detailedSubjectForm'>
		<form id='detailedSubjectForm'>
		<input type='hidden' name='editgeneralSubjectID' id='editgeneralSubjectID' value='<?php echo $generalSubjectID; ?>'>

		<div class='formTitle 280 marginB5 relativeP'><span class='headerText'><?php echo _("Add / Edit Subject Relationships"); ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class='noBorder w100'>
		<tr class='verticalAlignT'>
		<td class='verticalAlignT relativeP'>


			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='rule'><b><?php echo _("General Subject");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 275'>
			<tr>
			<td>

				<table class='noBorder 235 margin15201020'>
				<tr>
				<td>&nbsp;</td>
				<td>
				<input type='text' id='shortName' name='shortName' value = '<?php echo $generalSubject->shortName; ?>'  class='changeInput 110' /><span id='span_error_groupName' class='smallDarkRedText'></span>
				</td>
				</tr>

				</table>
			</td>
			</tr>
			</table>

			<div class='h10'>&nbsp;</div>

			</td>
			</tr>
			<tr class='verticalAlignT'>
			<td>

			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='detailedSubjectID'><b><?php echo _("Detailed Subjects");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 275'>
			<tr>
			<td>

				<table class='noBorder smallPadding newdetailedSubjectTable 205 margin1535035'>

					<tr class='newdetailedSubjectTR'>
						<td>
							<select class='changeSelect detailedSubjectID 145'>
								<option value=''></option>
								<?php

								foreach ($allDetailedSubjectArray as $dSubject){
									echo "<option value='" . $dSubject['detailedSubjectID'] . "'>" . $dSubject['shortName'] . "</option>\n";
								}
								?>
							</select>
						</td>

				<td class='verticalAlignT textAlignL 40'>
				<a href='javascript:void();'>
					<input class='adddetailedSubject add-button' title='<?php echo _("add detail subject");?>' type='button' value='<?php echo _("Add");?>'/>
				</a>
				</td>
				</tr>
				</table>
				<div class='smallDarkRedText margin035735' id='div_errordetailedSubject'></div>

				<table class='noBorder smallPadding detailedSubjectTable 205 margin035035'>
				<tr>
				<td colspan='2'>
					<hr class='200' />
				</td>
				</tr>

				<?php

				if (count($dsSubjectArray) > 0){
					foreach ($dsSubjectArray as $dsSubject){
					?>
						<tr class='newdetailedSubject'>
						<td>
						<select class='changeSelect detailedSubjectID 145'>
						<option value='<?php echo $dsSubject->detailedSubjectID ?>'><?php echo $dsSubject->shortName ?></option>
						</select>
						</td>

						<td class='40 verticalAlignT textAlignL' >
						<?php
							// Check to see if detail subject is in use.  If not allow removal.
							$subjectObj = new DetailedSubject();
							if ($subjectObj->inUse($dsSubject->detailedSubjectID, $generalSubject->generalSubjectID) == 0)  { ?>
								<a href='javascript:void();'><img src='images/cross.gif' alt="<?php echo _("remove detailed subject");?>" title="<?php echo _("remove detailed subject");?>" class='remove' /></a>
						<?php } else { ?>
								<img src='images/do_not_enter.png' alt="<?php echo _("subject in use");?>" title="<?php echo _("subject in use");?>" />
						<?php }  ?>
						</td>
						</tr>
					<?php
					}
				}
				?>
				</table>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		</table>


		<hr class='283 marginT15 marginB10' />

		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitDetailSubjectForm' id ='submitDetailSubjectForm' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="kill(); tb_remove();" class='cancel-button'></td>
			</tr>
		</table>

		</form>
		</div>

		<script type="text/javascript" src="js/forms/generalDetailSubjectForm.js?random=<?php echo rand(); ?>"></script>
