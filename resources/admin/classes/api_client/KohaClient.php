<?php

require '../resources/api_client/vendor/autoload.php';
require 'ILSClient.php';

/**
 * KohaClient
 */
class KohaClient implements ILSClient {

    private $api;
    private $coralToKohaKeys;
    private $kohaToCoralKeys;

    function __construct() {
        $config = new Configuration();
        $this->api = $config->ils->ilsApiUrl;
        $this->coralToKohaKeys = array(
            'funds' => array(
                'fundID' => 'fund_id',
                'shortName' => 'name',
                'fundCode' => 'code'
            ),
            'orders' => array(
                'fundID' => 'budget_id',
                'ilsOrderlineID' => 'order_id',
                'priceTaxExcluded' => 'rrp_tax_excluded',
                'priceTaxIncluded' => 'rrp_tax_included',
                'taxRate' => 'tax_rate_on_ordering'
            )
        );
        $this->kohaToCoralKeys['funds'] = array_flip($this->coralToKohaKeys['funds']);
        $this->kohaToCoralKeys['orders'] = array_flip($this->coralToKohaKeys['orders']);
    }

    /**
     * Gets funds from the ILS
     * @return key-value array with fund description
     */
    function getFunds() {
        $loginID = CoralSession::get('loginID');
        $borrowernumber = $this->getBorrowernumber($loginID);
        $request = $this->api . "/acquisitions/funds/";
        if ($borrowernumber) $request .= "?fund_owner_id=$borrowernumber";
        $response = Unirest\Request::get($request);
        # Array of StdClass Objects to array of associative arrays
        $funds = json_decode(json_encode($response->body), TRUE);
        $funds = $this->_arrayMapKohaToCoral($funds, 'funds');
        return $funds;
    }

    function getFund($fundid) {
        $request = $this->api . "/acquisitions/funds/?id=$fundid";
        $response = Unirest\Request::get($request);
        # Array of StdClass Objects to array of associative arrays
        $funds = json_decode(json_encode($response->body), TRUE);
        $fund = $funds[0];
        return $this->_kohaToCoral($fund, 'funds');
    }

    /**
     * Gets the ILS name
     * @return the ILS name
     */
    function getILSName() {
        return "Koha";
    }

    /**
     * Gets the ILS API url
     * @return the ILS API url
     */
    function getILSURL() {
        return $this->api;
    }

    function placeOrder($order) {
        error_log("placing order");
        $headers = array('Accept' => 'application/json');
        $request = $this->api . "/acquisitions/orders/";
        // Koha expects tax rate in decimal rather than in percentage: 5.5% => 0.0550
        if ($order['taxRate']) $order['taxRate'] = $order['taxRate'] / 100;
        $body = Unirest\Request\Body::json($this->_coralToKoha($order, 'orders'));
        $response = Unirest\Request::post($request, $headers, $body);
        return $response->body->order_id ? $response->body->order_id : null;
    }

    function updateOrder($order) {
        $headers = array('Accept' => 'application/json');
        $request = $this->api . "/acquisitions/orders/" . $order['ilsOrderlineID'];
        // Koha expects tax rate in decimal rather than in percentage: 5.5% => 0.0550
        if ($order['taxRate']) $order['taxRate'] = $order['taxRate'] / 100;
        $body = Unirest\Request\Body::json($this->_coralToKoha($order, 'orders'));
        $response = Unirest\Request::put($request, $headers, $body);
    }

    function getOrder($orderid) {
        error_log("getting order $orderid");
        $response = Unirest\Request::get($this->api . "/acquisitions/orders/$orderid");
        $order = json_decode(json_encode($response->body), TRUE);
        return isset($order['order_id']) ? $order : null;
    }

    private function getBorrowernumber($loginID) {
        $response = Unirest\Request::get($this->api . "/patrons/?userid=$loginID");
        $borrowers = json_decode(json_encode($response->body), TRUE);
        return isset($borrowers[0]) ? $borrowers[0]['patron_id'] : null;
    }


    private function _ArrayMapKohaToCoral($values, $category) {
        return array_map(array($this, '_kohaToCoral'), $values, array_fill(0,count($values),$category));
    }

    private function _ArrayMapCoralToKoha($values, $category) {
        return array_map(array($this, '_coralToKoha'), $values, array_fill(0,count($values),$category));
    }

    /**
     * Changes the keys of a fund array from Koha keys to Coral keys
     */
    private function _kohaToCoral($values, $category) {
        $kohaToCoralKeys = $this->kohaToCoralKeys;
        return $this->_changeKeys($values, $kohaToCoralKeys[$category]);
    }

    /**
     * Changes the keys of a fund array from Coral keys to Koha keys
     */
    private function _coralToKoha($values, $category) {
        $coralToKohaKeys = $this->coralToKohaKeys;
        return $this->_changeKeys($values, $coralToKohaKeys[$category]);
    }

    /**
     * Changes the keys of an array
     * @param $array a key/value array
     * @param $keys an array containing $oldKey => $newKey key/values
     * @return the modified array with the new keys
     */
    private function _changeKeys($array, $keys) {
        if (!is_array($array)) return null;
        foreach ($keys as $oldKey => $newKey) {
            if (array_key_exists($oldKey, $array)) {
                $array[$newKey] = $array[$oldKey];
                unset($array[$oldKey]);
            }
        }
        return $array;
    }

}

?>
