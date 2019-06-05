<?php
	$resourceID = $_GET['resourceID'];
	if (isset($_GET['externalLoginID'])) $externalLoginID = $_GET['externalLoginID']; else $externalLoginID = '';
	$externalLogin = new ExternalLogin(new NamedArguments(array('primaryKey' => $externalLoginID)));

	//get all contact roles for output in drop down
	$externalLoginTypeArray = array();
	$externalLoginTypeObj = new ExternalLoginType();
	$externalLoginTypeArray = $externalLoginTypeObj->allAsArray();
?>
		<div id='div_accountForm'>
		<form id='accountForm'>
		<input type='hidden' name='editResourceID' id='editResourceID' value='<?php echo $resourceID; ?>'>
		<input type='hidden' name='editExternalLoginID' id='editExternalLoginID' value='<?php echo $externalLoginID; ?>'>


		<div class='formTitle 385'><span class='headerText marginL7'><?php if ($externalLoginID){ echo _("Edit Account"); } else { echo _("Add Account"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 390">
		<tr>
		<td>

			<table class='noBorder 350 margin1015'>
				<tr>
				<td class='verticalAlignT textAlignL'><label for='externalLoginTypeID'><b><?php echo _("Login Type:");?></b></label></td>
				<td>
				<select name='externalLoginTypeID' id='externalLoginTypeID' class='changeSelect'>
				<?php
				foreach ($externalLoginTypeArray as $externalLoginType){
					if ($externalLoginType['externalLoginTypeID'] == $externalLogin->externalLoginTypeID){
						echo "<option value='" . $externalLoginType['externalLoginTypeID'] . "' selected>" . $externalLoginType['shortName'] . "</option>\n";
					}else{
						echo "<option value='" . $externalLoginType['externalLoginTypeID'] . "'>" . $externalLoginType['shortName'] . "</option>\n";
					}
				}
				?>
				</select>
				</td>
				</tr>

				<tr>
				<td class='verticalAlignT textAlignL'><label for='loginURL'><b><?php echo _("URL:");?></b></label></td>
				<td>
				<input type='text' id='loginURL' name='loginURL' value = '<?php echo $externalLogin->loginURL; ?>' class='changeInput 200' />
				</td>
				</tr>

				<tr>
				<td class='verticalAlignT textAlignL'><label for='emailAddress'><b><?php echo _("Registered Email:");?></b></label></td>
				<td>
				<input type='text' id='emailAddress' name='emailAddress' value = '<?php echo $externalLogin->emailAddress; ?>' class='changeInput 200' />
				</td>
				</tr>

				<tr>
				<td class='verticalAlignT textAlignL'><label for='username'><b><?php echo _("Username:");?></b></label></td>
				<td>
				<input type='text' id='username' name='username' value = '<?php echo $externalLogin->username; ?>' class='changeInput 200' />
				</td>
				</tr>

				<tr>
				<td class='verticalAlignT textAlignL'><label for='password'><b><?php echo _("Password:");?></b></label></td>
				<td>
				<input type='text' id='password' name='password' value = '<?php echo $externalLogin->password; ?>' class='changeInput 200' />
				</td>
				</tr>

				<tr>
				<td class='verticalAlignT textAlignL'><label for='noteText'><b><?php echo _("Notes:");?></b></label></td>
				<td><textarea rows='3' id='noteText' name='noteText' class='200'><?php echo $externalLogin->noteText; ?></textarea></td>
				</td>
				</tr>
			</table>

		</td>
		</tr>
		</table>

		<br />

		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitExternalLoginForm' id ='submitExternalLoginForm' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove();" class='cancel-button'></td>
			</tr>
		</table>

		</form>
		</div>


		<script type="text/javascript" src="js/forms/externalLoginForm.js?random=<?php echo rand(); ?>"></script>
