<?php

/*
**************************************************************************************************************************
** CORAL Authentication Module v. 1.0
**
** Copyright (c) 2011 University of Notre Dame
**
** This file is part of CORAL.
**
** CORAL is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
**
** CORAL is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License along with CORAL.  If not, see <http://www.gnu.org/licenses/>.
**
**************************************************************************************************************************
*/


include_once 'directory.php';


switch ($_GET['action']) {


	case 'getAdminUserUpdateForm':
		if (isset($_GET['loginID'])) $loginID = $_GET['loginID']; else $loginID = '';

		$eUser = new User(new NamedArguments(array('primaryKey' => $loginID)));

		if ($eUser->isAdmin()){
			$adminInd = 'checked';
		}else{
			$adminInd = '';
		}
		?>


		<div id='div_updateForm'>


		<div class='formTitle w295px'><span class='headerText marginL7'><?php if ($loginID){ echo _("Edit User"); } else { echo _("Add New User"); } ?></span></div>


		<span class='smallDarkRedText' id='span_errors'></span>

		<input type='hidden' id='editLoginID' value='<?php echo $loginID; ?>' />

		<table class="surroundBox w300px">
		<tr>
		<td>

			<div class='w260 margin10'>

				<label for='submitLoginID' class='formLabel' <?php if ($loginID) { ?>style='margin-bottom:8px;'<?php } ?>><b><?php echo _("Login ID");?></b></label>&nbsp;
				<?php if (!$loginID) { ?><input type='text' id='textLoginID' value='' class='w110px'/> <?php } else { echo $loginID; } ?>
				<?php if ($loginID) { ?><div class='smallDarkRedText marginL5 marginB3'><?php echo _("Enter password for changes only")?></div> <?php }else{ echo "<br />"; } ?>
				<label for='password' class='formLabel'><b><?php if ($loginID) { echo _("New "); } echo _("Password");?></b></label>&nbsp;
				<input type='password' id='password' value="" class='w110px' />
				<br />
				<label for='passwordReenter' class='formLabel'><b><?php echo _("Reenter Password");?></b></label>&nbsp;
				<input type='password' id='passwordReenter' value="" class='w110px'/>
				<br />
				<label for='adminInd' class='formLabel'><b><?php echo _("Admin?");?></b></label>&nbsp;
				<input type='checkbox' id='adminInd' value='Y' <?php echo $adminInd; ?> />
				<br />
			</div>

		</td>
		</tr>
		</table>

		<br />
		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' id ='submitUser' class='submitButton' /></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="window.parent.tb_remove(); return false;" class='submitButton' /></td>
			</tr>
		</table>


		</div>

		<script type="text/javascript" src="js/admin.js"></script>
		<script type="text/javascript">
			//attach enter key event to new input and call add data when hit
		   $('#textLoginID').keyup(function(e) {
               if(e.keyCode == 13) {
                   window.parent.submitUserForm();
               }
        	});
		   $('#password').keyup(function(e) {
               if(e.keyCode == 13) {
                   window.parent.submitUserForm();
               }
        	});
		   $('#passwordReenter').keyup(function(e) {
               if(e.keyCode == 13) {
                   window.parent.submitUserForm();
               }
        	});
			//bind all of the inputs
			$("#submitUser").click(function () {
                window.parent.submitUserForm();
			});
        </script>

		<?php

		break;

	default:
       echo _("Action ") . $action . _(" not set up!");
       break;


}


?>
