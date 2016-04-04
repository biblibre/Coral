ALTER TABLE  `Workflow` ADD  `workflowMailReminder` BOOLEAN NOT NULL AFTER  `workflowName` ,
ADD  `workflowMailReminderDelay` INT UNSIGNED NOT NULL AFTER  `workflowMailReminder` ;
