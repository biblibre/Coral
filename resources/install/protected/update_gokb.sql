DROP TABLE IF EXISTS `Identifier`; /*replace IsbnOrIssn table which can be deleted*/
CREATE TABLE `Identifier` (
  `identifierID` int(11) NOT NULL auto_increment,
  `resourceID` int(11) NOT NULL,
  `identifierTypeID` int(11) default NULL,
  `identifier` varchar(45) NOT NULL,
  PRIMARY KEY (`identifierID`),
  UNIQUE KEY `identifierID` (`identifierID`),
  KEY `resourceID` (`resourceID`),
  KEY `identifierTypeID` (`identifierTypeID`)
)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `Identifier` (`resourceID`, `identifier`)
SELECT `resourceID`, `isbnOrIssn` FROM `IsbnOrIssn`;
UPDATE `Identifier` SET `identifierTypeID`=1;

DROP TABLE IF EXISTS `IsbnOrIssn`;

DROP TABLE IF EXISTS `IdentifierType`;
CREATE TABLE `IdentifierType` (
  `identifierTypeID` int(11) NOT NULL auto_increment,
  `identifierName` varchar(45) NOT NULL,
  PRIMARY KEY (`identifierTypeID`),
  UNIQUE KEY `identifierTypeID` (`identifierTypeID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `IdentifierType` (identifierName) values('Isxn');
INSERT INTO `IdentifierType` (identifierName) values('Issn');
INSERT INTO `IdentifierType` (identifierName) values('Isbn');
INSERT INTO `IdentifierType` (identifierName) values('eIssn');
INSERT INTO `IdentifierType` (identifierName) values('eIsbn');
INSERT INTO `IdentifierType` (identifierName) values('Gokb');




