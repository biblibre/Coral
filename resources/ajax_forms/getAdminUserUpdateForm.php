<?php
	if (isset($_GET['loginID'])) $loginID = $_GET['loginID']; else $loginID = '';

	$user = new User(new NamedArguments(array('primaryKey' => $loginID)));

	//get all roles for output in drop down
	$privilegeArray = array();
	$privilegeObj = new Privilege();
	$privilegeArray = $privilegeObj->allAsArray();

	if ($user->accountTabIndicator == '1') {
		$accountTab = 'checked';
	}else{
		$accountTab = '';
	}
?>
		<div id='div_updateForm'>

		<input type='hidden' id='editLoginID' value='<?php echo $loginID; ?>'>

		<div class='formTitle 295'><span class='headerText marginL7'><?php if ($loginID){ echo _("Edit User"); } else { echo _("Add New User"); } ?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class="surroundBox 300">
		<tr>
		<td>

			<table class='noBorder 260 margin10'>


				<tr><td><label for='loginID'><b><?php echo _("Login ID");?></b></label</td><td><?php if (!$loginID) { ?><input type='text' id='loginID' value='<?php echo $loginID; ?>' class='150'/> <?php } else { echo $loginID; } ?></td></tr>
				<tr><td><label for='firstName'><b><?php echo _("First Name");?></b></label</td><td><input type='text' id='firstName' value="<?php echo $user->firstName; ?>" class='150'/></td></tr>
				<tr><td><label for='lastName'><b><?php echo _("Last Name");?></b></label</td><td><input type='text' id='lastName' value="<?php echo $user->lastName; ?>" class='150'/></td></tr>
				<tr><td><label for='emailAddress'><b><?php echo _("Email Address");?></b></label</td><td><input type='text' id='emailAddress' value="<?php echo $user->emailAddress; ?>" class='150'/></td></tr>
				<tr><td><label for='privilegeID'><b><?php echo _("Privilege");?></b></label</td>
				<td>
				<select id='privilegeID' class="155">
				<?php

				foreach ($privilegeArray as $privilege){
					if ($privilege['privilegeID'] == $user->privilegeID){
						echo "<option value='" . $privilege['privilegeID'] . "' selected>" . $privilege['shortName'] . "</option>\n";
					}else{
						echo "<option value='" . $privilege['privilegeID'] . "'>" . $privilege['shortName'] . "</option>\n";
					}
				}

				?>
				</select>
				</td>
				</tr>

				<tr><td><label for='accountTab'><b><?php echo _("View Accounts");?></b></label</td><td><input type='checkbox' id='accountTab' value='1' <?php echo $accountTab; ?> /></td></tr>


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
		   $('#loginID').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitUserData();
				   }
		});

		   $('#firstName').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitUserData();
				   }
		});

		   $('#lastName').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitUserData();
				   }
		});

		   $('#emailAddress').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitUserData();
				   }
		});

		   $('#privilegeID').keyup(function(e) {
				   if(e.keyCode == 13) {
					   window.parent.submitUserData();
				   }
		});

		   $('#submitAddUpdate').click(function () {
			       window.parent.submitUserData();
		   });


	</script>
