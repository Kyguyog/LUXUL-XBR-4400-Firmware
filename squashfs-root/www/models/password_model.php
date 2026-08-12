<?php

class Password_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function getAdminPassword() {
        return $this->get(ADMIN_NEWPASSWORD);
    }

    function setAdminPassword($value) {
        $this->set(ADMIN_NEWPASSWORD, $value);
    }
}