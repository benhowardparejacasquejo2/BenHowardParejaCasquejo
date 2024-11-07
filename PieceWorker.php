<?php

class PieceWorker extends Employee {
    private $ratePerItem;
    private $itemsProduced;

    public function __construct($name, $address, $age, $companyName, $ratePerItem, $itemsProduced) {
        parent::__construct($name, $address, $age, $companyName);
        $this->ratePerItem = $ratePerItem;
        $this->itemsProduced = $itemsProduced;
    }

    
    public function earnings() {
        return $this->ratePerItem * $this->itemsProduced;
    }

    public function toString() {
        return parent::toString() . "\n-----------------\nRate Per Item: $this->ratePerItem\n-----------------\nItems Produced: $this->itemsProduced\n-----------------\nEarnings: " . $this->earnings();
    }
}

?>
