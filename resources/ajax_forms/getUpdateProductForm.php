<?php
	$resourceID = $_GET['resourceID'];
	$resource = new Resource(new NamedArguments(array('primaryKey' => $resourceID)));


		if (!is_null_date($resource->archiveDate)) {
			$archiveChecked = 'checked';
		}else{
			$archiveChecked = '';
		}


		//get all resource formats for output in drop down
		$resourceFormatArray = array();
		$resourceFormatObj = new ResourceFormat();
		$resourceFormatArray = $resourceFormatObj->sortedArray();

		//get all resource types for output in drop down
		$resourceTypeArray = array();
		$resourceTypeObj = new ResourceType();
		$resourceTypeArray = $resourceTypeObj->allAsArray();

    //get parents resources
    $sanitizedInstance = array();
    $instance = new Resource();
    $parentResourceArray = array();
    foreach ($resource->getParentResources() as $instance) {
      foreach (array_keys($instance->attributeNames) as $attributeName) {
        $sanitizedInstance[$attributeName] = $instance->$attributeName;
      }
      $sanitizedInstance[$instance->primaryKeyName] = $instance->primaryKey;
      array_push($parentResourceArray, $sanitizedInstance);
    }

		//get all alias types for output in drop down
		$aliasTypeArray = array();
		$aliasTypeObj = new AliasType();
		$aliasTypeArray = $aliasTypeObj->allAsArray();


		//get aliases
		$sanitizedInstance = array();
		$instance = new Alias();
		$aliasArray = array();
		foreach ($resource->getAliases() as $instance) {
			foreach (array_keys($instance->attributeNames) as $attributeName) {
				$sanitizedInstance[$attributeName] = $instance->$attributeName;
			}

			$sanitizedInstance[$instance->primaryKeyName] = $instance->primaryKey;

			$aliasType = new AliasType(new NamedArguments(array('primaryKey' => $instance->aliasTypeID)));
			$sanitizedInstance['aliasTypeShortName'] = $aliasType->shortName;

			array_push($aliasArray, $sanitizedInstance);
		}


		//get all organization roles for output in drop down
		$organizationRoleArray = array();
		$organizationRoleObj = new OrganizationRole();
		$organizationRoleArray = $organizationRoleObj->getArray();


		//get organizations (already returned in an array)
		$orgArray = $resource->getOrganizationArray();
?>
		<div id='div_resourceForm'>
		<form id='resourceForm'>
		<input type='hidden' name='editResourceID' id='editResourceID' value='<?php echo $resourceID; ?>'>

		<div class='formTitle 715 marginB5 relativeP'><span class='headerText'><?php echo _("Edit Resource");?></span></div>

		<span class='smallDarkRedText' id='span_errors'></span>

		<table class='noBorder wHundred'>
		<tr class='verticalAlignT'>
		<td class='verticalAlignT relativeP' colspan='2'>


			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='resourceFormatID'><b><?php echo _("Product");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 710'>
			<tr>
			<td>
				<table class='noBorder 670 margin15201020'>
				<tr>
				<td class='360'>
					<table id="general-resource-info">
					<tr>
					<td class='verticalAlignT textAlignL boldText'><label for='titleText'><?php echo _("Name:");?></label></td>
					<td><input type='text' id='titleText' name='titleText' value = "<?php echo $resource->titleText; ?>"  class='changeInput 260' /><span id='span_error_titleText' class='smallDarkRedText'></span></td>
					</tr>

					<tr>
					<td class='verticalAlignT textAlignL boldText'><label for='descriptionText'><?php echo _("Description:");?></label></td>
					<td><textarea rows='4' id='descriptionText' name='descriptionText' class='changeInput 260' ><?php echo $resource->descriptionText; ?></textarea></td>
					</tr>

					<tr>
					<td class='verticalAlignT textAlignL boldText' ><label for='resourceURL'><?php echo _("URL:");?></label></td>
					<td><input type='text' id='resourceURL' name='resourceURL' value = '<?php echo $resource->resourceURL; ?>' class='changeInput 260'  /></td>
					</tr>

					<tr>
					<td class='verticalAlignT textAlignL boldText'><label for='resourceAltURL'><?php echo _("Alt URL:");?></label></td>
					<td><input type='text' id='resourceAltURL' name='resourceAltURL' value = '<?php echo $resource->resourceAltURL; ?>' class='changeInput 260'  /></td>
					</tr>

					</table>

				</td>
				<td>
					<table>


					<tr>
          <td class='verticalAlignT textAlignL boldText'><label for='titleText'><?php echo _("Parents:");?></label></td>
					<td>

           <span id="newParent">
           <div class="oneParent">
           <input type='text' class='parentResource parentResource_new' name='parentResourceName' value='' class='changeInput 140'  /><input type='hidden' class='parentResource parentResource_new' name='parentResourceNewID' value='' /><span id='span_error_parentResourceName' class='smallDarkRedText'></span>
           <a href='#'><input class='addParent add-button' title='<?php echo _("add Parent Resource");?>' type='button' value='<?php echo _("Add");?>'/></a><br />
          </div>
           </span>

          <span id="existingParent">
          <?php
           $i = 1;
           foreach ($parentResourceArray as $parentResource) {
$parentResourceObj = new Resource(new NamedArguments(array('primaryKey' => $parentResource['relatedResourceID'])));
             ?>
              <div class="oneParent">
              <input type='text' name='parentResourceName' disabled='disabled' value = '<?php echo $parentResourceObj->titleText; ?>' class='changeInput 180'  />
              <input type='hidden' name='parentResourceID' value = '<?php echo $parentResourceObj->resourceID; ?>' />
              <a href='javascript:void();'><img src='images/cross.gif' alt='<?php echo _("remove parent");?>' title='<?php echo _("remove parent");?>' class='removeParent' /></a>
            </div>
<?php
             $i++;
           }
          ?>
          </span>
					</td>
					</tr>

					<tr>
					<td class='verticalAlignT textAlignL boldText'><label for='isbnOrISSN'><?php echo _("ISSN / ISBN:");?></label></td>
<td>
          <span id="newIsbn">
          	<div class="oneIssnIsbn">
           <input type='text' class='isbnOrISSN isbnOrISSN_new' name='isbnOrISSN' value = "" class='changeInput 97'  /><span id='span_errors_isbnOrISSN' class='smallDarkRedText'></span>
           <a href='javascript:void(0);'><input class='addIsbn add-button' title='<?php echo _("add Isbn");?>' type='button' value='<?php echo _("Add");?>'/></a><br />
       </div>
           </span>
           <span id="existingIsbn">
          <?php
           $isbnOrIssns = $resource->getIsbnOrIssn();
           $i = 1;
           foreach ($isbnOrIssns as $isbnOrIssn) {
             ?>
            <div class="oneIssnIsbn">
             	<input type='text' class='isbnOrISSN' name='isbnOrISSN' value = '<?php echo $isbnOrIssn->isbnOrIssn; ?>' class='changeInput 97'  />
				<a href='javascript:void();'><img src='images/cross.gif' alt='<?php echo _("remove Issn/Isbn");?>' title='<?php echo _("remove Issn/Isbn");?>' class='removeIssnIsbn' /></a>
            </div>
            <?php
             $i++;
           }
          ?>
          </span>
          </td>
					</tr>


					<tr>
					<td class='verticalAlignT textAlignL boldText'><label for='resourceFormatID'><?php echo _("Format:");?></label></td>
					<td>
					<select name='resourceFormatID' id='resourceFormatID' class='changeSelect wHundred'>
					<option value=''></option>
					<?php
					foreach ($resourceFormatArray as $resourceFormat){
						if (!(trim(strval($resourceFormat['resourceFormatID'])) != trim(strval($resource->resourceFormatID)))){
							echo "<option value='" . $resourceFormat['resourceFormatID'] . "' selected>" . $resourceFormat['shortName'] . "</option>\n";
						}else{
							echo "<option value='" . $resourceFormat['resourceFormatID'] . "'>" . $resourceFormat['shortName'] . "</option>\n";
						}
					}
					?>
					</select>
					</td>
					</tr>


					<tr>
					<td class='verticalAlignT textAlignL boldText'><label for='resourceTypeID'><?php echo _("Type:");?></label></td>
					<td>
					<select name='resourceTypeID' id='resourceTypeID' class='changeSelect wHundred' >
					<option value=''></option>
					<?php
					foreach ($resourceTypeArray as $resourceType){
						if (!(trim(strval($resourceType['resourceTypeID'])) != trim(strval($resource->resourceTypeID)))){
							echo "<option value='" . $resourceType['resourceTypeID'] . "' selected>" . $resourceType['shortName'] . "</option>\n";
						}else{
							echo "<option value='" . $resourceType['resourceTypeID'] . "'>" . $resourceType['shortName'] . "</option>\n";
						}
					}
					?>
					</select>

					</td>
					</tr>

					<tr>
					<td class='textAlignL'><label for='archiveInd'><b><?php echo _("Archived:");?></b></label></td>
					<td>
					<input type='checkbox' id='archiveInd' name='archiveInd' <?php echo $archiveChecked; ?> />
					</td>
					</tr>

					</table>
				</td>
				</tr>
				</table>
			</td>
			</tr>
			</table>

			<div class='h10'>&nbsp;</div>

			</td>
			</tr>
			<tr class='verticalAlignT'>
			<td>

			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='resourceFormatID'><b><?php echo _("Organizations"); ?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 380'>
			<tr>
			<td>

				<table class='noBorder smallPadding newOrganizationTable 330 margin1520020'>
				<tr>
					<td class='verticalAlignT textAlignL boldText 103'><?php echo _("Role:");?></td>
					<td class='verticalAlignT textAlignL boldText 160'><?php echo _("Organization:");?></td>
					<td>&nbsp;</td>
				</tr>

				<tr class='newOrganizationTR'>
				<td class='verticalAlignT textAlignL'>
					<select class='changeSelect organizationRoleID 100 lightGrey'>
					<option value=''></option>
					<?php
					foreach ($organizationRoleArray as $organizationRoleID => $organizationRoleShortName){
						echo "<option value='" . $organizationRoleID . "'>" . $organizationRoleShortName . "</option>\n";
					}
					?>
					</select>
				</td>

				<td class='verticalAlignT textAlignL' >
				<input type='text' value = '' class='changeAutocomplete organizationName 160 lightGrey' />
				<input type='hidden' class='organizationID' value = '' />
				</td>
				<td class='verticalAlignT textAlignL 40'>
				<a href='javascript:void();'><input class='addOrganization add-button' title='<?php echo _("add organization");?>' type='button' value='<?php echo _("Add");?>'/></a>
				</td>
				</tr>
				</table>
				<div class='smallDarkRedText margin020726' id='div_errorOrganization'></div>

				<table class='noBorder smallPadding organizationTable 330 margin0201020'>
				<tr>
				<td colspan='3'>
					<hr class='310 margin0055' />
				</td>
				</tr>

				<?php
				if (count($orgArray) > 0){

					foreach ($orgArray as $organization){
					?>
						<tr>
						<td class='verticalAlignT textAlignL'>
						<select class='organizationRoleID changeSelect 100'>
						<option value=''></option>
						<?php
						foreach ($organizationRoleArray as $organizationRoleID => $organizationRoleShortName){
							if (!(trim(strval($organizationRoleID)) != trim(strval($organization['organizationRoleID'])))){
								echo "<option value='" . $organizationRoleID . "' selected>" . $organizationRoleShortName . "</option>\n";
							}else{
								echo "<option value='" . $organizationRoleID . "'>" . $organizationRoleShortName . "</option>\n";
							}
						}
						?>
						</select>
						</td>

						<td class='verticalAlignT textAlignL'>
						<input type='text' class='changeInput organizationName' value = '<?php echo $organization['organization']; ?>' class='changeInput 160' />
						<input type='hidden' class='organizationID' value = '<?php echo $organization['organizationID']; ?>' />
						</td>

						<td class='verticalAlignT textAlignL 40'>
							<a href='javascript:void();'><img src='images/cross.gif' alt="<?php echo _("remove organization");?>" title="<?php echo _("remove organization");?>" class='remove' /></a>
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
		<td>

			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='resourceFormatID'><b><?php echo _("Aliases");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 300'>
			<tr>
			<td>

				<table class='noBorder smallPadding newAliasTable 260 margin1520020'>
				<tr>
					<td class='verticalAlignT textAlignL boldText 98'><?php echo _("Type:");?></td>
					<td class='verticalAlignT textAlignL boldText 125'><?php echo _("Alias:");?></td>
					<td>&nbsp;</td>
				</tr>


				<tr class='newAliasTR'>
				<td class='verticalAlignT textAlignL'>
					<select class='changeSelect aliasTypeID 98 lightGrey'>
					<option value='' selected></option>
					<?php
					foreach ($aliasTypeArray as $aliasType){
						echo "<option value='" . $aliasType['aliasTypeID'] . "' class='changeSelect'>" . $aliasType['shortName'] . "</option>\n";
					}
					?>
					</select>
				</td>

				<td class='verticalAlignT textAlignL'>
				<input type='text' value = '' class='changeDefault aliasName 125' />
				</td>

				<td class='verticalAlignC textAlignL 37'>
				<a href='javascript:void();'><input class='addAlias add-button' title='<?php echo _("add alias");?>' type='button' value='<?php echo _("Add");?>'/></a>
				</td>
				</tr>
				</table>
				<div class='smallDarkRedText margin020726' id='div_errorAlias'></div>


				<table class='noBorder smallPadding aliasTable 260 margin0201020'>
				<tr>
				<td colspan='3'>
				<hr class='240 margin0055' />
				</td>
				</tr>

				<?php
				if (count($aliasArray) > 0){

					foreach ($aliasArray as $resourceAlias){
					?>
						<tr>
						<td class='verticalAlignT textAlignL'>
						<select class='changeSelect aliasTypeID 98'>
						<option value=''></option>
						<?php
						foreach ($aliasTypeArray as $aliasType){
							if (!(trim(strval($aliasType['aliasTypeID'])) != trim(strval($resourceAlias['aliasTypeID'])))){
								echo "<option value='" . $aliasType['aliasTypeID'] . "' selected class='changeSelect'>" . $aliasType['shortName'] . "</option>\n";
							}else{
								echo "<option value='" . $aliasType['aliasTypeID'] . "' class='changeSelect'>" . $aliasType['shortName'] . "</option>\n";
							}
						}
						?>
						</select>
						</td>

						<td class='verticalAlignT textAlignL'>

						<input type='text' value = '<?php echo htmlentities($resourceAlias['shortName'], ENT_QUOTES); ?>'  class='changeInput aliasName 125' />
						</td>

						<td class='verticalAlignT textAlignL 37'>
							<a href='javascript:void();'><img src='images/cross.gif' alt='<?php echo _("remove this alias");?>' title='<?php echo _("remove this alias");?>' class='remove' /></a>
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


		<hr class='715 margin150100' />

		<table class='noBorderTable 125'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' name='submitProductChanges' id ='submitProductChanges' class='submit-button'></td>
				<td class='textAlignR'><input type='button' value='<?php echo _("cancel");?>' onclick="kill(); tb_remove();" class='cancel-button'></td>
			</tr>
		</table>
		<script type="text/javascript" src="js/forms/resourceUpdateForm.js?random=<?php echo rand(); ?>"></script>
