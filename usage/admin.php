<?php
$pageTitle = _('Administration');
include 'templates/header.php';


if ($user->isAdmin()){
?>

<div class="elementsAlign">
	<div class="menu">

			<table class='adminMenuTable' style='width:170px;'>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateUserList'><?php echo _("Users");?></a></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='updateLogEmailAddressTable'><?php echo _("Email addresses for logs");?></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);'  class='updateOutlierTable' ><?php echo _("Outlier Parameters   ");?></div></td></tr>
			</table>

	</div>



<div id='div_AdminContent'></div>



<script type="text/javascript" src="js/admin.js"></script>

<?php

}

include 'templates/footer.php';

?>
