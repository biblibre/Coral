<?php
include_once 'directory.php';

$obj = new Resource();

$query = "SELECT resourceID from Resource";
$results = $obj->db->processQuery($query, 'assoc');

$fields = array('resourceID', 'orderNumber', 'systemNumber', 'acquisitionTypeID', 'subscriptionAlertEnabledInd', ' licenseID', 'authenticationTypeID', 'authenticationUserName', 'authenticationPassword', 'accessMethodID', 'storageLocationID', 'userLimitID', 'coverageText', 'bibSourceURL', 'catalogingTypeID', 'catalogingStatusID', 'numberRecordsAvailable', 'numberRecordsLoaded', 'recordSetIdentifier', 'hasOclcHoldings');

$tables = array('ResourcePurchaseSiteLink', 'ResourcePayment', 'ResourceAdministeringSiteLink', 'ResourceAuthorizedSiteLink', 'Attachment', 'Contact', 'ResourceLicenseLink', 'ResourceLicenseStatus'); 

foreach ($results as $row) {
    $rid = $row['resourceID'];
    print ("Creating ResourceAcquisition for resource $rid\n");
    $r = new Resource(new NamedArguments(array('primaryKey' => $rid)));
    $ra = new ResourceAcquisition();
    $ra->licenseID = 1;
    foreach ($fields as $field) {
        $ra->$field = $r->$field;
    }
    $ra->parentResourceID = null;
    $ra->subscriptionStartDate = date('Y-m-d');
    $ra->subscriptionEndDate = date('Y-m-d');
    $query = "SELECT organizationID from ResourceOrganizationLink WHERE resourceID = $rid LIMIT 1";
    $results = $obj->db->processQuery($query, 'assoc');
    $ra->organizationID = $results['organizationID'];
    
    $raid = $ra->saveAsNew();
    print ("ResourceAcquisition $raid created\n");
   
    foreach ($tables as $table) { 
        $query = "UPDATE $table SET resourceAcquisitionID = $raid WHERE resourceAcquisitionID = $rid";
        print ("Updating table $table\n");
        $obj->db->processQuery($query);
    }
    print ("\n");
    die();
    
}

?>
