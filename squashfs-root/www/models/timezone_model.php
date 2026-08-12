<?php

class Timezone_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function setTimeZone($value) {
        $this->set(SYSTEM_TIMEZONE, $value);
    }

    public function getTimeZone() {
        return $this->get(SYSTEM_TIMEZONE);
    }

    public function setTimeZoneFlag() {
        $this->set(LUXUL_TIMEZONE_FLAG, TIMEZONE_FLAG_YES);
    }

    public function getTimeZoneFlag() {
        return $this->get(LUXUL_TIMEZONE_FLAG);
    }

    public function deleteTimeZoneFlag() {
        $this->delete(LUXUL_TIMEZONE_FLAG);
    }

}