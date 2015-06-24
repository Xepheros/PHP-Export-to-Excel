<?php
	/**	 
     * PHP Export to Excel - DBFunction
     * ==================================================
     * Author : Thanadon X Songsuittipong
     * ==================================================
     * using PHPExcel Libraries 
     * Available at http://phpexcel.codeplex.com/
     */
	function db_connect() {
		// ===== Database Configuration =====
			$host = 'localhost';
			$dbuser = 'root';
			$dbpass = '';
			$dbname = '';
		// ==================================
		$db = new mysqli($host, $dbuser, $dbpass, $dbname);
		if ($db->connect_errno) {
			echo "Failed to connect to MySQL: " . $db->error;
			exit();
		}	
		$db->query("SET NAMES UTF8");
		return $db;

	}
	function get_data($q='') {

		$db = db_connect();
		$condition = "";
		if( (isset($q)) && ($q != '') ) {
			$condition .= " WHERE memberID='$q'";
		}
		$sql = "SELECT memberID,username,fullname,lastexport FROM member".$condition;
		$result = $db->query($sql);
		if($result) {
			return $result;
		}
	}
	function update_lastexport($q='',$now='') {
		$db = db_connect();
		
		$sql = "UPDATE member SET lastexport = '$now' WHERE memberID = '$q'";
		$result = $db->query($sql);
		if(!$result) {
			die('Cannot Update Last Export');
		}
	}

?>