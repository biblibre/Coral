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

<div class= "container-fluid">
	<div class="row">
		<div class="col-2">
			<div class="list-group" id="list-tab" role="tablist">
				<a href='javascript:void(0);' class='updateUserList'><button id="PreSelectedButton" type="button"><?php echo _("Users");?></button></a>
				<a href='javascript:void(0);' id='DocumentType' class='updateForm' ><button type="button"  ><?php echo _("Document Type");?></button></a>
				<a href='javascript:void(0);' class='updateExpressionTypeList' ><button type="button"><?php echo _("Expression Types");?></button></a>
				<a href='javascript:void(0);' class='updateQualifierList'><button type="button"><?php echo _("Qualifiers");?></button></a>
				<a href='javascript:void(0);' id='SignatureType' class='updateForm' ><button type="button"><?php echo _("Signature Types");?></button></a>
<?php
$getBtnDoc = _("Document Type");


$config = new Configuration;

//if the Resources module is not installed, do not display calendar options
	if (($config->settings->resourcesModule == 'Y') && (strlen($config->settings->resourcesDatabaseName) > 0)) { ?>

				<a href='javascript:void(0);' class='updateCalendarSettingsList'><button type="button"><?php echo _("Calendar Settings");?></button></a>

<?php
}

//if the org module is not installed, display provider list for updates
	if ($config->settings->organizationsModule != 'Y'){ ?>

				<a href='javascript:void(0);' class='updateForm' id='Consortium'><button type="button"><?php echo _("Consortia");?></button></a>
				<a href='javascript:void(0);' class='updateForm' id='Organization'><button type="button"><?php echo _("Providers");?></button></a>

<?php } ?>
			</div>
		</div>
		<div class="col-10"><div class="AdminContentUsers" id='div_AdminContent'></div></div>
	</div>
</div>

<script type="text/javascript" src="js/admin.js"></script>



<?php
	}else{
		echo _("You don't have permission to access this page");
	}

	include 'templates/footer.php';
?>
