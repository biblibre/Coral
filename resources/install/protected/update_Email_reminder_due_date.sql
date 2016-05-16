ALTER TABLE  `Workflow` ADD  `workflowMailReminder` BOOLEAN NULL AFTER  `workflowName` ,
ADD  `workflowMailReminderDelay` INT UNSIGNED NULL AFTER  `workflowMailReminder` ;
ALTER TABLE  `ResourceStep` ADD  `mailReminder` BOOLEAN NULL,
ADD  `mailReminderDelay` INT UNSIGNED NULL;
