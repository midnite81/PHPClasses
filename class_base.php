<?php 

class myCore { 
    
     private $host = ""; 
     private $database = ""; 
     private $user = ""; 
     private $pass = ""; 
 
     public function __construct() {
         $this->host = _HOST_; 
         $this->database = _DB_; 
         $this->user = _USER_; 
         $this->pass = _PASS_; 
         }
 
	public function getData($query,$data = "",$method = "PDO") { 
	/* Get Data from a MYSQL database */
			if ($method == "mysql") return $this->getDataMySQL($query,$data); 
			else if ($method == "mysqli") return $this->getDataMySQLi($query,$data); 
			else return $this->getDataPDO($query,$data); 
		 }
		 
    private function getDataPDO($query,$data = "") { 
	/* (private) Get Data Using PDO */
		 $db = new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8", $this->user , $this->pass );
		 try { 
			  if (is_array($data)) { 
				$q = $db->prepare($query);
				$q->execute($data);	
			  }
			  else {
				$q = $db->query($query) ;
			  }
          } 
          catch (PDOException $e) {
                return 'Database Query Failed: ' . $e->getMessage();
              }
              
           return $q->fetchAll(PDO::FETCH_ASSOC);
	}
	
	private function getDataMySQL($query,$data = "") { 
	/* (private) Get Data Using mysql */
		  $conn = mysql_connect($this->host, $this->user, $this->pass); 
		  if (!$conn) return "Could not connected to the Database Server"; 
		  $db = mysql_select_db($this->database); 
		  if (!$db) return "Could not select the database"; 
		  
		  if (is_array($data)) { 
		  		foreach ($data as $k=>$v) { 
				$v = (is_numeric($v)) ? mysql_real_escape_string($v) : "'". mysql_real_escape_string($v) . "'";
				$query = str_replace($k,$v,$query); 
				} 
			  }
				$q = mysql_query($query); 
				if (!$q) return "An error occurred when querying the database";
				
				$c = 0;
				while ($result = mysql_fetch_assoc($q)) { 
				$row[$c] = $result;
				$c++ ; 
				} 
              
           return $row;
	}
	
	private function getDataMySQLi($query,$data = "") { 
	/* (private) Get Data Using mysqli*/
		$db = new mysqli($this->host, $this->user, $this->pass, $this->database);
		if($db->connect_errno > 0) return 'Unable to connect to database [' . $db->connect_error . ']';
		
		if (is_array($data)) { 
		  		foreach ($data as $k=>$v) { 
				$v = (is_numeric($v)) ? mysql_real_escape_string($v) : "'". mysql_real_escape_string($v) . "'";
				$query = str_replace($k,$v,$query); 
				} 
			  }
			  
		if(!$result = $db->query($query)) return 'There was an error running the query [' . $db->error . ']';
		
		$c = 0;
		while($results = $result->fetch_assoc()){
   			 $row[$c] = $results;
			 $c++;
		}
		return $row;
	}
	
	
	public function emailize($string) {
	  /* turn email addresses into hyperlinks */	
	  $regex = '/(\S+@\S+\.\S+)/i';
	  $replace = "<a href='mailto:$1'>$1</a>";
	  $result = preg_replace($regex, $replace, $string);
	  return $result;
	}
	
	public function removeParagraphBlanks($string) { 
	  /* remove blanks from generated paragraphs */
	  $regex = "/\<p[^>]*?\>(\s|&nbsp;|\<br(\s*?\/)*?\>)*?\<\/p[^>]*?\>/si";
	  $replace = "";
	  $result = preg_replace($regex, $replace, $string);
	  return $result;
	} 
	
	public function createRandom($number_of_digits=1,$type=3){
    /* generate random strings */
    /* type: 1 - numeric, 2 - letters, 3 - mixed */
	$num = "";
	$r = ""; 
    for($x=0;$x<$number_of_digits;$x++){
        while(substr($num,strlen($num)-1,strlen($num)) == $r){
            switch($type){
                case "1":
                $r = rand(0,9);
                break;
               
                case "2":
                $r = chr(rand(0,25)+65);
                break;
               
                case "3":
                if(is_numeric(substr($num,strlen($num)-1,strlen($num)))){
                 $n = rand(0,999);
                 if($n % 2){
                    $r = chr(rand(0,25)+65);
                } else {
                    $r = strtolower(chr(rand(0,25)+65));
                }                    
                } else {
                 $r = rand(0,9);   
                }               
                break;
                }           
        } 
        $num .= $r;
    }
    return $num;
}
   
}

?>
