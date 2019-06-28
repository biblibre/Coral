<?php


$pageTitle = _("Edit Publishers / Platforms");


include 'templates/header.php';


?>

<script type="text/javascript" src="js/publisherPlatformList.js"></script>

<table class="headerTable">
<tr><td>
<div class="headerText"><?php echo _("Publisher / Platform Update");?></div>

  <br />

  <?php

	echo "<div class='linHeight130 marginL5 textAlignL'>\n";

	$platforms = new Platform();
	$platform = array();
	$platformArray = $platforms->getPlatformArray();

	if (count($platformArray) > 0){
		foreach($platformArray as $platform) {
			echo "<div class='marginB15'>";
			echo "<span class='PlatformText'>" . $platform['name'] . "</span>&nbsp;&nbsp;<a href='publisherPlatform.php?platformID=" . $platform['platformID'] . "' class='smallLink'>" . _("view / edit") . "</a>";
			echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:showPublisherList('" . $platform['platformID'] . "');\"><img src='images/arrowright.gif'class='border0' alt='" . _("show publisher list") . "' id='image_" . $platform['platformID'] . "'></a>&nbsp;<a href=\"javascript:showPublisherList('" . $platform['platformID'] . "');\" id='link_" . $platform['platformID'] . "'>" . _("show publisher list") . "</a><br />";

			echo "<div id='div_" . $platform['platformID'] . "' class='noDisplaying w600px marginL40'>";

			$platformObj = new Platform(new NamedArguments(array('primaryKey' => $platform['platformID'])));

			//loop through each publisher under this platform
			$publisherPlatform = new PublisherPlatform();
			foreach($platformObj->getPublisherPlatforms() as $publisherPlatform) {
				$publisher = new Publisher(new NamedArguments(array('primaryKey' => $publisherPlatform->publisherID)));
				echo $publisher->name . "&nbsp;&nbsp;<a href='publisherPlatform.php?publisherPlatformID=" . $publisherPlatform->publisherPlatformID . "'>" . _("view / edit") . "</a><br />";
			}

			echo "</div>";
			echo "</div>";

		}
	}else{
		echo "<i>" . _("No publishers / platforms found.") . "</i>";
	}

	echo "</div>\n";

  ?>

</td>
</tr>
</table>


<?php include 'templates/footer.php'; ?>
