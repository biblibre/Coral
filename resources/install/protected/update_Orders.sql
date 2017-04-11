-- TODO: Update me
CREATE TABLE `ResourceAcquisition` (
  `resourceAcquisitionID` int(11) NOT NULL AUTO_INCREMENT,
  `resourceID` int(11) NOT NULL,
  `parentResourceID` int(11) DEFAULT NULL,
  `orderNumber` varchar(45) DEFAULT NULL,
  `systemNumber` varchar(45) DEFAULT NULL,
  `acquisitionTypeID` int(11) DEFAULT NULL,
  `subscriptionStartDate` date NOT NULL,
  `subscriptionEndDate` date NOT NULL,
  `organizationID` int(11) NOT NULL,
  `licenseID` int(11) DEFAULT NULL
);
ALTER TABLE `ResourceAcquisition`
  ADD PRIMARY KEY (`resourceAcquisitionID`);

CREATE TABLE `AuthorizedSiteAcquisition` (
  `AuthorizedSiteAcquisitionID` int(11) NOT NULL AUTO_INCREMENT,
  `resourceAcquisitionID` int(11) NOT NULL,
  `authorizedSiteID` int(11) NOT NULL
);
ALTER TABLE `AuthorizedSiteAcquisition`
  ADD PRIMARY KEY (`AuthorizedSiteAcquisitionID`);

ALTER TABLE `ResourcePurchaseSiteLink` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `ResourcePayment` CHANGE `resourceID` `resourceAcquisitionID` INT(10) UNSIGNED NOT NULL;
ALTER TABLE `ResourceAdministeringSiteLink` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `ResourceAuthorizedSiteLink` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `Attachment` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NULL DEFAULT NULL;
ALTER TABLE `Contact` CHANGE `resourceID` `resourceAcquisitionID` INT(11) NOT NULL;



-- IMPORT FROM OLD FIELDS

-- REMOVE OLD FIELDS
