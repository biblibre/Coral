<?php
class ResourceAcquisition extends DatabaseObject {

	protected function defineRelationships() {}

	protected function overridePrimaryKeyName() {}

	//removes resourceAcquisition authorized sites
	public function removeAuthorizedSites() {

		$query = "DELETE
			FROM ResourceAuthorizedSiteLink
			WHERE resourceAcquisitionID = '" . $this->resourceAcquisitionID . "'";

		$result = $this->db->processQuery($query);
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
