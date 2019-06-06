<?php
	$resourceID = $_GET['resourceID'];
    $resourceAcquisitionID = isset($_GET['resourceAcquisitionID']) ? $_GET['resourceAcquisitionID'] : null;
	if (isset($_GET['contactID'])) $contactID = $_GET['contactID']; else $contactID = '';
	$contact = new Contact(new NamedArguments(array('primaryKey' => $contactID)));

		if (($contact->archiveDate) && ($contact->archiveDate != '0000-00-00')){
			$invalidChecked = 'checked';
		}else{
			$invalidChecked = '';
		}

		//get contact roles
		$sanitizedInstance = array();
		$instance = new ContactRole();
		$contactRoleProfileArray = array();
		foreach ($contact->getContactRoles() as $instance) {
			$contactRoleProfileArray[] = $instance->contactRoleID;
		}

		//get all contact roles for output in drop down
		$contactRoleArray = array();
		$contactRoleObj = new ContactRole();
		$contactRoleArray = $contactRoleObj->allAsArray();
?>
		<div id='div_contactForm'>
		<form id='contactForm'>
		<input type='hidden' name='editResourceID' id='editResourceID' value='<?php echo $resourceID; ?>'>
		<input type='hidden' name='editResourceAcquisitionID' id='editResourceAcquisitionID' value='<?php echo $resourceAcquisitionID; ?>'>
		<input type='hidden' name='editContactID' id='editContactID' value='<?php echo $contactID; ?>'>

		<div class='formTitle 603'><span class='headerText marginL7' ><?php if ($contactID){ echo _("Edit Contact"); } else { echo _("Add Contact"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 600">
		<tr>
		<td>
			<table class='noBorder 560 margin15201020'>
			<tr>
			<td>

				<table class='noBorder'>
					<tr>
					<td class='textAlignL'><label for='contactName'><b><?php echo _("Name:");?></b></label></td>
					<td>
					<input type='text' id='contactName' name='contactName' value = '<?php echo $contact->name; ?>' class='changeInput 150' /><span id='span_error_contactName' class='smallDarkRedText'>
					</td>
					</tr>

					<tr>
					<td class='textAlignL'><label for='contactTitle'><b><?php echo _("Title:");?></b></label></td>
					<td>
					<input type='text' id='contactTitle' name='contactTitle' value = '<?php echo $contact->title; ?>' class='changeInput 150' />
					</td>
					</tr>

					<tr>
					<td class='textAlignL'><label for='phoneNumber'><b><?php echo _("Phone:");?></b></label></td>
					<td>
					<input type='text' id='phoneNumber' name='phoneNumber' value = '<?php echo $contact->phoneNumber; ?>' class='changeInput 150' />
					</td>
					</tr>

					<tr>
					<td class='textAlignL'><label for='altPhoneNumber'><b><?php echo _("Alt Phone:");?></b></label></td>
					<td>
					<input type='text' id='altPhoneNumber' name='altPhoneNumber' value = '<?php echo $contact->altPhoneNumber; ?>' class='changeInput 150' />
					</td>
					</tr>

					<tr>
					<td class='textAlignL'><label for='faxNumber'><b><?php echo _("Fax:");?></b></label></td>
					<td>
					<input type='text' id='faxNumber' name='faxNumber' value = '<?php echo $contact->faxNumber; ?>' class='changeInput 150' />
					</td>
					</tr>

					<tr>
					<td class='textAlignL'><label for='emailAddress'><b><?php echo _("Email:");?></b></label></td>
					<td>
					<input type='text' id='emailAddress' name='emailAddress' value = '<?php echo $contact->emailAddress; ?>' class='changeInput 150' />
					</td>
					</tr>

					<tr>
					<td cxlass='textAlignL'><label for='addressText'><b><?php echo _("Address:");?></b></label></td>
					<td>
					<textarea rows='3' id='addressText' class='150'><?php echo $contact->addressText; ?></textarea>
					</td>
					</tr>

					<tr>
					<td class='textAlignL'><label for='invalidInd'><b><?php echo _("Archived:");?></b></label></td>
					<td>
					<input type='checkbox' id='invalidInd' name='invalidInd' <?php echo $invalidChecked; ?> />
					</td>
					</tr>
				</table>
			</td>
			<td>
				<table class='noBorder'>
				<tr>
				<td class='verticalAlignT textAlignL'><label for='orgRoles'><b><?php echo _("Role(s):");?></b></label></td>
				<td>

					<table>
					<?php
					$i=0;
					if (count($contactRoleArray) > 0){
						foreach ($contactRoleArray as $contactRoleIns){
							$i++;
							if(($i % 3)==1){
								echo "<tr>\n";
							}
							if (in_array($contactRoleIns['contactRoleID'],$contactRoleProfileArray)){
								echo "<td class='verticalAlignT textAlignL'><input class='check_roles' type='checkbox' name='" . $contactRoleIns['contactRoleID'] . "' id='" . $contactRoleIns['contactRoleID'] . "' value='" . $contactRoleIns['contactRoleID'] . "' checked />   <span class='smallText'>" . $contactRoleIns['shortName'] . "</span></td>\n";
							}else{
								echo "<td class='verticalAlignT textAlignL'><input class='check_roles' type='checkbox' name='" . $contactRoleIns['contactRoleID'] . "' id='" . $contactRoleIns['contactRoleID'] . "' value='" . $contactRoleIns['contactRoleID'] . "' />   <span class='smallText'>" . $contactRoleIns['shortName'] . "</span></td>\n";
							}
							if(($i % 3)==0){
								echo "</tr>\n";
							}
						}

						if(($i % 3)==1){
							echo "<td>&nbsp;</td><td>&nbsp;</td></tr>\n";
						}else if(($i % 3)==2){
							echo "<td>&nbsp;</td></tr>\n";
						}
					}
					?>
					</table>
					<span id='span_error_contactRole' class='smallDarkRedText'></span>
				</td>
				</tr>


				<tr>
				<td class='textAlignL'><label for='addressText'><b><?php echo _("Notes:");?></b></label></td>
				<td>
				<textarea rows='3' id='noteText' class='220'><?php echo $contact->noteText; ?></textarea>
				</td>
				</tr>

				</table>


			</td>
			</tr>
			</table>

		</td>
		</tr>
		</table>



		<hr class="610 margin150100" />

		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitContactForm' id ='submitContactForm' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove();" class='cancel-button'></td>
			</tr>
		</table>

		</form>
		</div>


		<script type="text/javascript" src="js/forms/contactForm.js?random=<?php echo rand(); ?>"></script>
