<?php
if (!isset($_GET['resourceID'])){
    echo "<div><p>You must supply a valid resource ID.</p></div>";
}else{
    $resourceID = $_GET['resourceID'];
    $resource = new Resource(new NamedArguments(array('primaryKey' => $resourceID)));

    $userGroupObj = new UserGroup();
    $userGroupArray = $userGroupObj->allAsArray();

    $resourceSteps = $resource->getResourceSteps();
    $parentSteps = $resource->getResourceSteps();

    // Get reminder, from the resourceSteps, or from the workflow
    foreach ($resourceSteps as $resourceStep) {
        if ($resourceStep->stepID) {
            $stepID = $resourceStep->stepID;
            break;
        }
    }
    $step = new Step(new NamedArguments(array('primaryKey' => $stepID)));
    $workflow = new Workflow(new NamedArguments(array('primaryKey' => $step->workflowID)));
    $workflowMailReminderDelay = $resourceSteps[0]->mailReminderDelay ? $resourceSteps[0]->mailReminderDelay : $workflow->workflowMailReminderDelay;
    $workflowMailReminder = $resourceSteps[0]->mailReminder != NULL ? $resourceSteps[0]->mailReminder : $workflow->workflowMailReminder;

    //make form
    ?>
    <div id='div_resourceStepForm'>
        <form id='resourceStepForm'>
            <input type='hidden' name='editRID' id='editRID' value='<?php echo $resourceID; ?>'>

            <div class='formTitle' style='width:705px; margin-bottom:5px;position:relative;'><span class='headerText'>Edit Workflow</span></div>

            <span class='smallDarkRedText' id='span_errors'></span>

            <table class='noBorder' style='width:100%;'>
                <tr style='vertical-align:top;'>
                    <td style='vertical-align:top;position:relative;'>
                        <span class='surroundBoxTitle'>&nbsp;&nbsp;<label for='rule'><b>Workflow Steps</b></label>&nbsp;&nbsp;</span>
                        <table class='surroundBox' style='width:700px;'>
                            <tr>
                            <td>
                            <table>
                            <tr>
                                <td>
                                    <label for="workflowMailReminder"><?php echo _("Enable workflow mail reminder"); ?></label>
                                    <input type="checkbox" id="workflowMailReminder"<?php if ($workflowMailReminder) echo ' checked="checked"'; ?>>
                                </td>
                                <td>
                                <label for="workflowMailReminderDelay"><?php echo _("Delay (day)"); ?></label>
                                    <input type="text" id="workflowMailReminderDelay" value="<?php echo $workflowMailReminderDelay; ?>">
                                </td>
                            </td>
                            </tr>
                            </table>
                            </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class='noBorder newStepTable' style='width:660px; margin:15px 20px 10px 20px;'>
                                        <tr>
                                            <td><?php echo _("Name"); ?></td>
                                            <td><?php echo _("Approval/Notification group"); ?></td>
                                            <td><?php echo _("Parent Step"); ?></td>
                                            <td><?php echo _("Action"); ?></td>
                                        </tr>
                                        <tr class="newStepTR">
                                            <td>
                                            <input type="hidden" class="stepID" value="-1">
                                            <input type="text" class="stepName"></td>
                                            <td>
                                                <select name='userGroupID' id='userGroupID' style='width:150px;' class='changeSelect userGroupID'>
                                                        <?php
                                                        foreach ($userGroupArray as $userGroup){
                                                            echo "<option value='" . $userGroup['userGroupID'] . "'>" . $userGroup['groupName'] . "</option>\n";
                                                        }
                                                        ?>
                                                </select>
                                            </td>
                                            <td>
                                               <select name='priorStepID' id='priorStepID' style='width:150px;' class='changeSelect priorStepID'>
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($parentSteps as $parentStep) {
                                                        echo "<option value='" . $parentStep->stepID . "'>" . $parentStep->stepName . "</option>\n";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><a href="javascript:void(0)"><img src="images/add.gif" class="addStep" alt="Add" /></a></td>
                                        </tr>
                                    </table>

                                        <hr />

                                    <table class='noBorder stepTable' style='width:660px; margin:15px 20px 10px 20px;'>
                                        <?php
                                        $count = count($resourceSteps);
                                        $i = 0;
                                        foreach ($resourceSteps as $resourceStep) {
                                        $disabled = ($resourceStep->stepEndDate) ? 'disabled="disabled"':'';
                                        $i++;
                                        if ($i == $count) $lastStepClass = ' class="lastStep"';
                                        ?>
                                        <tr class="stepTR">
                                            <td>
                                            <input type="hidden" class="action" value="keep">
                                            <input type="hidden" class="stepID" value="<?php echo $resourceStep->resourceStepID; ?>">
                                            <input type="text" class="stepName changeInput" value="<?php echo $resourceStep->stepName; ?>"></td>
                                            <td style='vertical-align:top;text-align:left;'>
                                                <select name='userGroupID' id='userGroupID' style='width:150px;' class='changeSelect userGroupID' <?php echo $disabled; ?>>
                                                    <?php
                                                    foreach ($userGroupArray as $userGroup){
                                                        $selected = ($userGroup['userGroupID'] == $resourceStep->userGroupID)? 'selected':'';
                                                        echo "<option value='" . $userGroup['userGroupID'] . "' ".$selected.">" . $userGroup['groupName'] . "</option>\n";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name='priorStepID' id='priorStepID' style='width:150px;' class='changeSelect priorStepID'>
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($parentSteps as $parentStep) {
                                                        $selected = ($parentStep->stepID != null && $parentStep->stepID == $resourceStep->priorStepID) ? 'selected="selected"' : '';
                                                        echo "<option value='" . $parentStep->stepID . "' ".$selected.">" . $parentStep->stepName . "</option>\n";
                                                    }
                                                    ?>
                                                </select>

                                            </td>
                                            <td><a href="javascript:void(0)"><img src="images/cross.gif" class="removeStep" alt="Delete" /></a></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class='noBorderTable' style='width:125px;'>
                <tr>
                    <td style='text-align:left'><input type='button' value='submit' name='submitCurrentWorkflowForm' id ='submitCurrentWorkflowForm'></td>
                    <td style='text-align:right'><input type='button' value='cancel' onclick="kill(); tb_remove();"></td>
                </tr>
            </table>

            <script type="text/javascript" src="js/forms/currentWorkflowForm.js?random=<?php echo rand(); ?>"></script>
        </form>
    </div>

    <?php

}
