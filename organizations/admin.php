<?php

/*
**************************************************************************************************************************
** CORAL Organizations Module
**
** Copyright (c) 2010 University of Notre Dame
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

$pageTitle=_('Administration');
include 'templates/header.php';

//set referring page
$_SESSION['ref_script']=$currentPage;

//ensure user has admin permissions
if ($user->isAdmin()){
	?>
<div class= "container-fluid">
	<div class="row">
		<div class="col-2">

			<div class="list-group" id="list-tab" role="tablist">
				<a href='javascript:void(0);' class='updateUserForm'><button type="button"><?php echo _("Users");?></button></a>
				<a href='javascript:void(0);' id='OrganizationRole' class='updateForm'><button type="button"><?php echo _("Organization Role");?></button></a>
				<a href='javascript:void(0);' id='ContactRole' class='updateForm' ><button type="button"><?php echo _("Contact Role");?></button></a>
				<a href='javascript:void(0);' id='AliasType' class='updateForm'><button type="button"><?php echo _("Alias Type");?></button></a>
				<a href='javascript:void(0);' id='ExternalLoginType' class='updateForm'><button type="button"><?php echo _("External Login Type");?></button></a>
				<a href='javascript:void(0);' id='IssueLogType' class='updateForm'><button type="button"><?php echo _("Issue Type");?></button></a>
			</div>
	</div>


	<div class="col-10" id='div_AdminContent'></div>
</div>
</div>

	<script type="text/javascript" src="js/admin.js"></script>
	<?php

//end else for admin
}else{
	echo _("You do not have permissions to access this screen.");
}

include 'templates/footer.php';
?>
