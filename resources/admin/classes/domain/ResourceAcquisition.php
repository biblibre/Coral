<?php
class ResourceAcquisition extends DatabaseObject {

	protected function defineRelationships() {}

	protected function overridePrimaryKeyName() {}

    // Copy what was linked to the resourceAcquisition given in parameter to this one
    public function dbClone($sourceID) {
        $source = new ResourceAcquisition(new NamedArguments(array('primaryKey' => $sourceID)));

        // Clone other fields from ResourceAcquisition


        // Copy acquisitions
        $this->cloneResourcePayments($source);
        
        // Copy access
        // Copy cataloging
        // Copy contacts
        // Copy attachments
    }

    public function cloneResourcePayments($source) {
        foreach ($source->getResourcePayments() as $srp) {
            error_log("Cloning RP from " . $source->resourceAcquisitionID . " to " . $srp->resourceAcquisitionID);
           $srp->resourceAquisitionID = $this->resourceAcquisitionID;
           $srp->save(); 
        } 
    }

	//returns array of contact objects
	public function getUnarchivedContacts($moduleFilter=false) {
		$config = new Configuration;
		$contactsArray = array();

		if (!$moduleFilter || $moduleFilter == 'resources') {
			//get resource specific contacts first
			$query = "SELECT C.*, GROUP_CONCAT(CR.shortName SEPARATOR '<br /> ') contactRoles
				FROM Contact C, ContactRole CR, ContactRoleProfile CRP
				WHERE (archiveDate = '0000-00-00' OR archiveDate is null)
				AND C.contactID = CRP.contactID
				AND CRP.contactRoleID = CR.contactRoleID
				AND resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'
				GROUP BY C.contactID
				ORDER BY C.name";

			$result = $this->db->processQuery($query, 'assoc');

			//need to do this since it could be that there's only one request and this is how the dbservice returns result
			if (isset($result['contactID'])) { $result = [$result]; }
			foreach ($result as $row) {
				array_push($contactsArray, $row);
			}
		}


		//if the org module is installed also get the org contacts from org database
		if ($config->settings->organizationsModule == 'Y' && (!$moduleFilter || $moduleFilter == 'organizations')) {
			$dbName = $config->settings->organizationsDatabaseName;

			$query = "SELECT distinct OC.*, O.name organizationName, GROUP_CONCAT(DISTINCT CR.shortName SEPARATOR '<br /> ') contactRoles
					FROM " . $dbName . ".Contact OC, " . $dbName . ".ContactRole CR, " . $dbName . ".ContactRoleProfile CRP, " . $dbName . ".Organization O, Resource R, ResourceAcquisition RA, ResourceOrganizationLink ROL
					WHERE (OC.archiveDate = '0000-00-00' OR OC.archiveDate is null)
					AND R.resourceID = ROL.resourceID
					AND ROL.organizationID = OC.organizationID
					AND CRP.contactID = OC.contactID
					AND CRP.contactRoleID = CR.contactRoleID
					AND O.organizationID = OC.organizationID
                    AND R.resourceID = RA.resourceID
					AND RA.resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'
					GROUP BY OC.contactID, O.name
					ORDER BY OC.name";

			$result = $this->db->processQuery($query, 'assoc');

			//need to do this since it could be that there's only one request and this is how the dbservice returns result
			if (isset($result['contactID'])) { $result = [$result]; }
			foreach ($result as $row) {
				array_push($contactsArray, $row);
			}

		}
		return $contactsArray;
	}


	//returns array of contact objects
	public function getArchivedContacts() {

		$config = new Configuration;
		$contactsArray = array();

		//get resource specific contacts
		$query = "SELECT C.*, GROUP_CONCAT(CR.shortName SEPARATOR '<br /> ') contactRoles
			FROM Contact C, ContactRole CR, ContactRoleProfile CRP
			WHERE (archiveDate != '0000-00-00' && archiveDate != '')
			AND C.contactID = CRP.contactID
			AND CRP.contactRoleID = CR.contactRoleID
			AND resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'
			GROUP BY C.contactID
			ORDER BY C.name";

		$result = $this->db->processQuery($query, 'assoc');


		//need to do this since it could be that there's only one request and this is how the dbservice returns result
		if (isset($result['contactID'])) { $result = [$result]; }
		foreach ($result as $row) {
			array_push($contactsArray, $row);
		}

		//if the org module is installed also get the org contacts from org database
		if ($config->settings->organizationsModule == 'Y') {
			$dbName = $config->settings->organizationsDatabaseName;

			$query = "SELECT DISTINCT OC.*, O.name organizationName, GROUP_CONCAT(DISTINCT CR.shortName SEPARATOR '<br /> ') contactRoles
					FROM " . $dbName . ".Contact OC, " . $dbName . ".ContactRole CR, " . $dbName . ".ContactRoleProfile CRP, " . $dbName . ".Organization O, Resource R, ResourceAcquisition RA, ResourceOrganizationLink ROL
					WHERE (OC.archiveDate != '0000-00-00' && OC.archiveDate is not null)
					AND R.resourceID = ROL.resourceID
					AND ROL.organizationID = OC.organizationID
					AND CRP.contactID = OC.contactID
					AND CRP.contactRoleID = CR.contactRoleID
					AND O.organizationID = OC.organizationID
                    AND R.resourceID = RA.resourceID
					AND RA.resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'
					GROUP BY OC.contactID, O.name
					ORDER BY OC.name";


			$result = $this->db->processQuery($query, 'assoc');


			//need to do this since it could be that there's only one request and this is how the dbservice returns result
			if (isset($result['contactID'])) { $result = [$result]; }
			foreach ($result as $row) {
				array_push($contactsArray, $row);
			}

		}
		return $contactsArray;
	}



	//removes payment records
	public function removeResourcePayments() {

		$query = "DELETE
			FROM ResourcePayment
			WHERE resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query);
	}

	//returns array of ResourcePayment objects
	public function getResourcePayments() {

		$query = "SELECT * FROM ResourcePayment WHERE resourceAcquisitionID = '" . $this->resourceAcquisitionID . "' ORDER BY year DESC, subscriptionStartDate DESC";

		$result = $this->db->processQuery($query, 'assoc');

		$objects = array();

		//need to do this since it could be that there's only one request and this is how the dbservice returns result
		if (isset($result['resourcePaymentID'])) { $result = [$result]; }
		foreach ($result as $row) {
			$object = new ResourcePayment(new NamedArguments(array('primaryKey' => $row['resourcePaymentID'])));
			array_push($objects, $object);
		}

		return $objects;
	}


	//returns array of attachments objects
	public function getAttachments() {

		$query = "SELECT * FROM Attachment A, AttachmentType AT
					WHERE AT.attachmentTypeID = A.attachmentTypeID
					AND resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'
					ORDER BY AT.shortName";

		$result = $this->db->processQuery($query, 'assoc');

		$objects = array();

		//need to do this since it could be that there's only one request and this is how the dbservice returns result
		if (isset($result['attachmentID'])) { $result = [$result]; }
		foreach ($result as $row) {
			$object = new Attachment(new NamedArguments(array('primaryKey' => $row['attachmentID'])));
			array_push($objects, $object);
		}

		return $objects;
	}


	//removes resourceAcquisition authorized sites
	public function removeAuthorizedSites() {

		$query = "DELETE
			FROM ResourceAuthorizedSiteLink
			WHERE resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query);
	}

    public function getOrganization() {
		$config = new Configuration;
        $dbName = $config->settings->organizationsDatabaseName;

		$query = ($config->settings->organizationsModule == 'Y') ?
            "SELECT name FROM " . $dbName . ".Organization WHERE organizationID = " . $this->organizationID :
            "SELECT shortName AS name FROM Organization WHERE organizationID = " . $this->organizationID;

        if ($orgResult = $this->db->query($query)) {
            while ($orgRow = $orgResult->fetch_assoc()) {
                $orgArray['organization'] = $orgRow['name'];
                $orgArray['organizationID'] = $this->organizationID;;
            }
        }

        return $orgArray;
    }

	public function hasCatalogingInformation() {
		return ($this->recordSetIdentifier || $this->recordSetIdentifier || $this->bibSourceURL || $this->catalogingTypeID || $this->catalogingStatusID || $this->numberRecordsAvailable || $this->numberRecordsLoaded || $this->hasOclcHoldings);
	}

	//removes resourceAcquisition administering sites
	public function removeAdministeringSites() {

		$query = "DELETE
			FROM ResourceAdministeringSiteLink
			WHERE resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query);
	}


	//removes resource purchase sites
	public function removePurchaseSites() {

		$query = "DELETE
			FROM ResourcePurchaseSiteLink
			WHERE resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query);
	}

	//returns array of purchase site objects
	public function getPurchaseSites() {

		$query = "SELECT PurchaseSite.* FROM PurchaseSite, ResourcePurchaseSiteLink RPSL where RPSL.purchaseSiteID = PurchaseSite.purchaseSiteID AND resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query, 'assoc');

		$objects = array();

		//need to do this since it could be that there's only one request and this is how the dbservice returns result
		if (isset($result['purchaseSiteID'])) { $result = [$result]; }
		foreach ($result as $row) {
			$object = new PurchaseSite(new NamedArguments(array('primaryKey' => $row['purchaseSiteID'])));
			array_push($objects, $object);
		}

		return $objects;
	}

	//returns array of authorized site objects
	public function getAuthorizedSites() {

		$query = "SELECT AuthorizedSite.* FROM AuthorizedSite, ResourceAuthorizedSiteLink RPSL where RPSL.authorizedSiteID = AuthorizedSite.authorizedSiteID AND resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query, 'assoc');

		$objects = array();

		//need to do this since it could be that there's only one request and this is how the dbservice returns result
		if (isset($result['authorizedSiteID'])) { $result = [$result]; }
		foreach ($result as $row) {
			$object = new AuthorizedSite(new NamedArguments(array('primaryKey' => $row['authorizedSiteID'])));
			array_push($objects, $object);
		}

		return $objects;
	}



	//returns array of administering site objects
	public function getAdministeringSites() {

		$query = "SELECT AdministeringSite.* FROM AdministeringSite, ResourceAdministeringSiteLink RPSL where RPSL.administeringSiteID = AdministeringSite.administeringSiteID AND resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query, 'assoc');

		$objects = array();

		//need to do this since it could be that there's only one request and this is how the dbservice returns result
		if (isset($result['administeringSiteID'])) { $result = [$result]; }
		foreach ($result as $row) {
			$object = new AdministeringSite(new NamedArguments(array('primaryKey' => $row['administeringSiteID'])));
			array_push($objects, $object);
		}

		return $objects;
	}


	//returns array of notes objects
	public function getNotes($tabName = NULL) {

		if ($tabName) {
			$query = "SELECT * FROM ResourceNote RN
						WHERE resourceID = '" . $this->resourceID . "'
						AND UPPER(tabName) = UPPER('" . $tabName . "')
						ORDER BY updateDate desc";
		}else{
			$query = "SELECT RN.*
						FROM ResourceNote RN
						LEFT JOIN NoteType NT ON NT.noteTypeID = RN.noteTypeID
						WHERE resourceID = '" . $this->resourceID . "'
						ORDER BY updateDate desc, NT.shortName";
		}

		$result = $this->db->processQuery($query, 'assoc');

		$objects = array();

		//need to do this since it could be that there's only one request and this is how the dbservice returns result
		if (isset($result['resourceNoteID'])) { $result = [$result]; }
		foreach ($result as $row) {
			$object = new ResourceNote(new NamedArguments(array('primaryKey' => $row['resourceNoteID'])));
			array_push($objects, $object);
		}

		return $objects;
	}



}

?>
