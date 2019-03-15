<?php

/*
**************************************************************************************************************************
** CORAL Management Module v. 1.0
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

$pageTitle=_('Administration');
include 'templates/header.php';

//set referring page
$_SESSION['ref_script']=$currentPage;

if ($user->isAdmin()){

?>

<div class="container-fluid">
	<div class="row ">
		<div class="col-2">
			<div class="list-group ButtonMenu" id="list-tab" role="tablist">
				<a href='javascript:void(0);' class='updateUserList'><button id="PreSelectedButton" type="button"><?php echo _("Users");?></button></a>
				<a href='javascript:void(0);' id='DocumentType' class='updateTable' ><button type="button"><?php echo _("Document Types");?></button></a>
				<a href='javascript:void(0);' id='DocumentNoteType' class='updateTable'><button type="button"><?php echo _("Note Types");?></button></a>
				<a href='javascript:void(0);' id='Consortium' class='updateTable'><button type="button"><?php echo _("Categories");?></button></a>
			<!-- disabled menu part
			<a href='javascript:void(0);'  class='updateQualifierList'><php /*echo _("Qualifier");?></a>
			<a href='javascript:void(0);'  class='updateExpressionTypeList'><php /*echo _("Expression");?></a>
		-->
			</div>
		</div>
			<div class="col-10" ><div class="adminContentAlign"><div id='div_AdminContent'></div></div></div>
	</div>
</div>




<script type="text/javascript" src="js/admin.js"></script>

<?php
}else{
	echo _("You don't have permission to access this page");
}

include 'templates/footer.php';
?>
