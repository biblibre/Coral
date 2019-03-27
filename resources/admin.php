<?php

/*
**************************************************************************************************************************
** CORAL Resources Module v. 1.2
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


//set referring page
CoralSession::set('ref_script', $currentPage = '');

$pageTitle=_('Administration');
include 'templates/header.php';

$config = new Configuration;

//ensure user has admin permissions
if ($user->isAdmin()){
	?>


	<div class= "container-fluid">
		<div class="row">
			<div class="col-2">
				<div class="list-group" id="list-tab" role="tablist">
					<a href='javascript:void(0);' class='UserAdminLink'><button id="PreSelectedButton" type="button"><?php echo _("Users");?></button></a>
					<a href='javascript:void(0);' class='WorkflowAdminLink'><button type="button"><?php echo _("Workflow / User Group");?></button></a>
					<a href='javascript:void(0);' id='AccessMethod' class='AdminLink'><button type="button"><?php echo _("Access Method");?></button></a>
					<a href='javascript:void(0);' id='AcquisitionType' class='AdminLink'><button type="button"><?php echo _("Acquisition Type");?></button></a>
					<a href='javascript:void(0);' id='AdministeringSite' class='AdminLink'><button type="button"><?php echo _("Administering Site");?></button></a>
					<a href='javascript:void(0);' class='AlertAdminLink'><button type="button"><?php echo _("Alert Settings");?></button></a>
					<a href='javascript:void(0);' id='AliasType' class='AdminLink'><button type="button"><?php echo _("Alias Type");?></button></a>
					<a href='javascript:void(0);' id='AttachmentType' class='AdminLink'><button type="button"><?php echo _("Attachment Type");?></button></a>
					<a href='javascript:void(0);' id='AuthenticationType' class='AdminLink'><button type="button"><?php echo _("Authentication Type");?></button></a>
					<a href='javascript:void(0);' id='AuthorizedSite' class='AdminLink'><button type="button"><?php echo _("Authorized Site");?></button></a>
					<a href='javascript:void(0);' id='CatalogingStatus' class='AdminLink'><button type="button"><?php echo _("Cataloging Status");?></button></a>
					<a href='javascript:void(0);' id='CatalogingType' class='AdminLink'><button type="button"><?php echo _("Cataloging Type");?></button></a>
					<a href='javascript:void(0);' id='ContactRole' class='AdminLink'><button type="button"><?php echo _("Contact Role");?></button></a>
				<?php if ($config->settings->enhancedCostHistory == 'Y'){ ?>
					<a href='javascript:void(0);' id='CostDetails' class='AdminLink'><button type="button"><?php echo _("Cost Details");?></button></a>
				<?php } ?>
					<a href='javascript:void(0);' class='CurrencyLink'><button type="button"><?php echo _("Currency");?></button></a>
					<a href='javascript:void(0);' class='AdminLink' id="DowntimeType"><button type="button"><?php echo _("Downtime Type");?></button></a>
        	<a href='javascript:void(0);' class='EbscoKbConfigLink'><button type="button"><?php echo _("EBSCO Kb Config");?></button></a>
					<a href='javascript:void(0);' id='ExternalLoginType' class='AdminLink'><button type="button"><?php echo _("External Login Type");?></button></a>
					<a href='javascript:void(0);' class='FundLink'><button type="button"><?php echo _("Funds");?></button></a>
					<a href='javascript:void(0);' class='ImportConfigLink'><button type="button"><?php echo _("Import Configuration");?></button></a>
					<a href='javascript:void(0);' id='LicenseStatus' class='AdminLink'><button type="button"><?php echo _("License Status");?></button></a>
					<a href='javascript:void(0);' id='NoteType' class='AdminLink'><button type="button"><?php echo _("Note Type");?></button></a>
					<a href='javascript:void(0);' id='OrderType' class='AdminLink'><button type="button"><?php echo _("Order Type");?></button></a>
				<?php

				//For Organizations links
				//if the org module is not installed, display provider list for updates
				if ($config->settings->organizationsModule == 'N'){ ?>

					<a href='javascript:void(0);' id='OrganizationRole' class='AdminLink'><button type="button"><?php echo _("Organization Role");?></button></a>
					<a href='javascript:void(0);' id='Organization' class='AdminLink'><button type="button"><?php echo _("Organizations");?></button></a>
				<?php } ?>

					<a href='javascript:void(0);' id='PurchaseSite' class='AdminLink'><button type="button"><?php echo _("Purchasing Site");?></button></a>
					<a href='javascript:void(0);' id='ResourceFormat' class='AdminLink'><button type="button"><?php echo _("Resource Format");?></button></a>
					<a href='javascript:void(0);' id='ResourceType' class='AdminLink'><button type="button"><?php echo _("Resource Type");?></button></a>
					<a href='javascript:void(0);' id='StorageLocation' class='AdminLink'><button type="button"><?php echo _("Storage Location");?></button></a>
					<a href='javascript:void(0);' class='SubjectsAdminLink'><button type="button"><?php echo _("Subjects");?></button></a>
					<a href='javascript:void(0);' id='UserLimit' class='AdminLink'><button type="button"><?php echo _("User Limit");?></button></a>
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
