<?php


		$resourceArray = array();
		$resourceArray = $user->getOutstandingTasks();

		echo "<div class='adminRightHeader'>"._("Outstanding Tasks")."</div>";



		if (count($resourceArray) == "0"){
			echo "<i>"._("No outstanding requests")."</i>";
		}else{
		?>


			<table class='dataTable 646 padZero marginZero wHundred'>
			<tr>
				<th class='45'><?php echo _("ID");?></th>
				<th class='300'><?php echo _("Name");?></th>
				<th class='300'><?php echo _("Order");?></th>
				<th class='95'><?php echo _("Acquisition Type");?></th>
				<th class='125'><?php echo _("Workflow Step");?></th>
				<th class='75'><?php echo _("Start Date");?></th>
			</tr>

		<?php
			$i=0;
			foreach ($resourceArray as $resource){
				$taskArray = $user->getOutstandingTasksByResource($resource['resourceID']);
				$countTasks = count($taskArray);

				//for shading every other row
				$i++;
				if ($i % 2 == 0){
					$classAdd="";
				}else{
					$classAdd="class='alt'";
				}



				$acquisitionType = new AcquisitionType(new NamedArguments(array('primaryKey' => $resource['acquisitionTypeID'])));
				$status = new Status(new NamedArguments(array('primaryKey' => $resource['statusID'])));

		?>
				<tr id='tr_<?php echo $resource['resourceID']; ?>' class='padZero marginZero wHundred'>
					<td <?php echo $classAdd; ?>><a href='resource.php?resourceID=<?php echo $resource['resourceID']; ?>&resourceAcquisitionID=<?php echo $resource['resourceAcquisitionID']?>'><?php echo $resource['resourceID']; ?></a></td>
					<td <?php echo $classAdd; ?>><a href='resource.php?resourceID=<?php echo $resource['resourceID']; ?>&resourceAcquisitionID=<?php echo $resource['resourceAcquisitionID']?>'><?php echo $resource['titleText']; ?></a></td>
					<td <?php echo $classAdd; ?>><?php echo $resource['subscriptionStartDate']; ?> - <?php echo $resource['subscriptionEndDate']; ?></a></td>
					<td <?php echo $classAdd; ?>><?php echo $acquisitionType->shortName; ?></td>

					<?php
						$j=0;


						if (count($taskArray) > 0){
							foreach ($taskArray as $task){
								if ($j > 0){
								?>
								<tr>
								<td <?php echo $classAdd; ?> class='noBorderTopStyle'>&nbsp;</td>
								<td <?php echo $classAdd; ?> class='noBorderTopStyle'>&nbsp;</td>
								<td <?php echo $classAdd; ?> class='noBorderTopStyle'>&nbsp;</td>
								<td <?php echo $classAdd; ?> class='noBorderTopStyle'>&nbsp;</td>

								<?php
									$styleAdd=" style='border-top-style:none;'";
								}else{
									$styleAdd="";
								}


								echo "<td " . $classAdd . " " . $styleAdd . ">" . $task['stepName'] . "</td>";
								echo "<td " . $classAdd . " " . $styleAdd . ">" . format_date($task['startDate']) . "</td>";
								echo "</tr>";

								$j++;
							}

						}else{
							echo "<td " . $classAdd . ">&nbsp;</td><td " . $classAdd . ">&nbsp;</td></tr>";
						}


			}

			echo "</table>";


		}

?>
