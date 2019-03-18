<?php

/*
**************************************************************************************************************************
** CORAL Licensing Module v. 1.0
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

if ($user->isAdmin()){

?>

<div class="elementsAlign">

	<div class="menu">
			<table class='adminMenuTable' style='width:170px;'>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateUserList'><?php echo _("Users");?></a></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' id='DocumentType' class='updateForm' ><?php echo _("Documents Type");?></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateExpressionTypeList' ><?php echo _("Expression Types");?></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateQualifierList'><?php echo _("Qualifiers");?></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' id='SignatureType' class='updateForm' ><?php echo _("Signature Types");?></div></td></tr>

<?php

$config = new Configuration;

//if the Resources module is not installed, do not display calendar options
if (($config->settings->resourcesModule == 'Y') && (strlen($config->settings->resourcesDatabaseName) > 0)) { ?>

		<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateCalendarSettingsList'><?php echo _("Calendar Settings");?></div></td></tr>



<?php
}

//if the org module is not installed, display provider list for updates
if ($config->settings->organizationsModule != 'Y'){ ?>


		<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateForm' id='Consortium'><?php echo _("Consortia");?></div></td></tr>
		<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateForm' id='Organization'><?php echo _("Providers");?></div></td></tr>


<?php } ?>
	</table>
	</div>


<div id='div_AdminContent'></div>
</br>

<script type="text/javascript" src="js/admin.js"></script>

<?php
}else{
	echo _("You don't have permission to access this page");
}

include 'templates/footer.php';
?>
