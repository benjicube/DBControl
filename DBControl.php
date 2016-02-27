<?php
/*

DBControl V 0.1
Lightweight mysqli-db-class 
- Features basic errorreporting
Jesper Lykke Lisby (jexpo.dk)
26.02.2016

Methods:
--------------
* Connect()
* Open() ~
* Query()
* ConnectAndQuery()
* Disconnect()
* Close() ~

*/

class DBControl 
{

	protected $configFile;

	/*  (Init)
		-----------------
		Override configfile: $DBcontrol = new DBControl("customconfig.php"); */

	public function __construct( $configoverride = null ) 
	{
		// No leaking of warnings
		error_reporting(0);
		
		// Database config file (default)
		$this->configFile = "DBControl-config.php";

		// Configfile parameter override
		if ($configoverride) { $this->configFile = $configoverride; }
	}



	/*  Connect
		-----------------
		@param $changedb (string)
		USAGE:
		$DBcontrol = new DBControl();
		$link = $DBcontrol->Connect(); <-- creates connection object $link  */

	public function Connect ( $changedb = null ) 
	{
		if (!file_exists($this->configFile)) { die("Database error: Configuration file not found"); }
		require $this->configFile;

		if ($changedb) { $thedatabase = $changedb; }
		else { $thedatabase = $db_name; }

		$conn = mysqli_connect($db_host, $db_user, $db_pass, $thedatabase);

		if (!$conn) { die("Database error: Connection failed"); } 
		else { 
			mysqli_set_charset($conn, "utf8");
			$this->connection = $conn; 
			return $this->connection; // Return connection object
		}
	}



	/*  Open
		-----------------
		Alias to Connect() */

	public function Open ( $changedb = null ) 
	{
		return $this->Connect($changedb);
	}




	/*  Query
		-----------------
		@param $sql (string)
		@param $conn (connection object)
		USAGE: $DBcontrol->Query(query, connection) */

	public function Query ( $sql, $conn ) 
	{
		$query_result = $conn->query($sql);

		if (!$query_result) { die("Database error: Invalid SQL query"); }

		if ($query_result->num_rows > 0) {
			mysqli_real_escape_string($conn, $sql); // Sanitizing
			return $conn->query($sql); // Return query object
		} 
		else {
		    die("Database error: No query results");
		}
		
	}




	/*  ConnectAndQuery
		----------------
		@param $sql (string)
		@param $changedb (string)
		Establishes connection and executes given query, then disconnects.
		USAGE: $DBcontrol->ConnectAndQuery(query, database) */

	public function ConnectAndQuery ( $sql, $changedb = null ) 
	{
		if (!file_exists($this->configFile)) { die("Database error: Configuration file not found"); }
		require $this->configFile;

		if ($changedb) {	$thedatabase = $changedb; }
		else { $thedatabase = $db_name; }

		$conn = mysqli_connect($db_host, $db_user, $db_pass, $thedatabase);

		if (!$conn) { die("Database error: Connection failed"); }
		else {
			$result = $conn->query($sql);

			if (!$result) { die("Database error: Invalid SQL query"); }

			if ($result->num_rows > 0) {
				mysqli_set_charset($conn, "utf8"); // Charset
				mysqli_real_escape_string($conn, $sql); // Sanitizing
				return $conn->query($sql); // Return result
			} 
			else {
			    die("Database error: No query results");
			}
			mysqli_close($conn) or die("Database error: Connection could not be closed. Perhaps already closed?");
		}
	}




	/* 	Disconnect
		-----------------
		@param $conn (connection object)
		USAGE: $DBcontrol->Disconnect(dlink) */

	public function Disconnect ( $conn ) 
	{
		mysqli_close($conn) or die("Database error: Connection could not be closed. Perhaps already closed?");
	}




	/*  Close
		-----------------
		Alias to Disconnect() */

	public function Close ( $conn ) 
	{
		return $this->Disconnect($conn);
	}



} // End class DBControl()

?>