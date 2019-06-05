<?php
	$resourceID = $_GET['resourceID'];
	$resourceAcquisitionID = $_GET['resourceAcquisitionID'];
	$resource = new Resource(new NamedArguments(array('primaryKey' => $resourceID)));
	$resourceAcquisition = new ResourceAcquisition(new NamedArguments(array('primaryKey' => $resourceAcquisitionID)));

	//get all authentication types for output in drop down
	$authenticationTypeArray = array();
	$authenticationTypeObj = new AuthenticationType();
	$authenticationTypeArray = $authenticationTypeObj->allAsArray();

	//get all access methods for output in drop down
	$accessMethodArray = array();
	$accessMethodObj = new AccessMethod();
	$accessMethodArray = $accessMethodObj->allAsArray();

	//get all user limits for output in drop down
	//overridden for better sort
	$userLimitArray = array();
	$userLimitObj = new UserLimit();
	$userLimitArray = $userLimitObj->allAsArray();

	//get all storage locations for output in drop down
	$storageLocationArray = array();
	$storageLocationObj = new StorageLocation();
	$storageLocationArray = $storageLocationObj->allAsArray();

	//get all administering sites for output in checkboxes
	$administeringSiteArray = array();
	$administeringSiteObj = new AdministeringSite();
	$administeringSiteArray = $administeringSiteObj->allAsArray();


	//get administering sites for this resource
	$sanitizedInstance = array();
	$instance = new AdministeringSite();
	$resourceAdministeringSiteArray = array();
	foreach ($resourceAcquisition->getAdministeringSites() as $instance) {
		$resourceAdministeringSiteArray[] = $instance->administeringSiteID;
	}


	//get all authorized sites for output in checkboxes
	$authorizedSiteArray = array();
	$authorizedSiteObj = new AuthorizedSite();
	$authorizedSiteArray = $authorizedSiteObj->allAsArray();


	//get authorized sites for this resource
	$sanitizedInstance = array();
	$instance = new AuthorizedSite();
	$resourceAuthorizedSiteArray = array();
	foreach ($resourceAcquisition->getAuthorizedSites() as $instance) {
		$resourceAuthorizedSiteArray[] = $instance->authorizedSiteID;
	}
?>
		<div id='div_accessForm'>
		<form id='accessForm'>
		<input type='hidden' name='editResourceID' id='editResourceID' value='<?php echo $resourceID; ?>'>
		<input type='hidden' name='editResourceAcquisitionID' id='editResourceAcquisitionID' value='<?php echo $resourceAcquisitionID; ?>'>

		<div class='formTitle 617 marginB5'><span class='headerText'><?php echo _("Edit Access");?></span></div>

		<span class='smallDarkRedText' verticalAlignTid='span_errors'></span>

		<table class='noBorder 610'>
		<tr class='verticalAlignT'>
		<td class='verticalAlignT' colspan='2'>


			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='accessHead'><b><?php echo _("Access");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 610'>
			<tr>
			<td>
				<table class='noBorder 570 margin15201020'>
				<tr>
					<td class='surroundBoxTdStyle'><label for='authenticationTypeID'><?php echo _("Authentication Type:");?></label></td>
					<td>
						<select name='authenticationTypeID' id='authenticationTypeID' class='changeSelect 100'>
						<option value=''></option>
						<?php
						foreach ($authenticationTypeArray as $authenticationType){
							if (!(trim(strval($authenticationType['authenticationTypeID'])) != trim(strval($resourceAcquisition->authenticationTypeID)))){
								echo "<option value='" . $authenticationType['authenticationTypeID'] . "' selected>" . $authenticationType['shortName'] . "</option>\n";
							}else{
								echo "<option value='" . $authenticationType['authenticationTypeID'] . "'>" . $authenticationType['shortName'] . "</option>\n";
							}
						}
						?>
						</select>
					</td>
					<td class='surroundBoxTdStyle'><label for='authenticationUserName'><?php echo _("Username:");?></label></td>
					<td><input type='text' id='authenticationUserName' name='authenticationUserName' value = '<?php echo $resourceAcquisition->authenticationUserName; ?>' class='changeInput 95'  /></td>
				</tr>
				<tr>
					<td class='surroundBoxTdStyle'><label for='accessMethodID'><?php echo _("Access Method:");?></label></td>
					<td>
						<select name='accessMethodID' id='accessMethodID' class='changeSelect 100'>
						<option value=''></option>
						<?php
						foreach ($accessMethodArray as $accessMethod){
							if (!(trim(strval($accessMethod['accessMethodID'])) != trim(strval($resourceAcquisition->accessMethodID)))){
								echo "<option value='" . $accessMethod['accessMethodID'] . "' selected>" . $accessMethod['shortName'] . "</option>\n";
							}else{
								echo "<option value='" . $accessMethod['accessMethodID'] . "'>" . $accessMethod['shortName'] . "</option>\n";
							}
						}
						?>
						</select>
					</td>
					<td class='surroundBoxTdStyle'><label for='authenticationPassword'><?php echo _("Password:");?></label></td>
					<td><input type='text' id='authenticationPassword' name='authenticationPassword' value = '<?php echo $resourceAcquisition->authenticationPassword; ?>' class='changeInput 95'  /></td>
				</tr>
				<tr>
					<td class='surroundBoxTdStyle'><label for='storageLocationID'><?php echo _("Storage Location:");?></label></td>
					<td>
						<select name='storageLocationID' id='storageLocationID'  class='changeSelect 100'>
						<option value=''></option>
						<?php
						foreach ($storageLocationArray as $storageLocation){
							if (!(trim(strval($storageLocation['storageLocationID'])) != trim(strval($resourceAcquisition->storageLocationID)))){
								echo "<option value='" . $storageLocation['storageLocationID'] . "' selected>" . $storageLocation['shortName'] . "</option>\n";
							}else{
								echo "<option value='" . $storageLocation['storageLocationID'] . "'>" . $storageLocation['shortName'] . "</option>\n";
							}
						}
						?>
						</select>
					</td>
					<td class='surroundBoxTdStyle'><label for='userLimitID'><?php echo _("Simultaneous User Limit:");?></label></td>
					<td>
						<select name='userLimitID' id='userLimitID' class='changeSelect 100' >
						<option value=''></option>
						<?php
						foreach ($userLimitArray as $userLimit){
							if (!(trim(strval($userLimit['userLimitID'])) != trim(strval($resourceAcquisition->userLimitID)))){
								echo "<option value='" . $userLimit['userLimitID'] . "' selected>" . $userLimit['shortName'] . "</option>\n";
							}else{
								echo "<option value='" . $userLimit['userLimitID'] . "'>" . $userLimit['shortName'] . "</option>\n";
							}
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td class='surroundBoxTdStyle'><label for='coverageText'><?php echo _("Coverage:");?></label></td>
					<td colspan='3'>
						<input type='text' id='coverageText' name='coverageText' value = "<?php echo $resourceAcquisition->coverageText; ?>" class='changeInput 405'  />
					</td>
				</tr>
				</table>
			</td>
			</tr>
			</table>

		</td>
		</tr>

		<tr class='verticalAlignT'>
		<td>



			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='authorizedSiteID'><b><?php echo _("Authorized Site(s)");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 295'>
			<tr>
			<td>
				<?php
				$i=0;
				if (count($authorizedSiteArray) > 0){
					echo "<table class='noBorder 255 margin1520'>";
					foreach ($authorizedSiteArray as $authorizedSiteIns){
						$i++;
						if(($i % 2)==1){
							echo "<tr>\n";
						}
						if (in_array($authorizedSiteIns['authorizedSiteID'],$resourceAuthorizedSiteArray)){
							echo "<td><input class='check_authorizedSite' type='checkbox' name='" . $authorizedSiteIns['authorizedSiteID'] . "' id='" . $authorizedSiteIns['authorizedSiteID'] . "' value='" . $authorizedSiteIns['authorizedSiteID'] . "' checked />   " . $authorizedSiteIns['shortName'] . "</td>\n";
						}else{
							echo "<td><input class='check_authorizedSite' type='checkbox' name='" . $authorizedSiteIns['authorizedSiteID'] . "' id='" . $authorizedSiteIns['authorizedSiteID'] . "' value='" . $authorizedSiteIns['authorizedSiteID'] . "' />   " . $authorizedSiteIns['shortName'] . "</td>\n";
						}
						if(($i % 2)==0){
							echo "</tr>\n";
						}
					}

					if(($i % 2)==1){
						echo "<td>&nbsp;</td></tr>\n";
					}
					echo "</table>";
				}
				?>

			</td>
			</tr>
			</table>


		</td>
		<td>







			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='authorizedSiteID'><b><?php echo _("Administering Site(s)");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 295'>
			<tr>
			<td>
				<?php
				$i=0;
				if (count($administeringSiteArray) > 0){
					echo "<table class='noBorder 255 margin1520'>";
					foreach ($administeringSiteArray as $administeringSiteIns){
						$i++;
						if(($i % 2)==1){
							echo "<tr>\n";
						}
						if (in_array($administeringSiteIns['administeringSiteID'],$resourceAdministeringSiteArray)){
							echo "<td><input class='check_administeringSite' type='checkbox' name='" . $administeringSiteIns['administeringSiteID'] . "' id='" . $administeringSiteIns['administeringSiteID'] . "' value='" . $administeringSiteIns['administeringSiteID'] . "' checked />   " . $administeringSiteIns['shortName'] . "</td>\n";
						}else{
							echo "<td><input class='check_administeringSite' type='checkbox' name='" . $administeringSiteIns['administeringSiteID'] . "' id='" . $administeringSiteIns['administeringSiteID'] . "' value='" . $administeringSiteIns['administeringSiteID'] . "' />   " . $administeringSiteIns['shortName'] . "</td>\n";
						}
						if(($i % 2)==0){
							echo "</tr>\n";
						}
					}

					if(($i % 2)==1){
						echo "<td>&nbsp;</td></tr>\n";
					}
					echo "</table>";
				}
				?>

			</td>
			</tr>
			</table>

		</td>
		</table>


		<hr class='620 margin150100' />

		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitAccessChanges' id ='submitAccessChanges' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="kill(); tb_remove();" class='cancel-button'></td>
			</tr>
		</table>


		<script type="text/javascript" src="js/forms/accessForm.js?random=<?php echo rand(); ?>"></script>
