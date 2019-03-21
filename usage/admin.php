<?php
$pageTitle = _('Administration');
include 'templates/header.php';


if ($user->isAdmin()){
?>

<div class= "container-fluid">
	<div class="row">
		<div class="col-2">
			<div class="list-group" id="list-tab" role="tablist">
				<a href='javascript:void(0);' class='updateUserList'><button type="button"><?php echo _("Users");?></button></a>
				<a href='javascript:void(0);' class='updateLogEmailAddressTable'><button type="button"><?php echo _("Email addresses for logs");?></button></a>
				<a href='javascript:void(0);'  class='updateOutlierTable' ><button type="button"><?php echo _("Outlier Parameters   ");?></button></a>
			</div>
		</div>
				<div class="col-10"><div class="AdminContentUsers" id='div_AdminContent'></div></div>
	</div>
</div>

<script type="text/javascript" src="js/admin.js"></script>

<?php

}

include 'templates/footer.php';

?>
