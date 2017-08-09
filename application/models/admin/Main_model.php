<?php 
class Main_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function backup()
	{
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup();

		// Load the file helper and write the file to your server
		//$this->load->helper('file');
		//$date = date("ymd");
		//write_file("backup/backup".$date.".gz", $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download("backup.sql", $backup); 		
		return true;
	}
	
	public function export_csv($query)
	{
		// Load DB utility class
		$this->load->dbutil();
		// Set delimiter and new line
		$delimiter = ",";
		$newline = "\r\n";

		// put result into a variable
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline); 
		$this->load->helper('download');
		force_download("product.csv", $data); 	
	}
	
}//end class


?>