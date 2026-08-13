<?php

class Dmz_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function setDMZStatus($value) {
        $this->set(LUXUL_DMZ_STATUS, $value);
    }

    public function getDMZStatus() {
        return $this->get(LUXUL_DMZ_STATUS);
    }

}