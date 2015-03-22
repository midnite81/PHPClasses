<?php 

class Validate { 
	
  public function chkValid($str,$min='',$max='',$regex='',$attr='') {

		if (is_numeric($min) and $min <> "") { 
			if (strlen($str) < $min) return false;            
		}
		if (is_numeric($max) and $max <> "") {
			if (strlen($str) > $max) return false; 
		}
		if ($regex != "") {
			if (!preg_match($regex,$str)) return false; 
		}
		if ($attr == 'email') { 
			if (!preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',$str)) return false; 
		}
		
		if ($attr == 'url') { 
			if (!preg_match('/^http:\/\//',$str)) return false; 
		}
		
		if ($attr == 'numeric') { 
			if (!is_numeric($str)) return false; 
		}
		
		if ($attr == 'date') { 
		if (!preg_match('/^([0-9]{4})-([0]{1}[1-9]{1}|[1]{1}[0-2]{1})-([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-2]{1})$/',$str,$datearray)) {
					return false; 
				   }
		 if(!checkdate($datearray[2],$datearray[3],$datearray[1])) {
					 return false ;
		 }
		}
		
		return true;
	}
	
	public function isPhone($str) { 
		$regex = "/^((\(?0\d{4}\)?\s?\d{3}\s?\d{3})|(\(?0\d{3}\)?\s?\d{3}\s?\d{4})|(\(?0\d{2}\)?\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/";
		return $this->chkValid($str,null,null,$regex); 			
	} 
	
	public function isEmail($str) { 
		return $this->chkValid($str,null,null,null,'email'); 
	} 
	
	public function isPostCode($str) { 	
		$regex = "/^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/";
		return $this->chkValid($str,null,null,$regex);
	} 
	
	public function isNumber($str) { 
		return $this->chkValid($str,null,null,null,'numeric'); 
	} 
	
	public function isDate($str) { 
		return $this->chkValid($str,null,null,null,'postcode');
	} 
	
	public function isURL($str) { 
		$regex = "/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/";
		return $this->chkValid($str,null,null,$regex);
	} 
	
	public function isMin($str,$num) { 
		return $this->chkValid($str,$num);
	} 
	
	public function isMax($str,$num) { 
		return $this->chkValid($str,null,$num);
	} 
	
	public function isNationalInsureance($str) { 
		$regex = "/^[A-Za-z]{2}[0-9]{6}[A-Za-z]{1}$/";
		return $this->chkValid($str,null,null,$regex);
	} 
	
	public function isUkBankSortCode($str) { 
		$regex = "/^[0-9]{2}[-][0-9]{2}[-][0-9]{2}$/";
		return $this->chkValid($str,null,null,$regex); 
	} 

} 
?>