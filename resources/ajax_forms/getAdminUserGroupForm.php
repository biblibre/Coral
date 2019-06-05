<?php
	if (isset($_GET['userGroupID'])) $userGroupID = $_GET['userGroupID']; else $userGroupID = '';
	$userGroup = new UserGroup(new NamedArguments(array('primaryKey' => $userGroupID)));

	//get all users for output in drop down
	$allUserArray = array();
	$userObj = new User();
	$allUserArray = $userObj->allAsArray();

	//get users already set up for this user group in case it's an edit
	$ugUserArray = $userGroup->getUsers();
?>
		<div id='div_userGroupForm'>
		<form id='userGroupForm'>
		<input type='hidden' name='editUserGroupID' id='editUserGroupID' value='<?php echo $userGroupID; ?>'>

		<div class='formTitle 280 relativeP marginB5'><span class='headerText'><?php if ($userGroupID){ echo _("Edit User Group"); } else { echo _("Add User Group"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class='noBorder hundPercent'>
		<tr class='verticalAlignT'>
		<td class='verticalAlignT relativeP'>


			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='rule'><b><?php echo _("User Group");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 275'>
			<tr>
			<td>

				<table class='noBorder 335 margin15201020'>
				<tr>
				<td class='verticalAlignT textAlignL'><label for='groupName'><b><?php echo _("Group Name:");?></b></label></td>
				<td>
				<input type='text' id='groupName' name='groupName' value = '<?php echo $userGroup->groupName; ?>' class='changeInput 210' /><span id='span_error_groupName' class='smallDarkRedText'></span>
				</td>
				</tr>

				<tr>
				<td class='verticalAlignT textAlignL'><label for='emailAddress' class='noWrap'><b><?php echo _("Email Addresses:");?></b></label></td>
				<td>
				<input type='text' id='emailAddress' name='emailAddress' value = '<?php echo $userGroup->emailAddress; ?>' class='changeInput 210' />
				</td>
				</tr>
        <tr><td colspan="2"><?php echo _("(use comma and a space between each email address)"); ?></td></tr>
				</table>
			</td>
			</tr>
			</table>

			<div class='h10'>&nbsp;</div>

			</td>
			</tr>
			<tr class='verticalAlignT'>
			<td>

			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='loginID'><b><?php echo _("Assigned Users");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 275'>
			<tr>
			<td>

				<table class='noBorder smallPadding newUserTable 205 margin1535035'>

				<tr class='newUserTR'>
				<td>
				<select class='changeSelect loginID 145'>
				<option value=''></option>
				<?php

				foreach ($allUserArray as $ugUser){
					$userObj = new User(new NamedArguments(array('primaryKey' => $ugUser['loginID'])));
					$ddDisplayName = $userObj->getDDDisplayName;
					echo "<option value='" . $ugUser['loginID'] . "'>" . $ddDisplayName . "</option>\n";
				}
				?>
				</select>
				</td>

				<td class='verticalAlignT textAlignL 40'>
				<a href='javascript:void();'><input class='addUser add-button' title='<?php echo _("add user");?>' type='button' value='<?php echo _("Add");?>'/></a>
				</td>
				</tr>
				</table>
				<div class='smallDarkRedText' id='div_errorUser' style='margin:0px 35px 7px 35px;'></div>

				<table class='noBorder smallPadding userTable' style='width:205px; margin:0px 35px 0px 35px;'>
				<tr>
				<td colspan='2'>
					<hr class='200' />
				</td>
				</tr>

				<?php
				if (count($ugUserArray) > 0){

					foreach ($ugUserArray as $ugUser){
					?>
						<tr class='newUser'>
						<td>
						<select class='changeSelect loginID 145'>
						<option value=''></option>
						<?php
						foreach ($allUserArray as $userGroupUser){

							$userObj = new User(new NamedArguments(array('primaryKey' => $userGroupUser['loginID'])));
							$ddDisplayName = $userObj->getDDDisplayName;

							if ($ugUser->loginID == $userGroupUser['loginID']){
								echo "<option value='" . $userGroupUser['loginID'] . "' selected>" . $ddDisplayName . "</option>\n";
							}else{
								echo "<option value='" . $userGroupUser['loginID'] . "'>" . $ddDisplayName . "</option>\n";
							}
						}
						?>
						</select>
						</td>

						<td class='verticalAlignT textAlignL 40'>
							<a href='javascript:void();'><img src='images/cross.gif' alt="<?php echo _("remove user from group");?>" title="<?php echo _("remove user from group");?>" class='remove' /></a>
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


		<hr style='width:283px;margin-top:15px; margin-bottom:10px;' />

		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitUserGroupForm' id ='submitUserGroupForm' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="kill(); tb_remove();" class='cancel-button'></td>
			</tr>
		</table>

		</form>
		</div>

		<script type="text/javascript" src="js/forms/userGroupForm.js?random=<?php echo rand(); ?>"></script>
