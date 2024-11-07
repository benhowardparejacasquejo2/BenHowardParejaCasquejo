<?php

require_once 'Person.php';
require_once 'Employee.php';
require_once 'Commission.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';
require_once 'EmployeeRoster.php';

class Main {
    private EmployeeRoster $roster;
    private $size;

    public function __construct() {
        $this->roster = new EmployeeRoster();  
        $this->size = 0;
    }

    public function start() {
        $this->clear();
        echo "Welcome to the Employee Roster System!\n";
        
        do {
            $this->size = readline("Enter the size of the roster: ");
            if (!is_numeric($this->size) || $this->size < 1) {
                echo "Invalid input. Please enter a positive number.\n";
            }
        } while (!is_numeric($this->size) || $this->size < 1);
        
        $this->entrance();
    }

    public function entrance() {
        $choice = 0;
    
        while (true) {
            $this->clear();
            $this->menu();
            $choice = readline("Enter your choice: ");
    
            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->displayMenu();
                    break;
                case 4:
                    $this->viewEmployeesByType();
                    break;
                case 5:
                    $this->updateMenu();
                    break;
                case 0:
                    $this->exitProgram();
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
    }
    

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Display Employees\n";
        echo "[4] View Employees by Their Type:\n";
        echo "[5] Update Employee\n";
        echo "[0] Exit\n";
    }
    

    public function addMenu() {
        if (count($this->roster->getEmployees()) >= $this->size) {
            echo "Roster is full. You cannot add more employees.\n";
            readline("Press Enter to return to the main menu...");
            return; 
        }
    
        $name = readline("Enter Employee Name: ");
        $address = readline("Enter Employee Address: ");
        $age = readline("Enter Employee Age: ");
        $companyName = readline("Enter Company Name: ");
    
        $this->empType($name, $address, $age, $companyName);
    }
    

    public function empType($name, $address, $age, $companyName) {
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = readline("Choose Employee Type: ");

        switch ($type) {
            case 1:
                $regularSalary = readline("Enter Regular Salary: ");
                $itemsSold = readline("Enter Items Sold: ");
                $commissionRate = readline("Enter Commission Rate: ");
                $employee = new Commission($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate);
                $this->roster->addEmployee($employee);
                break;
            case 2:
                $hourlyRate = readline("Enter Hourly Rate: ");
                $hoursWorked = readline("Enter Hours Worked: ");
                $employee = new HourlyEmployee($name, $address, $age, $companyName, $hourlyRate, $hoursWorked);
                $this->roster->addEmployee($employee);
                break;
            case 3:
                $ratePerItem = readline("Enter Rate Per Item: ");
                $itemsProduced = readline("Enter Items Produced: ");
                $employee = new PieceWorker($name, $address, $age, $companyName, $ratePerItem, $itemsProduced);
                $this->roster->addEmployee($employee);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                break;
        }

        readline("Press Enter to continue...");
    }

    public function deleteMenu() {
        echo "Delete Employee\n";
        $employees = $this->roster->getEmployees();

        if (count($employees) === 0) {
            echo "No employees to delete.\n";
            readline("Press Enter to continue...");
            return; 
        }

        foreach ($employees as $index => $employee) {
            echo "[$index] " . $employee->getDetails() . "\n";
        }

        $index = readline("Enter employee number to delete: ");

        if ($index >= 0 && isset($employees[$index])) {
            $this->roster->deleteEmployee($index);
            echo "Employee deleted successfully.\n";
        } else {
            echo "Invalid selection.\n";
        }

        readline("Press Enter to continue...");
    }

    public function displayMenu() {
        $employees = $this->roster->getEmployees();
        if (count($employees) === 0) {
            echo "No employees in the roster.\n";
        } else {
            foreach ($employees as $employee) {
                echo $employee->getDetails() . "\n";
            }
        }
        readline("Press Enter to continue...");
    }

    public function viewEmployeesByType() {
        echo "*** VIEW EMPLOYEES BY TYPE ***\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        echo "[0] Back to Main Menu\n";
    
        $choice = readline("Enter your choice: ");
        $employees = $this->roster->getEmployees();
        
        switch ($choice) {
            case 1:
                $this->displayByType('Commission', $employees);
                break;
            case 2:
                $this->displayByType('HourlyEmployee', $employees);
                break;
            case 3:
                $this->displayByType('PieceWorker', $employees);
                break;
            case 0:
                return;
            default:
                echo "Invalid input. Please try again.\n";
                break;
        }
    
        readline("Press Enter to continue...");
    }
    
    private function displayByType($type, $employees) {
        $filteredEmployees = array_filter($employees, function($employee) use ($type) {
            return get_class($employee) === $type;
        });
    
        if (empty($filteredEmployees)) {
            echo "No employees found for this type.\n";
        } else {
            foreach ($filteredEmployees as $employee) {
                echo $employee->getDetails() . "\n";
            }
        }
    }

    
    public function updateMenu() {
        echo "Update Employee\n";
        $employees = $this->roster->getEmployees();
    
        if (count($employees) === 0) {
            echo "No employees to update.\n";
            readline("Press Enter to continue...");
            return;
        }
    
        foreach ($employees as $index => $employee) {
            echo "[$index] " . $employee->getDetails() . "\n";
        }
    
        $index = readline("Enter employee number to update: ");
    
        if (isset($employees[$index])) {
            $employee = $employees[$index];
            echo "You are updating the following employee:\n" . $employee->getDetails() . "\n";
            $this->updateEmployeeDetails($employee);
        } else {
            echo "Invalid selection. Returning to menu.\n";
        }
    
        readline("Press Enter to continue...");
    }
    
    public function updateEmployeeDetails($employee) {
       
        echo "What would you like to update?\n";
        echo "[1] Name\n";
        echo "[2] Address\n";
        echo "[3] Age\n";
        
      
        if ($employee instanceof Commission) {
            echo "[4] Regular Salary\n";
            echo "[5] Items Sold\n";
            echo "[6] Commission Rate\n";
        } elseif ($employee instanceof HourlyEmployee) {
            echo "[4] Hourly Rate\n";
            echo "[5] Hours Worked\n";
        } elseif ($employee instanceof PieceWorker) {
            echo "[4] Rate Per Item\n";
            echo "[5] Items Produced\n";
        }
    
        $choice = readline("Enter your choice: ");
        
        switch ($choice) {
            case 1:
                $newName = readline("Enter new name: ");
                $employee->setName($newName);
                break;
            case 2:
                $newAddress = readline("Enter new address: ");
                $employee->setAddress($newAddress);
                break;
            case 3:
                $newAge = readline("Enter new age: ");
                $employee->setAge($newAge);
                break;
            case 4:
                if ($employee instanceof Commission) {
                    $newSalary = readline("Enter new regular salary: ");
                    $employee->setRegularSalary($newSalary);
                } elseif ($employee instanceof HourlyEmployee) {
                    $newHourlyRate = readline("Enter new hourly rate: ");
                    $employee->setHourlyRate($newHourlyRate);
                } elseif ($employee instanceof PieceWorker) {
                    $newRatePerItem = readline("Enter new rate per item: ");
                    $employee->setRatePerItem($newRatePerItem);
                }
                break;
            case 5:
                if ($employee instanceof Commission) {
                    $newItemsSold = readline("Enter new items sold: ");
                    $employee->setItemsSold($newItemsSold);
                } elseif ($employee instanceof HourlyEmployee) {
                    $newHoursWorked = readline("Enter new hours worked: ");
                    $employee->setHoursWorked($newHoursWorked);
                } elseif ($employee instanceof PieceWorker) {
                    $newItemsProduced = readline("Enter new items produced: ");
                    $employee->setItemsProduced($newItemsProduced);
                }
                break;
            case 6:
                if ($employee instanceof Commission) {
                    $newCommissionRate = readline("Enter new commission rate: ");
                    $employee->setCommissionRate($newCommissionRate);
                }
                break;
            default:
                echo "Invalid choice. Returning to menu.\n";
                return;
        }
    
        echo "Employee updated successfully.\n";
    }
    

    public function exitProgram() {
        echo "Exiting program.\n";
        exit;
    }

    public function clear() {
        if (PHP_OS_FAMILY === 'Windows') {
            system('cls');
        } else {
            system('clear');
        }
    }
}
?>
