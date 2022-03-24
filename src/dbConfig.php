<?php 
namespace SpreedSheet;
class Database{
    //private access modifiers
    private $db_host = "localhost";
    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "fiver_tasks";
    public $mysqli = "";
    public $result = array();
    private $conn = false;
    //database connection
    public function __construct()
    {
    if($this->conn == false){
        $this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
        $this->conn = true;
     if($this->mysqli->connect_error){
         array_push($this->result,$this->mysqli->connect_error);
         return false;

     }else{
         return true;
     } 
    }
}












  //table exists
    public function tableExists($table){
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb = $this->mysqli->query($sql);
        if($tableInDb){
            if($tableInDb->num_rows == 1){
                return true;
            }else{
                array_push($this->result,$table."does not exist in database");
                return false;

            }
        }
    }
    //show result
    public function getResult(){
        $val = $this->result;//value er vitor ekta result dekhanor por amra $this->result ke khali kore dilam jate tar moddhe notun kichu dhukate pari

       $this->result = array();//$this->result = array(); er mane $this->result = khali 
        return $val;
    }




    
//__desctruce method for database  close connection 
    public function __destruct()
    {
    if($this->conn){
        if($this->mysqli->close()){
            $this->conn = false;  
            return true;
        }
    }else{
        
        return false;
    }
    }
    
}
class RowModel extends Database{
 //selecting data
 public function select($table,$rows="*",$join=null,$where=null,$order=null,$limit=null)
 {
 if($this->tableExists($table)){
  $sql = "SELECT $rows FROM $table";
  if($join != null){
  $sql .= " JOIN $join";
  }
  if($where != null){
     $sql .= " WHERE $where";
     }
     if($order != null){
         $sql .= " ORDER BY $order";
         }
         if($limit != null){
             $sql .= " LIMIT 0,$limit";
             }
     echo $sql;
     $query = $this->mysqli->query($sql);
     if($query){
         $this->result = $query->fetch_all(MYSQLI_ASSOC);
         return true;
     }else{
         array_push($this->result,$this->mysqli->error);
         
     }
 }else{
     return false;
 }
 }
}

class SpreadModel extends Database{
    public function SpreadSheet($datas,$keys){
        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: attachment; filename=customers.xls");//you can change the file name
        header("Pragma: no-cache");
        header("Expires: 0");
        echo'<table border="1">
        <tr style="font-weight:bold">';
        foreach($keys as $key){
    
            echo '<td>'.$key.'</td>';
        }
       echo ' </tr>';
     foreach ($datas as $key => $data) {
     //just write your keys name for my table these are my keys
     echo'<tr>
        <td>'.$data['id'].'</td>
        <td>'.$data['name'].'</td>
        <td>'.$data['email'].'</td>
        <td>'.$data['username'].'</td>
        <td>'.$data['dob'].'</td>
         </tr>';
         }
              
     echo '</table>';
    
    }
}


?>
