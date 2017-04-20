CREATE TABLE `ResourceAcquisition` (
  `resourceAcquisitionID` int(11) NOT NULL,
  `resourceID` int(11) NOT NULL,
  `parentResourceID` int(11) DEFAULT NULL,
  `orderNumber` varchar(45) DEFAULT NULL,
  `systemNumber` varchar(45) DEFAULT NULL,
  `acquisitionTypeID` int(11) DEFAULT NULL,
  `subscriptionStartDate` date NOT NULL,
  `subscriptionEndDate` date NOT NULL,
  `subscriptionAlertEnabledInd` int(11) DEFAULT NULL,
  `organizationID` int(11) DEFAULT NULL,
  `licenseID` int(11) DEFAULT NULL,
  `authenticationTypeID` int(10) DEFAULT NULL,
  `authenticationUserName` varchar(200) DEFAULT NULL,
  `authenticationPassword` varchar(200) DEFAULT NULL,
  `accessMethodID` int(10) DEFAULT NULL,
  `storageLocationID` int(11) DEFAULT NULL,
  `userLimitID` int(11) DEFAULT NULL,
  `coverageText` varchar(1000) DEFAULT NULL,
  `bibSourceURL` varchar(2000) DEFAULT NULL,
  `catalogingTypeID` int(11) DEFAULT NULL,
  `catalogingStatusID` int(11) DEFAULT NULL,
  `numberRecordsAvailable` varchar(45) DEFAULT NULL,
  `numberRecordsLoaded` varchar(45) DEFAULT NULL,
  `recordSetIdentifier` varchar(45) DEFAULT NULL,
  `hasOclcHoldings` varchar(10) DEFAULT NULL
);

ALTER TABLE `ResourceAcquisition`
  ADD PRIMARY KEY (`resourceAcquisitionID`);

/*
CREATE TABLE `AuthorizedSiteAcquisition` (
  `AuthorizedSiteAcquisitionID` int(11) NOT NULL AUTO_INCREMENT,
  `resourceAcquisitionID` int(11) NOT NULL,
  `authorizedSiteID` int(11) NOT NULL
);
ALTER TABLE `AuthorizedSiteAcquisition`
  ADD PRIMARY KEY (`AuthorizedSiteAcquisitionID`);
*/

ALTER TABLE `ResourcePurchaseSiteLink` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `ResourcePayment` CHANGE `resourceID` `resourceAcquisitionID` INT(10) UNSIGNED NOT NULL;
ALTER TABLE `ResourceAdministeringSiteLink` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `ResourceAuthorizedSiteLink` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `Attachment` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `Contact` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NOT NULL;
ALTER TABLE `ResourceLicenseLink` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `ResourceLicenseStatus` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `IssueRelationship` ADD `resourceAcquisitionID` INT(11) NULL DEFAULT NULL AFTER `entityTypeID`;
ALTER TABLE `Downtime` ADD `resourceAcquisitionID` INT(11) NULL DEFAULT NULL AFTER `note`;


-- IMPORT FROM OLD FIELDS


-- REMOVE OLD FIELDS
