<?php 
class User{
    public $id;
    public $name;
    public $email;
    public $address;
    public $zipcode;
    public $gender;
    public $age;

    function __construct($a, $b, $c, $d, $e, $f, $g){
        $this->id = $a;
        $this->name = $b;
        $this->email = $c;
        $this->address = $d;
        $this->zipcode = $e;
        $this->gender = $f;
        $this->age = $g;
    }
}

class Cart{
    public $id; // Product_ID
    public $category_id;
    public $price;
    public $name;

    function __construct($a, $b, $c, $d){
        $this->id = $a; 
        $this->category_id = $b;
        $this->name = $c;
        $this->price = $d;    
    }
}
?>