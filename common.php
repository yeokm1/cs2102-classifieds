<?php

if(!isset($_SESSION)) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "classifieds");
if (mysqli_connect_errno($conn)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Class for binding param, can be handy (copied from php.net)
class BindParam{ 
    private $values = array(), $types = ''; 

    public function add( $type, &$value ){ 
        $this->values[] = $value; 
        $this->types .= $type; 
    } 

    public function get(){ 
        return array_merge(array($this->types), $this->values); 
    }

    public function getRef(){ 
        return $this->refValues(array_merge(array($this->types), $this->values)); 
    }

    // Not originally in the class
    function refValues($arr)
    { 
        $refs = array();

        foreach ($arr as $key => $value)
        {
            $refs[$key] = &$arr[$key]; 
        }

        return $refs; 
    }
}

?>