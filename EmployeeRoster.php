<?php

class EmployeeRoster {
    private $roster;

    public function __construct() {
        $this->roster = [];
    }

    public function addEmployee(Employee $employee) {
        $this->roster[] = $employee; 
    }

    public function deleteEmployee($index) {
        if (isset($this->roster[$index])) {
            unset($this->roster[$index]);
            $this->roster = array_values($this->roster);
            echo "Employee deleted.\n";
        } else {
            echo "Employee not found.\n";
        }
    }

    public function getEmployees() {
        return $this->roster;
    }

    public function countCE() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee instanceof CommissionEmployee;
        }));
    }

    public function countHE() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee instanceof HourlyEmployee;
        }));
    }

    public function countPE() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee instanceof PieceWorker;
        }));
    }

    public function payroll() {
        foreach ($this->roster as $employee) {
            echo $employee->toString() . "\n-----------------\nEarnings: " . $employee->earnings() . "\n";
        }
    }
}
?>
