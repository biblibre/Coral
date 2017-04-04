<?php
$resourceID = $_GET['resourceID'];
$resourceAcquisitionID = $_GET['resourceAcquisitionID'];

	$resource = new Resource(new NamedArguments(array('primaryKey' => $resourceID)));
	$resourceAcquisition = new ResourceAcquisition(new NamedArguments(array('primaryKey' => $resourceAcquisitionID)));

	$orderType = new OrderType(new NamedArguments(array('primaryKey' => $resource->orderTypeID)));
		$acquisitionType = new AcquisitionType(new NamedArguments(array('primaryKey' => $resource->acquisitionTypeID)));

		//get purchase sites
		$sanitizedInstance = array();
		$instance = new PurchaseSite();
		$purchaseSiteArray = array();
		foreach ($resource->getResourcePurchaseSites($resourceAcquisitionID) as $instance) {
			$purchaseSiteArray[]=$instance->shortName;
		}

?>
		<table class='linedFormTable' style='width:<?php echo $tableWidth; ?>px;padding:0x;margin:0px;height:100%;'>
			<tr>
			<th colspan='2' style='vertical-align:bottom;'>
			<span style='float:left;vertical-align:bottom;'><?php echo _("Order");?></span>
			<?php if ($user->canEdit()){ ?>
				<span style='float:right;vertical-align:bottom;'><a href='ajax_forms.php?action=getOrderForm&height=400&width=440&modal=true&resourceID=<?php echo $resourceID; ?>' class='thickbox' id='editOrder'><img src='images/edit.gif' alt='<?php echo _("edit");?>' title='<?php echo _("edit order information");?>'></a></span>
			<?php } ?>

			</th>
			</tr>

			<?php if ($resource->acquisitionTypeID) { ?>
				<tr>
				<td style='vertical-align:top;width:110px;'><?php echo _("Acquisition Type:");?></td>
				<td style='width:350px;'><?php echo $acquisitionType->shortName; ?></td>
				</tr>
			<?php } ?>

			<?php if ($resource->orderNumber) { ?>
				<tr>
				<td style='vertical-align:top;width:110px;'><?php echo _("Order Number:");?></td>
				<td style='width:350px;'><?php echo $resource->orderNumber; ?></td>
				</tr>
			<?php } ?>

			<?php if ($resource->systemNumber) { ?>
				<tr>
				<td style='vertical-align:top;width:110px;'><?php echo _("System Number:");?></td>
				<td style='width:350px;'>
				<?php
					echo $resource->systemNumber;
					if ($config->settings->catalogURL != ''){
						echo "&nbsp;&nbsp;<a href='" . $config->settings->catalogURL . $resource->systemNumber . "' target='_blank'>"._("catalog view")."</a>";
					}
				?>
				</td>
				</tr>
			<?php } ?>

			<?php if (count($purchaseSiteArray) > 0) { ?>
				<tr>
				<td style='vertical-align:top;width:110px;'><?php echo _("Purchasing Sites:");?></td>
				<td style='width:350px;'><?php echo implode(", ", $purchaseSiteArray); ?></td>
				</tr>
			<?php } ?>

			<?php if (($resource->currentStartDate) && ($resource->currentStartDate != '0000-00-00')) { ?>
			<tr>
			<td style='vertical-align:top;width:110px;'><?php echo _("Sub Start:");?></td>
			<td style='width:350px;'><?php echo format_date($resource->currentStartDate); ?></td>
			</tr>
			<?php } ?>

			<?php if (($resource->currentEndDate) && ($resource->currentEndDate != '0000-00-00')) { ?>
			<tr>
			<td style='vertical-align:top;width:110px;'>Current Sub End:</td>
			<td style='width:350px;'><?php echo format_date($resource->currentEndDate); ?>&nbsp;&nbsp;
			<?php if ($resource->subscriptionAlertEnabledInd == "1") { echo "<i>"._("Expiration Alert Enabled")."</i>"; } ?>
			</td>
			</tr>
			<?php } ?>

			</table>
			<?php if ($user->canEdit()){ ?>
				<a href='ajax_forms.php?action=getOrderForm&height=400&width=440&modal=true&resourceID=<?php echo $resourceID; ?>' class='thickbox'><?php echo _("edit order information");?></a>
			<?php } ?>

