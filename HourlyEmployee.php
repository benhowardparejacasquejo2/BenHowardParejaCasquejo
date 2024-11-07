<?php

class HourlyEmployee extends Employee {
    private $hourlyRate;
    private $hoursWorked;

    public function __construct($name, $address, $age, $companyName, $hourlyRate, $hoursWorked) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hourlyRate = $hourlyRate;
        $this->hoursWorked = $hoursWorked;
    }

    
    public function earnings() {
        if ($this->hoursWorked > 40) {
            
            $regularPay = 40 * $this->hourlyRate;
            
            $overtimeHours = $this->hoursWorked - 40;
            $overtimePay = $overtimeHours * 1.5 * $this->hourlyRate;
            return $regularPay + $overtimePay;
        } else {
            
            return $this->hoursWorked * $this->hourlyRate;
        }
    }

    
    public function toString() {
        return parent::toString() . "\n-----------------\nHourly Rate: $this->hourlyRate\n-----------------\nHours Worked: $this->hoursWorked\n-----------------\nEarnings: " . $this->earnings();
    }
}

?>
