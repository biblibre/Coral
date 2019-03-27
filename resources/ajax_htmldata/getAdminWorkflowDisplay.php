<?php

		$workflow = new Workflow();
		$workflowArray = $workflow->allAsArray();

		$userGroup = new UserGroup();
		$userGroupArray = $userGroup->allAsArray();
		?>

		<section class= "tabTitle">
			<?php
		echo "<div class='adminRightHeader'>"._("Workflow Setup")."</div>";
		if (count($userGroupArray) >0){
			echo "<div><a href='ajax_forms.php?action=getAdminWorkflowForm&workflowID=&height=528&width=750&modal=true' class='thickbox'><img id='addWorflowSetup' src='images/plus.gif' title='"._("add workflow")."' /></a></div>";
		}else{
			echo "<div><i>"._("You must set up at least one user group before you can add workflows")."</i></div>";
		}
			?>
		  </section>
		</br>


			<?php
		if (count($workflowArray) > 0){
			?>
			<table class='linedDataTable' style='width:100%'>
				<tr>
				<th><?php echo _("Acquisition Type");?></th>
				<th><?php echo _("Resource Format");?></th>
				<th><?php echo _("Resource Type");?></th>
				<th style='width:20px;'>&nbsp;</th>
				<th style='width:20px;'>&nbsp;</th>
				<th style='width:20px;'>&nbsp;</th>
				</tr>
				<?php

				foreach($workflowArray as $wf) {

					if (($wf['resourceFormatIDValue'] != '') && ($wf['resourceFormatIDValue'] != '0')){
                        $resourceFormat = new ResourceFormat(new NamedArguments(array('primaryKey' => $wf['resourceFormatIDValue'])));
                        $rfName = $resourceFormat->shortName;
                    } else {
                        $rfName = 'any';
                    }

					if (($wf['acquisitionTypeIDValue'] != '') && ($wf['acquisitionTypeIDValue'] != '0')){
                        $acquisitionType = new AcquisitionType(new NamedArguments(array('primaryKey' => $wf['acquisitionTypeIDValue'])));
                        $atName = $acquisitionType->shortName;
                    } else {
                        $atName = 'any';
                    }
					if (($wf['resourceTypeIDValue'] != '') && ($wf['resourceTypeIDValue'] != '0')){
						$resourceType = new ResourceType(new NamedArguments(array('primaryKey' => $wf['resourceTypeIDValue'])));
						$rtName = $resourceType->shortName;
					}else{
						$rtName = 'any';
					}

					echo "<tr>";
					echo "<td>" . $atName . "</td>";
					echo "<td>" . $rfName . "</td>";
					echo "<td>" . $rtName . "</td>";
					echo "<td><a href='ajax_forms.php?action=getAdminWorkflowForm&workflowID=" . $wf['workflowID'] . "&height=528&width=750&modal=true' class='thickbox'><img src='images/edit.gif' alt='"._("edit")."' title='"._("edit")."'></a></td>";
					echo "<td><a href='javascript:duplicateWorkflow(" . $wf['workflowID'] . ")'><img src='images/notes.gif' alt='"._("duplicate")."' title='"._("duplicate")."'></a></td>";
					echo "<td><a href='javascript:deleteWorkflow(\"Workflow\", " . $wf['workflowID'] . ");'><img src='images/cross.gif' alt='"._("remove")."' title='"._("remove")."'></a></td>";
					echo "</tr>";
				}

				?>
			</table>
			<?php

		}else{
			echo _("(none found)")."<br />";
		}


		//user groups are required to set workflows up so display this message if there arent any



		?>


		<br /><br /><br /><br />

		<section class= "tabTitle">
		<?php
		echo "<div class='adminRightHeader'>"._("User Group Setup")."</div>";
		echo "<a href='ajax_forms.php?action=getAdminUserGroupForm&userGroupID=&height=400&width=305&modal=true' class='thickbox'>"._("add user group")."</a>";

		?>
		</section>
		</br>
		<?php

		if (count($userGroupArray) > 0){
			?>
			<table class='linedDataTable' style='width:100%'>
				<tr>
				<th><?php echo _("Group Name");?></th>
				<th><?php echo _("Email Address");?></th>
				<th><?php echo _("Users");?></th>
				<th style='width:20px;'>&nbsp;</th>
				<th style='width:20px;'>&nbsp;</th>
				</tr>
				<?php

				foreach($userGroupArray as $ug) {
					$userGroup = new UserGroup(new NamedArguments(array('primaryKey' => $ug['userGroupID'])));
					echo "<tr>";
					echo "<td>" . $userGroup->groupName . "</td>";
					echo "<td>" . $userGroup->emailAddress . "</td>";
					echo "<td>";
					foreach ($userGroup->getUsers() as $groupUser){
						echo $groupUser->getDisplayName . "<br />";
					}
					echo "</td>";
					echo "<td><a href='ajax_forms.php?action=getAdminUserGroupForm&userGroupID=" . $userGroup->userGroupID . "&height=400&width=305&modal=true' class='thickbox'><img src='images/edit.gif' alt='"._("edit")."' title='"._("edit")."'></a></td>";
					echo "<td><a href='javascript:deleteWorkflow(\"UserGroup\", " . $userGroup->userGroupID . ");'><img src='images/cross.gif' alt='"._("remove")."' title='"._("remove")."'></a></td>";
					echo "</tr>";
				}

				?>
			</table>
			<?php

		}else{
			echo _("(none found)")."<br />";
		}



?>
