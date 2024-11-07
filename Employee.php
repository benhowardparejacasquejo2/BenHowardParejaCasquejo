<?php

abstract class Employee extends Person {
    private $companyName;

    public function __construct($name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age);
        $this->companyName = $companyName;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }

    public function toString() {
        return parent::toString() . "\n-----------------\nCompany: $this->companyName";
    }

    
    public function getDetails() {
        return $this->toString();
    }
}
?>
