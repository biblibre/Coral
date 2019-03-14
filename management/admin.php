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


<table style='width:700px; text-align:left; vertical-align:top;'>
<tr>
<td style='width:170px;vertical-align:top;'>
	<table class='adminMenuTable' style='width:170px;'>
		<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class=''><?php echo _("Users");?></a></div></td></tr>
		<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='AdminLink' id='DocumentType'><?php echo _("Documents Type");?></div></td></tr>
		<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' id='' class=''><?php echo _("Notes type");?></div></td></tr>
		<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' id='' class='AdminLink'><?php echo _("Categories");?></div></td></tr>
	</table>

	<div id="div_AdminContent"></div>

<script type="text/javascript" src="js/admin.js"></script>


<?php
}else{
	echo _("You don't have permission to access this page");
}

include 'templates/footer.php';
?>
