<?php

		$resourceID = $_GET['resourceID'];
		if ($resourceID){
		$resource = new Resource(new NamedArguments(array('primaryKey' => $resourceID)));
		}else{
			$resource = new Resource();
		}

        // get resource acquisition for this resource
        // at this point, there are none (resource not saved yet)
        // or only one (resource saved as draft)
        if ($resource->resourceID) {
            $resourceAcquisitions = $resource->getResourceAcquisitions();
            $resourceAcquisition = $resourceAcquisitions[0];
        }

		//used for default currency
		$config = new Configuration();

		//get all acquisition types for output in drop down
		$acquisitionTypeArray = array();
		$acquisitionTypeObj = new AcquisitionType();
		$acquisitionTypeArray = $acquisitionTypeObj->sortedArray();

		//get all resource formats for output in drop down
		$resourceFormatArray = array();
		$resourceFormatObj = new ResourceFormat();
		$resourceFormatArray = $resourceFormatObj->sortedArray();

		//get all resource types for output in drop down
		$resourceTypeArray = array();
		$resourceTypeObj = new ResourceType();
		$resourceTypeArray = $resourceTypeObj->allAsArray();


		//get all currency for output in drop down
		$currencyArray = array();
		$currencyObj = new Currency();
		$currencyArray = $currencyObj->allAsArray();

		//get all Order Types for output in drop down
		$orderTypeArray = array();
		$orderTypeObj = new OrderType();
		$orderTypeArray = $orderTypeObj->allAsArray();

		//get all Cost Details for output in drop down
		$costDetailsArray = array();
		$costDetailsObj = new CostDetails();
		$costDetailsArray = $costDetailsObj->allAsArray();

		//get notes
		if ($resourceID){
			$resourceNote = $resource->getInitialNote;
		}else{
			$resourceNote = new ResourceNote();
		}

		$orgArray = $resource->getOrganizationArray();
		if (count($orgArray)>0){
			foreach ($orgArray as $org){
				$providerText = $org['organization'];
				$orgID = $org['organizationID'];
			}
		}else{
			$providerText = $resource->providerText;
			$orgID = '';
		}
?>
		<div id='div_resourceSubmitForm'>
		<form id='resourcePromptForm'>


		<input type='hidden' id='organizationID' value='<?php echo $orgID; ?>' />
		<input type='hidden' id='editResourceID' value='<?php echo $resourceID; ?>' />
		<div class='formTitle 745'><span class='headerText'><?php if ($resourceID) { echo _("Edit Saved Resource"); }else{ echo _("Add New Resource"); } ?></span></div>
		<div class='smallDarkRedText margin3000 h14'>&nbsp;* <?php echo _("required fields");?></div>

		<table class='noBorder'>
		<tr class='verticalAlignT'>
		<td class='verticalAlignT paddingR35'>

			<span class='surroundBoxTitle'>&nbsp;&nbsp;<b><?php echo _("Product");?></b>&nbsp;&nbsp;</span>

			<table class='surroundBox 350'>
			<tr>
			<td>

				<table class='noBorder 310 margin515'>

					<tr>
					<td class='verticalAlignT ext-align:left'><label for='titleText'><?php echo _("Name:");?>&nbsp;&nbsp;<span class='bigDarkRedText'>*</span></label></td>
					<td><input type='text' id='titleText' class='changeInput 220' value="<?php echo $resource->titleText; ?>" /><span id='span_error_titleText' class='smallDarkRedText'></span></td>
					</tr>

					<tr>
					<td class='verticalAlignT textAlignL'><label for='descriptionText'><?php echo _("Description:");?></label></td>
					<td><textarea rows='3' id='descriptionText' class='223'><?php echo $resource->descriptionText; ?></textarea></td>
					</tr>

					<tr>
					<td class='verticalAlignT textTopLeft'><label for='providerText'><?php echo _("Provider:");?></label></td>
					<td><input type='text' id='providerText' class='changeInput 220' value='<?php echo $providerText; ?>' /><span id='span_error_providerText' class='smallDarkRedText'></span></td>
					</tr>

					<tr>
					<td class='verticalAlignT textAlignL'><label for='resourceURL'><?php echo _("URL:");?></label></td>
					<td><input type='text' id='resourceURL'  class='changeInput 220' value='<?php echo $resource->resourceURL; ?>' /><span id='span_error_resourceURL' class='smallDarkRedText'></span></td>
					</tr>

					<tr>
					<td class='verticalAlignT textAlignL'><label for='resourceAltURL'><?php echo _("Alt URL:");?></label></td>
					<td><input type='text' id='resourceAltURL' class='changeInput 220' value='<?php echo $resource->resourceAltURL; ?>' /><span id='span_error_resourceAltURL' class='smallDarkRedText'></span></td>
					</tr>

				</table>
			</td>
			</tr>
			</table>



			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='resourceFormatID'><b><?php echo _("Format");?></b></label>&nbsp;<span class='bigDarkRedText'>*</span>&nbsp;&nbsp;</span>

			<table class='surroundBox 350'>
			<tr>
			<td>
<span id='span_error_resourceFormatID' class='smallDarkRedText'></span>

				<table class='noBorder 310 margin515'>
				<?php
				$i=0;

				foreach ($resourceFormatArray as $resourceFormat){
					$i++;
					if(($i % 2)==1){
						echo "<tr>\n";
					}

					//determine default
					if ($resourceID){
						if ($resourceFormat['resourceFormatID'] == $resource->resourceFormatID) $checked = 'checked'; else $checked = '';
					//otherwise default to electronic
					}else{
						if (strtoupper($resourceFormat['shortName']) == 'ELECTRONIC') $checked = 'checked'; else $checked = '';
					}

					echo "<td><input type='radio' name='resourceFormatID' id='resourceFormatID' value='" . $resourceFormat['resourceFormatID'] . "' " . $checked . " />  " . $resourceFormat['shortName'] . "</td>";

					if(($i % 2)==0){
						echo "</tr>\n";
					}
				}

				if(($i % 2)==1){
					echo "<td>&nbsp;</td></tr>\n";
				}

				?>

				</table>

			</td>
			</tr>
			</table>


			<span class='surroundBoxTitle'>&nbsp;&nbsp;<b><?php echo _("Acquisition Type");?></b>&nbsp;<span class='bigDarkRedText'>*</span>&nbsp;&nbsp;</span>

			<table class='surroundBox 350'>
			<tr>
			<td>

				<table class='noBorder smallPadding 310 margin515'>
				<?php
				$i=0;

				foreach ($acquisitionTypeArray as $acquisitionType){
					$i++;
					if(($i % 3)==1){
						echo "<tr>\n";
					}

					//set default
					if ($resourceID){
						if ($acquisitionType['acquisitionTypeID'] == $resourceAcquisition->acquisitionTypeID) $checked = 'checked'; else $checked = '';
					}else{
						if (strtoupper($acquisitionType['shortName']) == 'PAID') $checked = 'checked'; else $checked = '';
					}

					echo "<td><input type='radio' name='acquisitionTypeID' id='acquisitionTypeID' value='" . $acquisitionType['acquisitionTypeID'] . "' " . $checked . " />  " . $acquisitionType['shortName'] . "</td>\n";

					if(($i % 3)==0){
						echo "</tr>\n";
					}
				}

				if(($i % 3)==1){
					echo "<td>&nbsp;</td><td>&nbsp;</td></tr>\n";
				}else if(($i % 3)==2){
					echo "<td>&nbsp;</td></tr>\n";
				}

				?>

				</table>

			</td>
			</tr>
			</table>

		</td>
		<td>

			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='resourceTypeID'><b><?php echo _("Resource Type");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 350'  id='resource-type'>
			<tr>
			<td>

				<table class='noBorder 320 margin515'>
				<?php
				$i=0;

				foreach ($resourceTypeArray as $resourceType){
					$i++;
					if(($i % 3)==1){
						echo "<tr>\n";
					}

					$checked='';
					//determine default checked
					if ($resourceID){
						if (strtoupper($resourceType['resourceTypeID']) == $resource->resourceTypeID) $checked = 'checked';
					}

					echo "<td><input type='radio' name='resourceTypeID' id='resourceTypeID' value='" . $resourceType['resourceTypeID'] . "' " . $checked . "/>" . $resourceType['shortName'] . "</td>\n";

					if(($i % 3)==0){
						echo "</tr>\n";
					}
				}

				if(($i % 3)==1){
					echo "<td>&nbsp;</td><td>&nbsp;</td></tr>\n";
				}else if(($i % 3)==2){
					echo "<td>&nbsp;</td></tr>\n";
				}

				?>

				</table>
				<span id='span_error_resourceTypeID' class='smallDarkRedText'></span>

			</td>
			</tr>
			</table>



			<span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='resourceFormatID'><b><?php echo _("Notes");?></b></label>&nbsp;&nbsp;</span>

			<table class='surroundBox 350'>
			<tr>
			<td>

				<table class='noBorder smallPadding 320 margin715'>

					<tr>
					<td classe='verticalAlignT textAlignL'><span class='smallGreyText'><?php echo _("Include any additional information");?></span><br />
					<textarea rows='5' id='noteText' name='noteText' class='310'><?php echo $resourceNote->noteText; ?></textarea></td>
					</tr>
				</table>
			</td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

		<hr class='745 margin150100'/>

		<table class='noBorderTable 175'>
			<tr>
				<td class='textAlignL'><input type='button' value='<?php echo _("save");?>' id='save' class='submitResource save-button'></td>
				<td class='textAlignL'><input type='button' value='<?php echo _("submit");?>' id='progress' class='submitResource submit-button'></td>
				<td class='textAlignL'><input type='button' value='<?php echo _("cancel");?>' onclick="kill(); tb_remove()" class='cancel-button'></td>
			</tr>
		</table>


		</form>
		</div>

		<script type="text/javascript" src="js/forms/resourceNewForm.js?random=<?php echo rand(); ?>"></script>
