<?php


class Commission extends Employee {
    private $regularSalary;
    private $itemsSold;
    private $commissionRate;

    public function __construct($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->regularSalary = $regularSalary;
        $this->itemsSold = $itemsSold;
        $this->commissionRate = $commissionRate;
    }

    public function setRegularSalary($salary) {
        $this->regularSalary = $salary;
    }

    public function setItemsSold($itemsSold) {
        $this->itemsSold = $itemsSold;
    }

    public function setCommissionRate($commissionRate) {
        $this->commissionRate = $commissionRate;
    }

    
    public function calculateEarnings() {
        return $this->regularSalary + ($this->itemsSold * $this->commissionRate);
    }

    public function getDetails() {
        $earnings = $this->calculateEarnings();
        return parent::getDetails() . "\n-----------------\nRegular Salary: $this->regularSalary\n-----------------\nItems Sold: $this->itemsSold\n-----------------\nCommission Rate: $this->commissionRate\n-----------------\nTotal Earnings: $earnings\n-----------------\n";
    }
}

?>
