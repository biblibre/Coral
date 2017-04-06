<?php
class ResourceAcquisition extends DatabaseObject {

	protected function defineRelationships() {}

	protected function overridePrimaryKeyName() {}

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
}

?>
