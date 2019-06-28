<?php
/*
**************************************************************************************************************************
** CORAL Usage Statistics Module
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
**************************************************************************************************************************
** ajax_processing.php contains processing (adds/updates/deletes) on data sent using ajax from forms and other pages
**
** when ajax_processing.php is called through ajax, 'action' parm is required to dictate which form will be returned
**
**************************************************************************************************************************
*/


include "common.php";
include_once 'directory.php';

$action = $_REQUEST['action'];

switch ($action) {


	//log email addresses (on admin page)
	case 'getLogEmailAddressForm':

		if (isset($_GET['logEmailAddressID']) && ($_GET['logEmailAddressID'] != '')){
			$logEmailAddressID = $_GET['logEmailAddressID'];
			$addUpdate = _('Edit');
			$logEmailAddress = new LogEmailAddress(new NamedArguments(array('primaryKey' => $_GET['logEmailAddressID'])));
		}else{
			$logEmailAddressID = '';
			$addUpdate = _('Add');
			$logEmailAddress = new LogEmailAddress();
		}




		?>
		<div id='div_updateForm'>
		<input type='hidden' id='updateLogEmailAddressID' name='updateLogEmailAddressID' value='<?php echo $logEmailAddressID; ?>'>
		<table class="thickboxTable 230">
		<tr>
		<td colspan='3'><span class='headerText'><?php echo $addUpdate; ?> <?php echo _("Email Address");?></span><br /><span id='span_errors' class='redText'></span></td>
		</tr>
		<tr>
		<td>
		<input type='text' id='emailAddress' name='emailAddress' value='<?php if (isset($_GET['logEmailAddressID']) && ($_GET['logEmailAddressID'] != '')) echo $logEmailAddress->emailAddress; ?>' class='190'/>
		</td>
		<td>
		<a href='javascript:doSubmitLogEmailAddress();' id='addButton' class='submit-button'><?php echo ($addUpdate); ?></a>
		</td>
		<td colspan='2'><p><a href='#' onclick='window.parent.tb_remove(); return false' id='closeButton' class='cancel-button'><?php echo _("Close");?></a></td>
		</tr>
		</table>
		</div>

		<script type="text/javascript">
		   //attach enter key event to new input and call add data when hit
		   $('#emailAddress').keyup(function(e) {

				   if(e.keyCode == 13) {
					   doSubmitLogEmailAddress();
				   }
		   });

		</script>


		<?php

		break;






	//prompt for running sushi, posts to sushi.php
	case 'getSushiRunForm':

		if ((isset($_GET['sushiServiceID'])) && ($_GET['sushiServiceID'] != '')){
			$sushiServiceID = $_GET['sushiServiceID'];
 			$sushiService = new SushiService(new NamedArguments(array('primaryKey' => $sushiServiceID)));

 			$sushiService->setDefaultImportDates();

			?>
			<div id='div_sushiRunForm'>
			<form name="input" action="sushi.php" method="post">
			<input type='hidden' id='sushiSer00 padding2">
				<tr>
					<td colspan='2'><span class='headerText'><?php echo _("SUSHI Service for");?> <?php echo $sushiService->getServiceProvider; ?></span><br /> <?php echo _("Optional Parameters");?><span id='span_errors' class='redText'><br /></span><br /></td>
				</tr>
				<tr>
					<td class='verticalAlignT textAlignR 85'><label for='startDate'><b><?php echo _("Start Date:");?></b></label></td>
					<td><input type='text' id='startDate' name='startDate' value="<?php echo $sushiService->startDate; ?>" class='90'/> (yyyy-mm-dd)<span id='span_error_startDate' class='redText'></span></td>
				</tr>
				<tr>
					<td class='verticalAlignT textAlignR'><label for='endDate'><b><?php echo _("End Date:");?></b></label></td>
					<td><input type='text' id='endDate' name='endDate' value="<?php echo $sushiService->endDate; ?>" class='90'/> <?php echo _("(yyyy-mm-dd)");?><span id='span_error_endDate' class='redText'></span></td>
				</tr>
				<tr>
					<td class='verticalAlignT textAlignR'><input type='checkbox' id='overwritePlatform' name='overwritePlatform' value='1' checked /></td>
					<td>
					&nbsp;<?php echo _("Ensure platform name stays CORAL's Platform Name: ") . $sushiService->getServiceProvider;?>"
					</td>
				</tr>

				<tr class='verticalAlignM'>
					<td class='paddingT8 textAlignR'>&nbsp;</td>
					<td class='paddingT8 paddingR8'>
						<table class='noBorderTable whundred'>
							<tr>
								<td class='60'><input type='submit' value='<?php echo _("submit for processing");?>' name='submitSushiRun' id ='submitSushiRun' class='submit-button'></td>
								<td><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" class='cancel-button'></td>
							</tr>
						</table>
					</td>
				</tr>

			</table>
			</form>
			</div>

			<?php

		}else{
			echo _("No Sushi Service passed in!");
		}

		break;




	case 'getOutlierForm':


		if (isset($_GET['outlierID']) && ($_GET['outlierID'] != '')){
			$outlierID = $_GET['outlierID'];
			$outlier = new Outlier(new NamedArguments(array('primaryKey' => $_GET['outlierID'])));
		}


		?>
		<div id='div_updateForm'>
		<input type='hidden' id='updateOutlierID' name='updateOutlierID' value='<?php echo $outlierID; ?>'>
		<table class="thickboxTable 300 padding2">
		<tr><td colspan='2'><span class='headerText'><?php echo _("Edit Outlier");?> - <b><?php echo _("Level");?> <?php echo $outlier->outlierLevel; ?></b></span><br /><br /></td></tr>
		<tr><td class='verticalAlignT textAlignR'><label for='overageCount'><b><?php echo _("Count Over");?></b></label></td><td><input type='text' id='overageCount' name='overageCount' value="<?php echo $outlier->overageCount; ?>" class='140' /><span id='span_error_overageCount' class='redText'></span></td></tr>
		<tr><td class='verticalAlignT textAlignR'><label for='overagePercent'><b><?php echo _("% Over prior 12 months");?></b></label></td><td><input type='text' id='overagePercent' name='overagePercent' value="<?php echo $outlier->overagePercent; ?>" class='140' /><span id='span_error_overagePercent' class='redText'></span></td></tr>

		<tr class='verticalAlignM'>
		<td class='60'><input type='button' value='<?php echo _("Edit");?>' onclick='javascript:window.parent.updateOutlier();' class='submit-button'></td>
		<td><input type='button' value='<?php echo _("cancel");?>' onclick="window.parent.tb_remove(); return false" class='cancel-button'></td>
		</tr>

		</table>

		</div>

		<script type="text/javascript">
		   //attach enter key event to new input and call add data when hit
			$('#overageCount').keyup(function(e) {
				  if(e.keyCode == 13) {
					window.parent.updateOutlier();
				  }
			});


			//do submit if enter is hit
			$('#overagePercent').keyup(function(e) {
				  if(e.keyCode == 13) {
					window.parent.updateOutlier();
				  }
			});

		</script>

		<?php

		break;




	//reporting display name (on reporting page)
	case 'getReportDisplayForm':
		if (isset($_GET['updateID'])) $updateID = $_GET['updateID']; else $updateID = '';

		if ($_GET['type'] == 'platform'){
			$obj = new Platform(new NamedArguments(array('primaryKey' => $updateID)));
		}else{
			$obj = new PublisherPlatform(new NamedArguments(array('primaryKey' => $updateID)));
		}


		?>
		<div id='div_updateForm'>
		<input type='hidden' id='updateID' name='updateID' value='<?php echo $updateID; ?>'>
		<input type='hidden' id='type' name='type' value='<?php echo $_GET['type']; ?>'>
		<table class="thickboxTable 230">
		<tr>
		<td colspan='3'><span class='headerText'><?php echo _("Edit Report Display Name");?></span><br /><span id='span_errors' class='redText'></span></td>
		</tr>
		<tr>
		<td>
		<?php
		echo "<input type='text' id='reportDisplayName' name='reportDisplayName' value='" . $obj->reportDisplayName . "' class='190'/></td><td><a href='javascript:updateReportDisplayName();' class='submit-button'>" . _("Edit") . "</a>";
		?>


		</td>

		<td colspan='2'><a href='#' onclick='window.parent.tb_remove(); return false' class='cancel-button'><?php echo _("Close");?></a></td>
		</tr>
		</table>
		</div>


		<script type="text/javascript">
		   //attach enter key event to new input and call add data when hit
		   $('#reportDisplayName').keyup(function(e) {

				   if(e.keyCode == 13) {
					   updateReportDisplayName();
				   }
		   });

		</script>


		<?php

		break;


	case 'getPlatformNoteForm':
		if (isset($_GET['platformNoteID'])) $platformNoteID = $_GET['platformNoteID']; else $platformNoteID = '';
		if (isset($_GET['platformID'])) $platformID = $_GET['platformID'];


		if ($platformNoteID) $addUpdate = _('Edit'); else $addUpdate = _('Add');

		if ($platformNoteID){
			$platformNote = new PlatformNote(new NamedArguments(array('primaryKey' => $platformNoteID)));

			$platformID = $platformNote->platformID;

			if ($platformNote->counterCompliantInd == '1'){
				$counterCompliant = 'checked';
				$notCounterCompliant = '';
			}elseif ($platformNote->counterCompliantInd == '0'){
				$notCounterCompliant = 'checked';
				$counterCompliant = '';
			}else{
				$notCounterCompliant = '';
				$counterCompliant = '';
			}

			if (($platformNote->endYear == '0') || ($platformNote->endYear =='')) $endYear = ''; else $endYear = $platformNote->endYear;
			$startYear = $platformNote->startYear;
			$noteText = $platformNote->noteText;

		}else{
			$platformNote = new PlatformNote();
			$notCounterCompliant = '';
			$counterCompliant = '';
			$startYear = '';
			$endYear = '';
			$noteText = '';
		}



		?>
		<div id='div_updateForm'>
		<input type='hidden' id='editPlatformNoteID' name='editPlatformNoteID' value='<?php echo $platformNoteID; ?>'>
		<input type='hidden' id='platformID' name='platformID' value='<?php echo $platformID; ?>'>
		<table class="thickboxTable 400 padding2">
			<tr>
				<td colspan='2'><span class='headerText'><?php echo $addUpdate . ' ' . _("Interface Notes");?></span><span id='span_errors' class='redText'><br /></span><br /></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='startYear'><b><?php echo _("Start Year:");?></b></label></td>
				<td><input type='text' id='startYear' name='startYear' value="<?php echo $platformNote->startYear; ?>" class='90'/><span id='span_error_startYear' class='redText'></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR'><label for='endYear'><b><?php echo _("End Year:");?></b></label></td>
				<td><input type='text' id='endYear' name='endYear' value="<?php echo $endYear; ?>" class='90'/><span id='span_error_endYear' class='redText'></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR'><label for='counterCompliantInd'><b><?php echo _("Counter Compliant?");?></b></label></td>
				<td>
				<input type='radio' id='counterCompliantInd' name='counterCompliantInd' value='1' <?php echo $counterCompliant; ?> />&nbsp;<?php echo _("Yes");?>&nbsp;&nbsp;
				<input type='radio' id='counterCompliantInd' name='counterCompliantInd' value='0' <?php echo $notCounterCompliant; ?> />&nbsp;<?php echo _("No");?>

				</td>
			</tr>

			<tr>
				<td class='verticalAlignT textAlignR'><label for='noteText'><b><?php echo _("Interface Notes:");?></b></label></td>
				<td><textarea cols='36' rows='4' id='noteText' name='noteText' class='250'><?php echo $noteText; ?></textarea></td>
			</tr>

			<tr class='verticalAlignM'>
				<td class='paddingT8 textAlignR'>&nbsp;</td>
				<td class='paddingT8 paddingR8'>
					<table class='noBorderTable wHundred'>
						<tr>
							<td class='60'><input type='button' value='<?php echo _("submit");?>' name='submitPlatformNoteForm' id ='submitPlatformNoteForm' class='submit-button'></td>
							<td><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" id='interface-cancel' class='cancel-button'></td>
						</tr>
					</table>
				</td>
			</tr>

		</table>

		</div>

		<script type="text/javascript" src="js/forms/platformNoteSubmitForm.js?random=<?php echo rand(); ?>"></script>

		<?php

		break;








	case 'getPublisherNoteForm':
		if (isset($_GET['publisherPlatformNoteID'])) $publisherPlatformNoteID = $_GET['publisherPlatformNoteID']; else $publisherPlatformNoteID = '';
		if (isset($_GET['publisherPlatformID'])) $publisherPlatformID = $_GET['publisherPlatformID'];

		if ($publisherPlatformNoteID){
			$addUpdate = _('Edit');

			$publisherPlatformNote = new PublisherPlatformNote(new NamedArguments(array('primaryKey' => $publisherPlatformNoteID)));

			$publisherPlatformID = $publisherPlatformNote->publisherPlatformID;

			if (($publisherPlatformNote->endYear == '0') || ($publisherPlatformNote->endYear =='')) $endYear = ''; else $endYear = $publisherPlatformNote->endYear;

		}else{
			$addUpdate = _('Add');
			$publisherPlatformNote = new PublisherPlatformNote();
		}


		?>
		<div id='div_updateForm'>
		<input type='hidden' id='editPublisherPlatformNoteID' name='editPublisherPlatformNoteID' value='<?php echo $publisherPlatformNoteID; ?>'>
		<input type='hidden' id='publisherPlatformID' name='publisherPlatformID' value='<?php echo $publisherPlatformID; ?>'>
		<table class="thickboxTable 310 padding2">
			<tr>
				<td colspan='2'><span class='headerText'><?php echo $addUpdate . ' ' . _("Publisher Notes");?></span><span id='span_errors' class='redText'><br /></span><br /></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='startYear'><b><?php echo _("Start Year:");?></b></label></td>
				<td><input type='text' id='startYear' name='startYear' value="<?php echo $publisherPlatformNote->startYear; ?>" class='90'/><span id='span_error_startYear' class='redText'></span></td>
			</tr>
			<tr>
								<td class='verticalAlignT textAlignR'><label for='endYear'><b><?php echo _("End Year:");?></b></label></td>
				<td><input type='text' id='endYear' name='endYear' value="<?php echo $endYear; ?>" class='90'/><span id='span_error_endYear' class='redText'></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR'><label for='noteText'><b><?php echo _("Publisher Notes:");?></b></label></td>
				<td><textarea cols='36' rows='4' id='noteText' name='noteText' class='200'><?php echo $publisherPlatformNote->noteText; ?></textarea></td>
			</tr>

			<tr class='verticalAlignM'>
				<td class='paddingT8 textAlignR'>&nbsp;</td>
				<td class='paddingT8 paddingR8'>
					<table class='noBorderTable wHundred'>
						<tr>
							<td class='60'><input type='button' value='<?php echo _("submit");?>' name='submitPublisherNoteForm' id ='submitPublisherNoteForm' class='submit-button'></td>
							<td><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" class='cancel-button'></td>
						</tr>
					</table>
				</td>
			</tr>

		</table>

		</div>

		<script type="text/javascript" src="js/forms/publisherNoteSubmitForm.js?random=<?php echo rand(); ?>"></script>

		<?php

		break;





	case 'getLoginForm':
		if (isset($_GET['externalLoginID'])) $externalLoginID = $_GET['externalLoginID']; else $externalLoginID = '';
		if (isset($_GET['platformID'])) $platformID = $_GET['platformID']; else $platformID = '';
		if (isset($_GET['publisherPlatformID'])) $publisherPlatformID = $_GET['publisherPlatformID']; else $publisherPlatformID = '';

		if ($externalLoginID){
			$addUpdate = _('Edit');
			$externalLogin = new ExternalLogin(new NamedArguments(array('primaryKey' => $externalLoginID)));

			$publisherPlatformID = $externalLogin->publisherPlatformID;
			$platformID = $externalLogin->platformID;
		}else{
			$addUpdate = _('Add');
			$externalLogin = new ExternalLogin();
		}

		?>
		<div id='div_updateForm'>
		<input type='hidden' id='editExternalLoginID' name='editExternalLoginID' value='<?php echo $externalLoginID; ?>'>
		<input type='hidden' id='platformID' name='platformID' value='<?php echo $platformID; ?>'>
		<input type='hidden' id='publisherPlatformID' name='publisherPlatformID' value='<?php echo $publisherPlatformID; ?>'>
		<table class='thickboxTable 320 padding2'>
			<tr>
				<td colspan='2'><span class='headerText'><?php echo $addUpdate . ' ' . _("Login");?></span><span id='span_errors' class='redText'><br /></span><br /></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='username'><b><?php echo _("Username:");?></b></label></td>
				<td><input type='text' id='username' name='username' value="<?php if ($externalLoginID) echo $externalLogin->username; ?>" class='200'/><span id='span_error_loginID' class='redText'></span></td>
			</tr>
			<tr>
								<td class='verticalAlignT textAlignR'><label for='password'><b><?php echo _("Password:");?></b></label></td>
				<td><input type='text' id='password' name='password' value="<?php if ($externalLoginID) echo $externalLogin->password; ?>" class='200'/><span id='span_error_password' class='redText'></span></td>			</tr>
			<tr>
								<td class='verticalAlignT textAlignR'><label for='loginURL'><b><?php echo _("URL:");?></b></label></td>
				<td><input type='text' id='loginURL' name='loginURL' value="<?php if ($externalLoginID) echo $externalLogin->loginURL; ?>" class='200'/><span id='span_error_url' class='redText'></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR'><label for='noteText'><b><?php echo _("Login Notes:");?></b></label></td>
				<td><textarea cols='36' rows='4' id='noteText' name='noteText' class='200'><?php if ($externalLoginID) echo $externalLogin->noteText; ?></textarea></td>
			</tr>

			<tr class='verticalAlignM'>
				<td class='paddingT8 textAlignR'>&nbsp;</td>
				<td class='paddingT8 paddingR8'>
					<table class='noBorderTable wHundred'>
						<tr>
							<td class='60'><input type='button' value='<?php echo _("submit");?>' name='submitExternalLoginForm' id ='submitExternalLoginForm' class='submit-button'></td>
							<td><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" class='cancel-button'></td>
						</tr>
					</table>
				</td>
			</tr>

		</table>

		</div>

		<script type="text/javascript" src="js/forms/externalLoginSubmitForm.js?random=<?php echo rand(); ?>"></script>

		<?php

		break;


	//sushi service information
	case 'getSushiForm':
		$sushiServiceID = $_GET['sushiServiceID'];
		$platformID = $_GET['platformID'];


		if ($sushiServiceID){
			$addUpdate = _('Edit');
			$sushiService = new SushiService(new NamedArguments(array('primaryKey' => $sushiServiceID)));

		}else{
			$addUpdate = _('Add');
			$sushiService = new SushiService();
		}

		?>
		<div id='div_updateForm'>
		<input type='hidden' id='editSushiServiceID' name='editSushiServiceID' value='<?php echo $sushiServiceID; ?>'>
		<input type='hidden' id='platformID' name='platformID' value='<?php echo $platformID; ?>'>
		<table class="thickboxTable 500 padding2">
			<tr>
				<td colspan='2'><span class='headerText'><?php echo $addUpdate . ' ' . _("SUSHI Connection");?></span><span id='span_errors' class='redText'><br /></span><br /></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135' class='verticalAlignT textAlignR 135'><label for='serviceURL'><b><?php echo _("Service/Endpoint URL:");?></b></label></td>
				<td><input type='text' id='serviceURL' name='serviceURL' value="<?php if ($sushiServiceID) echo $sushiService->serviceURL; ?>" class='330'/>
					<br /><span class="smallDarkRedText"> - <?php echo _("if using COUNTER's WSDL");?></span>
					<span id='span_error_serviceURL' class='redText'></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='wsdlURL'><b> - <?php echo _("or - WSDL URL:");?></b></label></td>
				<td><input type='text' id='wsdlURL' name='wsdlURL' value="<?php if ($sushiServiceID) echo $sushiService->wsdlURL; ?>" class='330'/>
					<br /><span class="smallDarkRedText"> - <?php echo _("if not using COUNTER's WSDL");?></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='reportLayouts'><b><?php echo _("Report Type(s):");?></b></label></td>
				<td><input type='text' id='reportLayouts' name='reportLayouts' value="<?php if ($sushiServiceID) echo $sushiService->reportLayouts; ?>" class='150' />
					<br /><span class="smallDarkRedText"><?php echo _("separate report types with semi-colon, e.g. JR1;BR1");?></span>
					<span id='span_error_reportLayouts' class='redText'></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='releaseNumber'><b><?php echo _("COUNTER Release:");?></b></label></td>
				<td>
					<select id='releaseNumber' name='releaseNumber' class='50'>
					<option value='3' <?php if (!$sushiServiceID){ echo "selected"; } else if ($sushiService->releaseNumber == "3"){ echo "selected"; } ?>>3</option>
					<option value='4' <?php if ($sushiService->releaseNumber == "4"){ echo "selected"; } ?>>4</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='requestorID'><b><?php echo _("Requestor ID:");?></b></label></td>
				<td><input type='text' id='requestorID' name='requestorID' value="<?php if ($sushiServiceID) echo $sushiService->requestorID; ?>" class='150' /></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='customerID'><b><?php echo _("Customer ID:");?></b></label></td>
				<td><input type='text' id='customerID' name='customerID' value="<?php if ($sushiServiceID) echo $sushiService->customerID; ?>" class='150' /></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR 135'><label for='security'><b><?php echo _("Security Type:");?></b></label></td>
				<td><input type='text' id='security' name='security' value="<?php if ($sushiServiceID) echo $sushiService->security; ?>" class='150' />
					<span class="smallDarkRedText"><?php echo _("(optional)");?><br /><?php echo _("can be: HTTP Basic, WSSE Authentication");?></span>
					<span id='span_error_security' class='redText'></span></td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR'><label for='login'><b><?php echo _("Login:");?></b></label></td>
				<td><input type='text' id='login' name='login' value="<?php if ($sushiServiceID) echo $sushiService->login; ?>" class='150' />
					<span class="smallDarkRedText"><?php echo _("(optional)") . "<br /> - " . _("only needed for HTTP or WSSE Authentication");?></span>
					<span id='span_error_login' class='redText'></span>
				</td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR'><label for='password'><b><?php echo _("Password:");?></b></label></td>
				<td><input type='text' id='password' name='password' value="<?php if ($sushiServiceID) echo $sushiService->password; ?>" class='150' />
					<span class="smallDarkRedText"><?php echo _("(optional)") . "<br /> - " . _("only needed for HTTP or WSSE Authentication");?></span>
					<span id='span_error_password' class='redText'></span>
				</td>
			</tr>

			<tr>
				<td class='verticalAlignT textAlignR'><label for='serviceDayOfMonth'><b><?php echo _("Service Day:");?></b></label></td>
				<td><input type='text' id='serviceDayOfMonth' name='serviceDayOfMonth' value="<?php if ($sushiServiceID) echo $sushiService->serviceDayOfMonth; ?>" class='50' />
					<span class="smallDarkRedText"><?php echo _("(optional)") . "<br /> - " . _("number indicating the day of month the service should run") . "<br />" . _("(e.g. 27 will run 27th of every month)");?></span><span id='span_error_serviceDay' class='redText'></span>
				</td>
			</tr>
			<tr>
				<td class='verticalAlignT textAlignR'><label for='noteText'><b><?php echo _("Sushi Notes:");?></b></label></td>
				<td><textarea cols='46' rows='4' id='noteText' name='noteText' class='330'><?php if ($sushiServiceID) echo $sushiService->noteText; ?></textarea></td>
			</tr>

			<tr class='verticalAlignM'>
				<td class='paddingT8 textAlignR'>&nbsp;</td>
				<td class='paddingT8 paddingR8'>
					<table class='noBorderTable wHundred'>
						<tr>
							<td class='60'><input type='button' value='submit' name='submitSushiForm' id ='submitSushiForm' class='submit-button'></td>
							<td><input type='button' value='cancel' onclick="tb_remove()" class='cancel-button'></td>
						</tr>
					</table>
				</td>
			</tr>

		</table>

		</div>

		<script type="text/javascript" src="js/forms/sushiSubmitForm.js?random=<?php echo rand(); ?>"></script>

		<?php

		break;


	//form to edit associated organizations
    case 'getOrganizationForm':

		$publisherPlatformID = $_GET['publisherPlatformID'];
		$platformID = $_GET['platformID'];

		if (isset($_GET['publisherPlatformID']) && ($_GET['publisherPlatformID'] != '')){
			$obj = new PublisherPlatform(new NamedArguments(array('primaryKey' => $_GET['publisherPlatformID'])));
		}else{
			$obj = new Platform(new NamedArguments(array('primaryKey' => $_GET['platformID'])));
		}

		if ($obj->organizationID) $organizationName = $obj->getOrganizationName; else $organizationName = '';

		?>
		<div id='div_organizationsForm'>
		<form id='organizationsForm'>
		<input type='hidden' id='publisherPlatformID' name='publisherPlatformID' value='<?php echo $publisherPlatformID; ?>'>
		<input type='hidden' id='platformID' name='platformID' value='<?php echo $platformID; ?>'>
		<table class="thickboxTable 260">
		<tr>
		<td colspan='2'><span class='headerText'><?php echo _("Link Associated Organization");?></span><br /><br /></td>
		</tr>

		<tr>
		<td colspan='2'><label for="organizationID" class="formText"><?php echo _("Organization:");?></label>  <span id='span_error_organizationName' class='errorText'></span><br />
		<input type='textbox' id='organizationName' name='organizationName' value="<?php echo $organizationName; ?>" class='232'/>
		<input type='hidden' id='organizationID' name='organizationID' value='<?php echo $obj->organizationID; ?>'>
		<span id='span_error_organizationNameResult' class='errorText'></span>
		<br />
		</td>
		</tr>



		<tr class='verticalAlignM'>
		<td class='60'><input type='button' value='<?php echo _("submit");?>' name='submitOrganization' id ='submitOrganization' class='submit-button'></td>
		<td><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" class='cancel-button'></td>
		</tr>
		</table>



		<script type="text/javascript" src="js/forms/organizationForm.js?random=<?php echo rand(); ?>"></script>
		</form>
		</div>


		<?php

        break;





	case 'getMonthlyOutlierForm':
		if (isset($_GET['platformID'])) $platformID = $_GET['platformID']; else $platformID = '';
 		if (isset($_GET['publisherPlatformID'])) $publisherPlatformID = $_GET['publisherPlatformID'];

		$archiveInd = $_GET['archiveInd'];
		$year = $_GET['year'];
		$month = $_GET['month'];


		$statsArray = array();
		if ($publisherPlatformID) {
			$publisherPlatform = new PublisherPlatform(new NamedArguments(array('primaryKey' => $publisherPlatformID)));
			$publisher = new Publisher(new NamedArguments(array('primaryKey' => $publisherPlatform->publisherID)));
			$platform = new Platform(new NamedArguments(array('primaryKey' => $publisherPlatform->platformID)));
			$nameDisplay = $publisher->name . " / " . $platform->name;

			$statsArray = $publisherPlatform->getMonthlyOutliers($archiveInd, $year, $month);
		}else{
			$platform = new Platform(new NamedArguments(array('primaryKey' => $platformID)));
			$nameDisplay = $platform->name;

			$statsArray = $platform->getMonthlyOutliers($archiveInd, $year, $month);
		}

		$totalRows = count($statsArray);

		?>

		<div id='div_outlierForm'>
		<table class="thickboxTable thickboxTitleImgUsage">
		<tr>
		<td><span class='headerText'><?php echo $nameDisplay; ?></span><br /></td>
		</tr>
		<tr>

		<table class='dataTable 408 marginL2'>

		<?php

			if ($totalRows == 0){
				echo "<tr><td>" . _("None currently") . "</td></tr>";
			}else{
				foreach($statsArray as $monthlyStat){
					echo "<tr>";
					echo "<td class='170'>" . $monthlyStat['Title']. "<span id='span_error_overrideUsageCount_" . $monthlyStat['monthlyUsageSummaryID'] . "' class='redText'></span></td>";
					echo "<td style='width:50px;text-align:center;background-color:" . $monthlyStat['color'] . "'>" . $monthlyStat['usageCount'] . "</td>";
					echo "<td class='55'><input type='text' name = 'overrideUsageCount_" . $monthlyStat['monthlyUsageSummaryID'] . "' id = 'overrideUsageCount_" . $monthlyStat['monthlyUsageSummaryID'] . "' value='" . $monthlyStat['overrideUsageCount'] . "' style='width:50px'></td>";
					echo "<td class='80'><a href=\"javascript:updateOverride('" . $monthlyStat['monthlyUsageSummaryID'] . "');\" style='font-size:100%;'>" . _("edit override") . "</a><br /><a href=\"javascript:ignoreOutlier('" . $monthlyStat['monthlyUsageSummaryID'] . "');\" git statu'font-size:100%;'>" . _("ignore outlier") . "</a></td>";
					echo "</tr>";
				}
			}

		?>

		</table>
		</tr>
		<tr><td class='text-alignC wHundred'><br /><br /><a href='#' onclick='window.parent.updateFullStatsDetails(); window.parent.tb_remove(); return false'><?php echo _("Close");?></a></td></tr>
		</table>
		<input type="hidden" id='platformID' name='platformID' value='<?php echo $platformID; ?>'>
		<input type="hidden" id='publisherPlatformID' name='publisherPlatformID' value='<?php echo $publisherPlatformID; ?>'>
		<input type="hidden" id='archiveInd' name='archiveInd' value='<?php echo $archiveInd; ?>'>
		<input type="hidden" id='year' name='year' value='<?php echo $year; ?>'>
		<input type="hidden" id='month' name='month' value='<?php echo $month; ?>'>

		<script type="text/javascript" src="js/forms/outlierSubmitForm.js?random=<?php echo rand(); ?>"></script>
		</div>


		<?php

		break;





	case 'getYearlyOverrideForm':
		if (isset($_GET['platformID'])) $platformID = $_GET['platformID']; else $platformID = '';
 		if (isset($_GET['publisherPlatformID'])) $publisherPlatformID = $_GET['publisherPlatformID'];

		$archiveInd = $_GET['archiveInd'];
		$year = $_GET['year'];


		$statsArray = array();
		if ($publisherPlatformID) {
			$publisherPlatform = new PublisherPlatform(new NamedArguments(array('primaryKey' => $publisherPlatformID)));
			$publisher = new Publisher(new NamedArguments(array('primaryKey' => $publisherPlatform->publisherID)));
			$platform = new Platform(new NamedArguments(array('primaryKey' => $publisherPlatform->platformID)));
			$nameDisplay = $publisher->name . " / " . $platform->name;

			$statsArray = $publisherPlatform->getYearlyOverrides($archiveInd, $year);
		}else{
			$platform = new Platform(new NamedArguments(array('primaryKey' => $platformID)));
			$nameDisplay = $platform->name;

			$statsArray = $platform->getYearlyOverrides($archiveInd, $year);
		}

		$totalRows = count($statsArray);


		?>

		<div id='div_overrideForm'>
		<table class="thickboxTable thickboxTitleImgUsage">
		<tr>
			<td><span class='headerText'><?php echo $nameDisplay; ?></span><br /><?php echo _("(showing only titles for which there were outliers during the year)");?></td>
		</tr>
		<tr>

		<table class='dataTable 408 marginL2'>

		<?php

			if ($totalRows == 0){
				echo "<tr><td>" . _("None currently") . "</td></tr>";
			}else{
				foreach($statsArray as $yearlyStat){
				?>
					<tr>
					<td width="149" class='alt'><?php echo $yearlyStat['Title']; ?></td>
					<td width="40" class='alt'><?php echo _("Total");?></td>
					<td width="40" class='alt'><?php echo $yearlyStat['totalCount']; ?></td>
					<td width="40" class='alt'><input name="overrideTotalCount_<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>" id="overrideTotalCount_<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>" type="text"value="<?php echo $yearlyStat['overrideTotalCount']; ?>" size="6" maxlength="6"/></td>
					<td width="40" class='alt'><a href="javascript:updateYTDOverride('<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>', 'overrideTotalCount')"><?php echo _("edit");?></a></td>
					</tr>
					<tr>
					<td width="149"><span id="span_error_<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>_response" class='redText'></span></td>
					<td width="40"><?php echo _("PDF");?></td>
					<td width="40"><?php echo $yearlyStat['ytdPDFCount']; ?></td>
					<td width="40"><input name="overridePDFCount_<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>" id="overridePDFCount_<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>" type="text"value="<?php echo $yearlyStat['overridePDFCount']; ?>" size="6" maxlength="6"/></td>
					<td width="40"><a href="javascript:updateYTDOverride('<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>', 'overridePDFCount')"><?php echo _("edit");?></a></td>
					</tr>
					<tr>
					<td width="149">&nbsp;</td>
					<td width="40">HTML</td>
					<td width="40"><?php echo $yearlyStat['ytdHTMLCount']; ?></td>
					<td width="40"><input name="overrideHTMLCount_<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>" id="overrideHTMLCount_<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>" type="text"value="<?php echo $yearlyStat['overrideHTMLCount']; ?>" size="6" maxlength="6"/></td>
					<td width="40"><a href="javascript:updateYTDOverride('<?php echo $yearlyStat['yearlyUsageSummaryID']; ?>', 'overrideHTMLCount')"><?php echo _("edit");?></a></td>
					</tr>
				<?php

				}
			}

		?>

		</table>
		</tr>
		<tr><td class='text-alignC wHundred'><br /><br /><a href='#' onclick='window.parent.tb_remove(); return false'><?php echo _("Close");?></a></td></tr>
		</table>
		<input type="hidden" id='platformID' name='platformID' value='<?php echo $platformID; ?>'>
		<input type="hidden" id='publisherPlatformID' name='publisherPlatformID' value='<?php echo $publisherPlatformID; ?>'>
		<input type="hidden" id='archiveInd' name='archiveInd' value='<?php echo $archiveInd; ?>'>
		<input type="hidden" id='year' name='year' value='<?php echo $year; ?>'>

		<script type="text/javascript" src="js/forms/overrideSubmitForm.js?random=<?php echo rand(); ?>"></script>
		</div>


		<?php

		break;




	//Add Platforms for sushi
	case 'getAddPlatformForm':


		?>
		<div id='div_addPlatformForm'>
		<table class="thickboxTable 300 padding2">
		<tr><td colspan='2'><span class='headerText'><?php echo _("Add New Platform for SUSHI Connection");?></span><br /><br /></td></tr>
		<tr><td class='verticalAlignT textAlignR'><label for='platformName'><b><?php echo _("Platform Name");?></b></label></td><td><input type='text' id='platformName' name='platformName' value="" class='200'/><span id='span_error_Platform' class='redText'></span></td></tr>


		<tr class='verticalAlignM'>
			<td class='paddingT8'>&nbsp;</td>
			<td class='paddingT8 paddingR8'>
				<table class='noBorderTable wHundred'>
					<tr>
						<td class='60'><input type='button' value='<?php echo _("submit");?>' name='submitPlatformForm' id ='submitPlatformForm' class='submit-button'></td>
						<td><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" id='cancel-button' class='cancel-button'></td>
					</tr>
				</table>
			</td>
		</tr>

		</table>

		</div>

		<script type="text/javascript" src="js/forms/platformSubmitForm.js?random=<?php echo rand(); ?>"></script>


		<?php

		break;






	//Add Identifiers
	case 'getAddIdentifierForm':
		if (isset($_GET['platformID'])) $platformID = $_GET['platformID']; else $platformID = '';
		if (isset($_GET['publisherPlatformID'])) $publisherPlatformID = $_GET['publisherPlatformID'];
		if (isset($_GET['titleID'])) $titleID = $_GET['titleID'];


		?>
		<div id='div_addIdentifierForm'>
		<table class="thickboxTable 200 padding2">
		<tr><td colspan='2'><span class='headerText'><?php echo _("Add Identifier");?></span><br /><br /></td></tr>
		<tr><td class='verticalAlignT textAlignR'><label for='identifierType'><b><?php echo _("Identifier Type");?></b></label></td>
			<td>
			<select id='identifierType' name='identifierType' class='90'>
			<option value='ISSN'><?php echo _("ISSN");?></option>
			<option value='eISSN'><?php echo _("eISSN");?></option>
			<option value='ISBN'><?php echo _("ISBN");?></option>
			<option value='eISBN'><?php echo _("eISBN");?></option>
			<option value='doi'><?php echo _("DOI");?></option>
			<option value='pi'><?php echo _("Proprietary ID");?></option>
			</select>
			</td>
		</tr>
		<tr><td class='verticalAlignT textAlignR'><label for='identifier'><b><?php echo _("Identifier");?></b></label></td><td><input type='text' id='identifier' name='identifier' value="" class='90' /><span id='span_error_Identifier' class='redText'></span></td></tr>


		<tr class='verticalAlignM'>
			<td class='paddingT8 textAlignR'>&nbsp;</td>
			<td class='paddingT8 paddingR8'>
				<table class='noBorderTable whundred'>
					<tr>
						<td><input type='button' value='<?php echo _("submit");?>' name='submitIdentifierForm' id ='submitIdentifierForm' class='submit-button'></td>
						<td><input type='button' value='<?php echo _("cancel");?>' onclick="tb_remove()" class='cancel-button'></td>
					</tr>
				</table>
			</td>
		</tr>

		</table>

		</div>

		<input type="hidden" id='titleID' name='titleID' value='<?php echo $titleID; ?>'>
		<input type="hidden" id='platformID' name='platformID' value='<?php echo $platformID; ?>'>
		<input type="hidden" id='publisherPlatformID' name='publisherPlatformID' value='<?php echo $publisherPlatformID; ?>'>

		<script type="text/javascript" src="js/forms/identifierSubmitForm.js?random=<?php echo rand(); ?>"></script>


		<?php

		break;




	//Related Titles (this form is display only)
	case 'getRelatedTitlesForm':
 		if (isset($_GET['titleID'])) $titleID = $_GET['titleID'];

		$title = new Title(new NamedArguments(array('primaryKey' => $titleID)));

		?>
		<div id='div_relatedTitles'>
		<table class="thickboxTable 250 padding2">
		<tr><td><span class='headerText'><?php echo _("Associated Titles and Identifiers");?></span><br /></td></tr>
		<tr>
		<td>

		<table border="0" class='246'>
		<?php



			$relatedTitle = new Title();
			foreach($title->getRelatedTitles as $relatedTitle) {

				echo "<tr>";
				echo "<td colspan = '2' class='250'><b>" . $relatedTitle->title . "</b></td>";
				echo "</tr>";

				foreach($relatedTitle->getIdentifiers as $relatedTitleIdentifier) {
					$displayIdentifier = substr($relatedTitleIdentifier->identifier,0,4) . "-" . substr($relatedTitleIdentifier->identifier,4,4);

					echo "<tr>";
					echo "<td class='40'>" . $relatedTitleIdentifier->identifierType . "</td>";
					echo "<td class='210'>" . $displayIdentifier . "</td>";
					echo "</tr>";

				}


			}
		?>
		</table>

		</td>
		</tr>

		<tr>
		<td class='text-alignC wHundred'><br /><br /><a href='#' onclick='window.parent.tb_remove(); return false' class='cancel-button'><?php echo _("Close");?></a>
		</td>
		</tr>

		</table>

		</div>


		<?php

		break;








	//user form on the admin tab needs its own form since there are other attributes
	case 'getAdminUserUpdateForm':
		if (isset($_GET['loginID'])) $loginID = $_GET['loginID']; else $loginID = '';

		if ($loginID != ''){
			$update=_('Edit');
			$updateUser = new User(new NamedArguments(array('primaryKey' => $loginID)));
		}else{
			$update=_('Add');
		}


		?>
		<div id='div_updateForm'>
		<table class="thickboxTable 245 padding2">
		<tr><td colspan='3'><span class='headerText'><?php echo $update . ' ' . _(" User");?></span><br /><br /></td></tr>
		<tr><td colspan='2' class='135'><label for='loginID'><b><?php echo _("Login ID");?></b></label></td><td><input type='text' id='loginID' name='loginID' value='<?php echo $loginID; ?>' class='140' /></td></tr>
		<tr><td colspan='2'><label for='firstName'><b><?php echo _("First Name");?></b></label></td><td><input type='text' id='firstName' name='firstName' value="<?php if (isset($updateUser)) echo $updateUser->firstName; ?>" class='140' /></td></tr>
		<tr><td colspan='2'><label for='lastName'><b><?php echo _("Last Name");?></b></label></td><td><input type='text' id='lastName' name='lastName' value="<?php if (isset($updateUser)) echo $updateUser->lastName; ?>" class='140' /></td></tr>
		<tr><td><label for='privilegeID'><b><?php echo _("Privilege");?></b></label></td>
		<td>
				<fieldset id="foottip">
				<a href="#footnote_priv"><img src='images/help.gif'></a>
				<div id="footnote_priv" class='noDislpaying' ><?php echo _("Add/Edit users have access to everything") . "<br />" . _("except the Admin tab and admin users") . "<br />" . _("have access to everything");?></div>
				</fieldset>

		</td>
		<td>
		<select name='privilegeID' id='privilegeID' class='145'>
		<?php



		$display = array();
		$privilege = new Privilege();

		foreach($privilege->allAsArray() as $display) {
			if ($updateUser->privilegeID == $display['privilegeID']){
				echo "<option value='" . $display['privilegeID'] . "' selected>" . $display['shortName'] . "</option>";
			}else{
				echo "<option value='" . $display['privilegeID'] . "'>" . $display['shortName'] . "</option>";
			}
		}

		?>
		</select>
		</td>
		</tr>
		<tr class='verticalAlignM'>
		<td class='60'><input type='button' value='<?php echo $update; ?>' onclick='javascript:window.parent.submitUserData("<?php echo $loginID; ?>");' class='submit-button'></td>
		<td><input type='button' value='<?php echo _("Close");?>' onclick="window.parent.tb_remove(); return false" id='update-user-cancel' class='cancel-button'></td>
		</tr>

		</table>

		</div>


		<script type="text/javascript" src="js/forms/adminUserForm.js?random=<?php echo rand(); ?>"></script>
		<?php

		break;






	default:
       echo _("Function ") . $_REQUEST['function'] . _(" not set up!");
       break;


}



?>
