<?php 
namespace Makdb\Backendphp;

class db
{
    private $table;
    private $sql;
    private $connection;
    public function __construct($host,$name,$password,$db,$table){
        $this->connection=mysqli_connect($host,$name,$password,$db);
        $this->table=$table;
    }

    public function insert($data){
        $value="";
        $coulm="";
        foreach($data as $coulmns=>$values){
            $value .= "'$values',";
            $coulm.="`$coulmns`,";
        }
        $coulm=rtrim($coulm,",");
        $value=rtrim($value,",");
        $this->sql="INSERT INTO $this->table($coulm)VALUES($value)";

        return $this; 
    }
    
   public function update($data){
    $row="";
    foreach($data as $coulm=>$value){
        $row .= "`$coulm` = '$value',";
    }
    $row=rtrim($row,",");

    $this->sql="UPDATE $this->table set $row";
    return $this;
   }
   
   public function select($coulms="*"){
    $this->sql="SELECT $coulms from $this->table ";
    return $this;
   }




   public function delete(){
    $this->sql="DELETE from $this->table ";
    return $this;
   }

   //excute معمولة منشان insert and upadte and delete مابصير تكون لل select لانو معمولة لل affected row
   //فانا محتاج ل فنكشن تانية منشان اعمل fetch_all لانو هي هي رح ترجعلي كل داتا
   public function execute(){
    mysqli_query($this->connection,$this->sql);
    return mysqli_affected_rows($this->connection);

   }
   public function fetchall(){
    $query=mysqli_query($this->connection,$this->sql);
    return mysqli_fetch_all($query,MYSQLI_ASSOC);
   }
   
   public function get(){
    $query=mysqli_query($this->connection,$this->sql);
    return mysqli_fetch_assoc($query);
   }

   public function where($coulm,$operator,$value,$operator1="",$coulm1="",$operator2="",$value2=""){
    $this->sql .= " WHERE `$coulm` $operator '$value' $operator1 $coulm1 $operator2  $value2";
    return $this;
   }



        public function join($type,$table,$pk,$fk){
            $this->sql .="$type JOIN `$table` ON $pk = $fk ";
            return $this;
        }
   
      public function innerjoin($table,$pk,$fk){
       $this->sql .="INNER JOIN `$table` ON $pk=$fk";
       return $this ;
      }
   
      public function leftjoin($table,$pk,$fk){
       $this->sql .="LEFT JOIN `$table` ON $pk=$fk";
       return $this ;
      }
   
      public function rightjoin($table,$pk,$fk){
       $this->sql .="REIGHT JOIN `$table` on $pk=$fk";
       return $this ;
      }
   
}
//------------------------------------
//abstract 
//traite











