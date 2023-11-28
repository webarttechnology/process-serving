<?php

class MySQL_class
{
    var $db, $id, $result, $rows, $data, $a_rows;
    var $user, $pass, $host, $port, $lastid;

    /* Make sure you change the USERNAME and PASSWORD to your name and
    * password for the DB
    */

    function Setup($user, $pass, $host, $port)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->host = $host;
        $this->port = $port;
    }

    function Create($db)
    {
        if (!$this->user) {
            $this->user = "countrywideproce_cwprocess";
        }
        if (!$this->pass) {
            $this->pass = "^U-6m5fCQ}Ks";
        }
        if (!$this->host) {
            $this->host = "localhost";
        }

$this->db ="$db";
     $this->id = mysqli_init();
if (!$this->id){
MySQL_ErrorMsg("Init Fail.");
}
/* $connect=mysqli_real_connect($this->id, $this->host, $this->user, $this->pass, $db,3306,"",MYSQLI_CLIENT_COMPRESS) or MySQL_ErrorMsg("Unable to connect to MySQL server: $this->host : '$SERVER_NAME'");
 
        $this->selectdb($db);
    } */
      $this->db = "$db";
       $this->id = @mysqli_connect($this->host, $this->user, $this->pass, $db) or
            MySQL_ErrorMsg(mysqli_connect_error() . " " . $this->host);
		 $sSQL= 'SET CHARACTER SET utf8'; 
		@mysqli_query($this->id ,$sSQL);
        $this->selectdb($db);
   }

    function SelectDB($db)
    {
        $conn=@mysqli_select_db($this->id, $db) or MySQL_ErrorMsg("Unable to select database: $db");
		
    }

    # Use this function is the query will return multiple rows.  Use the Fetch
    # routine to loop through those rows.
    function Query($query)
    {
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform query: $query");
        $this->rows = @mysqli_num_rows($this->result);
        $this->a_rows = @mysqli_affected_rows($this->result);
    }

    # Use this function if the query will only return a
    # single data element.
    function QueryItem($query)
    {
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform query: $query -- " .
            $this->host);
        $this->rows = @mysqli_num_rows($this->result);
        $this->a_rows = @mysqli_affected_rows($this->result);
        $this->data = @mysqli_fetch_array($this->result) or MySQL_ErrorMsg("Unable to fetch data from query: $query -- " .
            $this->host);
        return ($this->data[0]);
    }

    # This function is useful if the query will only return a
    # single row.
    function QueryRow($query)
    {
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform query: $db: $query");
        $this->rows = @mysqli_num_rows($this->result);
        $this->a_rows = @mysqli_affected_rows($this->result);
        $this->data = @mysqli_fetch_array($this->result, MYSQLI_ASSOC) or MySQL_ErrorMsg("Unable to fetch data from query: $query -- " .
            $this->host);
        return ($this->data);
    }

    function Fetch($row)
    {
        @mysqli_data_seek($this->result, $row) or MySQL_ErrorMsg("Unable to seek data row: $row");
        $this->data = @mysqli_fetch_array($this->result) or MySQL_ErrorMsg("Unable to fetch row: $row");
    }


    function FetchA($row)
    {
        @mysqli_data_seek($this->result, $row) or MySQL_ErrorMsg("Unable to seek data row: $row");
        $this->data = @mysqli_fetch_array($this->result, MYSQLI_ASSOC) or MySQL_ErrorMsg("Unable to fetch row: $row");
    }
    function Insert($query)
    {
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform insert: $query");
        $this->a_rows = @mysqli_affected_rows($this->id);
		return $this->a_rows;
    }
    
	function InsertA($query)
    {
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform insert: $query");
        $this->a_rows = @mysqli_affected_rows($this->id);
		$this->lastid	= @mysqli_insert_id($this->id);
		return $this->lastid;
    }
       function UpdateA($query)
    {
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform update: $query");
        $this->a_rows = @mysqli_affected_rows($this->result);
   

 }


    function Update($query)
    {	
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform update: $query");
        $this->a_rows = @mysqli_affected_rows($this->id);
		return $this->a_rows;
    }

    function Delete($query)
    {
        $this->result = @mysqli_query($this->id, $query) or MySQL_ErrorMsg("Unable to perform Delete: $query");
        $this->a_rows = @mysqli_affected_rows($this->result);
		return 1;
    }
	
	public function paramEncode($data)
	{
		$encfirst = str_rot13($data);
		$encsecnd = base64_encode(convert_uuencode($encfirst));
		$encdata = urlencode($encsecnd);
		return $encdata;
	}
	
	
}

/* ********************************************************************
* MySQL_ErrorMsg
*
* Print out an MySQL error message
*
*/

 function MySQL_ErrorMsg($msg)
{
    # Close out a bunch of HTML constructs which might prevent
    # the HTML page from displaying the error text.
    /* echo("</ul></dl></ol>\n"); */
    /* echo("</table></script>\n"); */

    # Display the error message
     $text = "<font color=\"#ff0000\" size=+2><p>Error: $msg :";
    $text .= mysqli_error();
    $text .= "</font>\n"; 
// echo ("$text");


//    $fp = fopen("utila.log", "a");
//    fputs($fp, $text);
 //   fclose($fp);

} 
?>
