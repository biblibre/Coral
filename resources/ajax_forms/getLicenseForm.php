<?php
	$config = new Configuration();
	$resourceID = $_GET['resourceID'];
	$resourceAcquisitionID = $_GET['resourceAcquisitionID'];
	$resource = new Resource(new NamedArguments(array('primaryKey' => $resourceID)));
	$resourceAcquisition = new ResourceAcquisition(new NamedArguments(array('primaryKey' => $resourceAcquisitionID)));


		//get license statuses
		$sanitizedInstance = array();
		$instance = new ResourceLicenseStatus();
		$resourceLicenseStatusArray = array();
		foreach ($resourceAcquisition->getResourceLicenseStatuses() as $instance) {
				foreach (array_keys($instance->attributeNames) as $attributeName) {
					$sanitizedInstance[$attributeName] = $instance->$attributeName;
				}

				$sanitizedInstance[$instance->primaryKeyName] = $instance->primaryKey;

				$changeUser = new User(new NamedArguments(array('primaryKey' => $instance->licenseStatusChangeLoginID)));
				if (($changeUser->firstName) || ($changeUser->lastName)) {
					$sanitizedInstance['changeName'] = $changeUser->firstName . " " . $changeUser->lastName;
				}else{
					$sanitizedInstance['changeName'] = $instance->licenseStatusChangeLoginID;
				}


				$licenseStatus = new LicenseStatus(new NamedArguments(array('primaryKey' => $instance->licenseStatusID)));
				$sanitizedInstance['licenseStatus'] = $licenseStatus->shortName;


				array_push($resourceLicenseStatusArray, $sanitizedInstance);

		}

		$currentLicenseStatusID = $resourceAcquisition->getCurrentResourceLicenseStatus();

		//get licenses (already returned in array)
		$licenseArray = $resourceAcquisition->getLicenseArray();



		//get all resource licenses for output in drop down
		$licenseStatusArray = array();
		$licenseStatusObj = new LicenseStatus();
		$licenseStatusArray = $licenseStatusObj->allAsArray();
?>
		<div id='div_licenseForm'>
		<form id='licenseForm'>
		<input type='hidden' name='editResourceAcquisitionID' id='editResourceAcquisitionID' value='<?php echo $resourceAcquisitionID; ?>'>

		<div class='formTitle 360 marginB5'><span class='headerText'><?php echo _("Edit Licenses");?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class='noBorder 360'>
		<tr class='verticalAlignT'>
		<td class='verticalAlignT'>


			<?php if ($config->settings->licensingModule == 'Y'){ ?>
			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='licenseRecords'><b><?php echo _("License Records");?></b></label>&nbsp;&nbsp;</span>


			<table class='surroundBox 350'>
			<tr>
			<td>

				<table class='noBorder smallPadding newLicenseTable 310 margin1520020'>
				<tr class='newLicenseTR'>

				<td class='verticalAlignT textAlignL'>
				<input type='text' value = '' class='changeAutocomplete licenseName lightGrey 260' />
				<input type='hidden' class='licenseID' value = '' />
				</td>

				<td class='verticalAlignT textAlignL 40'>
				<a href='javascript:void();' class='addLicense'><input class='addLicense add-button' title='<?php echo _("add license");?>' type='button' value='<?php echo _("Add");?>'/></a>
				</td>
				</tr>
				</table>
				<div class='smallDarkRedText margin020726' id='div_errorLicense'></div>


				<table class='noBorder smallPadding licenseTable 310 margin0201520'>
				<tr>
				<td colspan='2'>
					<hr class='290 margin0055'/>
				</td>
				</tr>

				<?php
				if (count($licenseArray) > 0){

					foreach ($licenseArray as $license){
					?>
						<tr>

						<td class='verticalAlignT textAlignL'>
						<input type='text' class='changeInput licenseName' value = '<?php echo $license['license']; ?>' class='changeInput 260' />
						<input type='hidden' class='licenseID' value = '<?php echo $license['licenseID']; ?>' />
						</td>

						<td class='verticalAlignT textAlignL 40'>
							<a href='javascript:void();'><img src='images/cross.gif' alt='<?php echo _("remove license link");?>' title='<?php echo _("remove ").$license['license']._(" license"); ?>' class='remove' /></a>
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


			<div class='h15'>&nbsp;</div>

			<?php } ?>

			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='licenseStatus'><b><?php echo _("Licensing Status");?></b></label></span>

			<table class='surroundBox 350'>
			<tr>
			<td>

				<table class='noBorder smallPadding 310 margin1520020 '>
				<tr>
				<td class='verticalAlignT textAlignL 60'><?php echo _("Status:");?></td>
				<td class='verticalAlignT textAlignL'>
				<select class='changeSelect' id='licenseStatusID'>
				<option value=''></option>
				<?php
				foreach ($licenseStatusArray as $licenseStatus){
					if (!(trim(strval($licenseStatus['licenseStatusID'])) != trim(strval($currentLicenseStatusID)))){
						echo "<option value='" . $licenseStatus['licenseStatusID'] . "' selected class='changeSelect'>" . $licenseStatus['shortName'] . "</option>\n";
					}else{
						echo "<option value='" . $licenseStatus['licenseStatusID'] . "' class='changeSelect'>" . $licenseStatus['shortName'] . "</option>\n";
					}
				}
				?>
				</select>
				</td>

				</tr>
				</table>

				<hr class='margin820720 310' />


				<table class='noBorder 310 margin515'>
				<tr>
				<td class='verticalAlignT 60'><?php echo _("History:");?></td>
				<td>

				<?php
				if (count($resourceLicenseStatusArray) > 0){
					foreach ($resourceLicenseStatusArray as $licenseStatus){
						echo $licenseStatus['licenseStatus'] . " - <i>" . format_date($licenseStatus['licenseStatusChangeDate']) . _(" by ") . $licenseStatus['changeName'] . "</i><br />";
					}
				}else{
					echo "<i>"._("No license status information available.")."</i>";
				}

				?>
				</td>
				</tr>

				</table>


			</td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

		<br />

		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitLicense' id ='submitLicense' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="kill(); tb_remove();" class='cancel-button'></td>
			</tr>
		</table>

		<?php if ($config->settings->licensingModule == 'Y'){ ?>
		<script type="text/javascript" src="js/forms/licenseForm.js?random=<?php echo rand(); ?>"></script>
		<?php }else{ ?>
		<script type="text/javascript" src="js/forms/licenseStatusOnlyForm.js?random=<?php echo rand(); ?>"></script>
		<?php } ?>
