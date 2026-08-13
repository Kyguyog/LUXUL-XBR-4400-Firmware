<?php

class Routing_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function getAllActiveRoutesArray() {
        $this->execute(GET_ALL_ACTIVE_ROUTES_COMMAND, $output, $ret);
        return $output;
    }

    public function getInterfaceNameArray() {
        $this->execute(GET_INTERFACE_NAME_COMMAND, $output, $ret);
        return $output;
    }

    public function getLuxulRoute($index) {
        return $this->get(LUXUL . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index);
    }

    public function addLuxulRoute() {
        $this->add(LUXUL, ROUTE);
    }

    public function deleteLuxulRoute($index) {
        $this->delete(LUXUL . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index);
    }

    public function addNetworkRoute() {
        $this->add(NETWORK, ROUTE);
    }

    public function deleteNetworkRoute($index) {
        $this->delete(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index);
    }

    public function setStaticRouteDescription($value) {
        $this->set(LUXUL . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . DESCRIPTION, $value);
    }

    public function getStaticRouteDescription($index) {
        return $this->get(LUXUL . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index . UCI_FIELD_DOT . DESCRIPTION);
    }

    public function setStaticRouteInterface($value) {
        $this->set(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . NAME_INTERFACE, $value);
    }

    public function getStaticRouteInterface($index) {
        return $this->get(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index . UCI_FIELD_DOT . NAME_INTERFACE);
    }

    public function setStaticRouteDestinationIP($value) {
        $this->set(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . TARGET, $value);
    }

    public function getStaticRouteDestinationIP($index) {
        return $this->get(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index . UCI_FIELD_DOT . TARGET);
    }

    public function setStaticRouteNetmask($value) {
        $this->set(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . NET_MASK, $value);
    }

    public function getStaticRouteNetmask($index) {
        return $this->get(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index . UCI_FIELD_DOT . NET_MASK);
    }

    public function setStaticRouteGateway($value) {
        $this->set(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . GATE_WAY, $value);
    }

    public function getStaticRouteGateway($index) {
        return $this->get(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index . UCI_FIELD_DOT . GATE_WAY);

    }

    public function setStaticRouteMetric($value) {
        $this->set(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . UCI_FIELD_INDEX_LAST . UCI_FIELD_DOT . METRIC, $value);
    }

    public function getStaticRouteMetric($index) {
        return $this->get(NETWORK . UCI_FIELD_DOT . UCI_FIELD_AT . ROUTE . $index . UCI_FIELD_DOT . METRIC);
    }

}