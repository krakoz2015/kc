<?php
class Student{
    private $conn;
    private $table_name = "students";
 	public $limit=5;
 
    public function __construct($db){
        $this->conn = $db;
    }
	
	function all_students($page=1){
		$n=$this->limit*($page-1);
		$limit= $n.",".$this->limit;
        $stmt = $this->conn->query("SELECT * FROM ".$this->table_name." LIMIT ".$limit);
		$res=array();
		while ($row = $stmt->fetch())
		{
		    $res[]=$row;	
		}
		return $res;
	}

	function all_students_count(){
        return $this->conn->query("SELECT count(*) FROM ".$this->table_name)->fetchColumn();		
	}

}