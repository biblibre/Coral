<?php
	$resourceID = $_GET['resourceID'];
	$resource = new Resource(new NamedArguments(array('primaryKey' => $resourceID)));

		$externalLoginArray = $resource->getExternalLoginArray();

		$resELFlag = 0;
		$orgELFlag = 0;

		if (count($externalLoginArray) > 0){
			foreach ($externalLoginArray as $externalLogin){

				if ($resELFlag == 0 && array_key_exists('organizationName', $externalLogin) && $externalLogin['organizationName'] == ''){
					echo "<div class='formTitle pad4 boldText marginB8'>"._("Resource Specific:")."</div>";
					$resELFlag = 1;
				}else if ($orgELFlag == 0 && array_key_exists('organizationName', $externalLogin) && $externalLogin['organizationName'] != ''){
					if ($resELFlag == 0){
						echo "<i>"._("No Resource Specific Accounts")."</i><br /><br />";
					}

					if ($user->canEdit()){ ?>
						<a href='ajax_forms.php?action=getAccountForm&height=314&width=403&modal=true&resourceID=<?php echo $resourceID; ?>' class='thickbox' id='newAccount'><?php echo _("add new account");?></a>
						<br /><br /><br />
					<?php
					}

					echo "<div class='formTitle pad4 marginB8 boldText'>"._("Inherited:")."</div>";
					$orgELFlag = 1;
				}else{
					echo "<br />";
				}

			?>
				<table class='linedFormTable'>
				<tr>
				<th colspan='2' class='lightGrey'>
				<span class='floatL verticalAlignB'>
					<?php echo $externalLogin['externalLoginType']; ?>
				</span>

				<span class='floatR'>
				<?php
					if ($user->canEdit() &&
                       (!array_key_exists('organizationName', $externalLogin) || (array_key_exists('organizationName', $externalLogin) && $externalLogin['organizationName'] == ''))) { ?>

						<a href='ajax_forms.php?action=getAccountForm&height=314&width=403&modal=true&resourceID=<?php echo $resourceID; ?>&externalLoginID=<?php echo $externalLogin['externalLoginID']; ?>' class='thickbox'><img src='images/edit.gif' alt='<?php echo _("edit");?>' title='<?php echo _("edit account");?>'></a>  <a href='javascript:void(0);' class='removeAccount' id='<?php echo $externalLogin['externalLoginID']; ?>'><img src='images/cross.gif' alt='<?php echo _("remove account");?>' title='<?php echo _("remove account");?>'></a>
						<?php
					}else{
						echo "&nbsp;";
					}
				?>
				</span>
				</th>
				</tr>

				<?php if (isset($externalLogin['organizationName'])) { ?>
				<tr>
				<td class='verticalAlignT 130'>Organization:</td>
				<td><?php echo $externalLogin['organizationName'] . "&nbsp;&nbsp;<a href='" . $util->getCORALURL() . "organizations/orgDetail.php?showTab=accounts&organizationID=" . $externalLogin['organizationID'] . "' target='_blank'><img src='images/arrow-up-right.gif' alt='"._("Visit Account in Organizations Module")."' title='"._("Visit Account in Organizations Module")."' class='verticalAlignT'></a>"; ?></td>
				</tr>
				<?php
				}

				if ($externalLogin['loginURL']) { ?>
				<tr>
				<td class='verticalAlignT 130'>Login URL:</td>
				<td><?php echo $externalLogin['loginURL']; ?>&nbsp;&nbsp;<a href='<?php echo $externalLogin['loginURL']; ?>' target='_blank'><img src='images/arrow-up-right.gif' alt='<?php echo _("Visit Login URL");?>' title='<?php echo _("Visit Login URL");?>'  class='verticalAlignT'></a></td>
				</tr>
				<?php
				}

				if ($externalLogin['username']) { ?>
				<tr>
				<td class='verticalAlignT 130'><?php echo _("User Name:");?></td>
				<td><?php echo $externalLogin['username']; ?></td>
				</tr>
				<?php
				}

				if ($externalLogin['password']) { ?>
				<tr>
				<td class='verticalAlignT 130'><?php echo _("Password:");?></td>
				<td><?php echo $externalLogin['password']; ?></td>
				</tr>
				<?php
				}

				if ($externalLogin['updateDate']) { ?>
				<tr>
				<td class='verticalAlignT 130'><?php echo _("Last Updated:");?></td>
				<td><i><?php echo format_date($externalLogin['updateDate']); ?></i></td>
				</tr>
				<?php
				}

				if ($externalLogin['emailAddress']) { ?>
				<tr>
				<td class='verticalAlignT 130'><?php echo _("Registered Email:");?></td>
				<td><?php echo $externalLogin['emailAddress']; ?></td>
				</tr>
				<?php
				}

				if ($externalLogin['noteText']) { ?>
				<tr>
				<td class='verticalAlignT 130'><?php echo _("Notes:");?></td>
				<td><?php echo nl2br($externalLogin['noteText']); ?></td>
				</tr>
				<?php
				}
				?>
				</table>
			<?php
			}
		} else {
			echo "<i>"._("No accounts available")."</i><br /><br />";

		}

		if ($user->canEdit() && ($orgELFlag == 0)){ ?>
			<a href='ajax_forms.php?action=getAccountForm&height=314&width=403&modal=true&resourceID=<?php echo $resourceID; ?>' class='thickbox' id='newAccount'><?php echo _("add new account");?></a>
			<br /><br /><br />
		<?php
		}

?>
