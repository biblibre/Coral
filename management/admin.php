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
<div class="elementsAlign">
	<div class="menu">

			<table class='adminMenuTable' style='width:170px;'>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' class='adminUsers'><?php echo _("Users");?></a></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' id='docsTab' class='adminDocType'><?php echo _("Documents Type");?></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' id='notesTab' class='adminNoteType' ><?php echo _("Notes Types");?></div></td></tr>
				<tr><td><div class='adminMenuLink'><a href='javascript:void(0);' id='catTab' class='adminCat'><?php echo _("Catégories");?></div></td></tr>
			</table>

	</div>



<div class="displayedTables">

		<p>Voici la table</p>
		<div style='margin-top:5px;' id='parole'></div>
	</div>




<script type="text/javascript" src="js/admin.js"></script>
								</center>



<script>
$(function() {
		$('#usersTab').click( function(){
		$('#parole').load('adminTab.php #bla', function(){
		
		})
		});
		$('#docsTab').click(function(){
			$('#parole').load('adminTab.php #docType')
			});
		$('#notesTab').click(function(){
				$('#parole').load('adminTab.php #noteType')
				});
		$('#catTab').click(function(){
					$('#parole').load('adminTab.php #Categories')
					});

	});
</script>

<?php
}else{
	echo _("You don't have permission to access this page");
}

include 'templates/footer.php';
?>
