CREATE TABLE `proceeding-entry` (
  `idproceeding-entry` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `type-code` varchar(45) DEFAULT NULL,
  `filing-date` int(11) DEFAULT NULL,
  `location-code` int(11) DEFAULT NULL,
  `day-in-location` int(11) DEFAULT NULL,
  `status-update-date` int(11) DEFAULT NULL,
  `status-code` int(11) DEFAULT NULL,
  PRIMARY KEY (`idproceeding-entry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `proceeding-party` (
  `idproceeding-party` int(11) NOT NULL AUTO_INCREMENT,
  `proceeding-id` int(11) DEFAULT NULL,
  `identifier` int(11) DEFAULT NULL,
  `role-code` varchar(45) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idproceeding-party`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `proceeding-party-address` (
  `idproceeding-party-address` int(11) NOT NULL AUTO_INCREMENT,
  `proceeding-party-id` int(11) DEFAULT NULL,
  `identifier` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `orgname` varchar(255) DEFAULT NULL,
  `address-1` varchar(255) DEFAULT NULL,
  `address-2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postcode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idproceeding-party-address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `proceeding-party-property` (
  `idproceeding-party-property` int(11) NOT NULL AUTO_INCREMENT,
  `proceeding-party-id` int(11) DEFAULT NULL,
  `identifier` int(11) DEFAULT NULL,
  `serial-number` int(11) DEFAULT NULL,
  `mark-text` text DEFAULT NULL,
  PRIMARY KEY (`idproceeding-party-property`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `prosecution-entries` (
  `idprosecution-entries` int(11) NOT NULL AUTO_INCREMENT,
  `proceeding-id` int(11) DEFAULT NULL,
  `identifier` int(11) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `type-code` varchar(45) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `history-text` text DEFAULT NULL,
  PRIMARY KEY (`idprosecution-entries`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
