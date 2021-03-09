<?php    
    /**
	 * PostgreSQL PHP basic library
	 * This library allows operations between PostgreSQL's Database and PHP web clients.
	 * Included functions in this class can be used to connect/disconnect/query Db.
	 * Requires: appsettings.xml file with the database configuration info.  
	 * PHP version >=7 and 
	 *
	 * @author     Eduardo Oliveira <eduardo.oliveira@ieee.org>
	 * @version    0.0.2
	 */

	class Database {

        // Database conection
		private $conn;
		private $connection_str;

		/** 
		 * Constructor: Connection to the POSTGRESQL DB
		*/
		public function __construct() 
		{
			// Set database connection configuration
			$this->set_db_config();

			// Provide access to the DB - POSTGRESQL
			try
			{
				$this->conn = pg_connect($this->connection_str); 
			}
			catch(Exception $error)
			{
				throw new Exception(pg_last_error(), 10).$error->getMessage();
			}
		}

		/**
		 *  Set DB configuration values 
		*/
		private function set_db_config() : void
		{
			// Load the appsettings file
			$xml = new DOMDocument;
			$path = $_SERVER['DOCUMENT_ROOT'].'./_engine/appsettings.xml';
			$xml->load($path) or die("Error: Cannot create object");

			//Get the connection string
			$xpath = new DOMXPath($xml);
			$query = "/Database/Setting[@AdapterPath='PostgreSQL']";
			
			// Set the connection
			$this->connection_str = $xpath->query($query)->item(0)->getAttribute('ConnectionString');

			return;
		}

        /**
		 *  Close connection to POSTGRESQL DB 
		*/
		public function close()
		{
			return pg_close($this->conn);
		}
        
        /** 
		 * Get DB connection status
		 */
        public function connection()
        {
            return $this->conn;
		}
		
		/** 
		 * Escape a string for query
		 * @string: A string containing text to be escaped.
		 * returns: A string containing the escaped data.
		 */
		public function escape_seq($string) 
		{
			return pg_escape_string($this->connection(), $string);
		}

		/** 
		 * Returns the number of rows in a result
		 * @stmt: PostgreSQL query result resource, returned by pg_query(), pg_query_params() or pg_execute() (among others).
		 * returns: The number of rows in the result. On error, -1 is returned.
		 */
		public function get_num_rows($stmt) 
		{
			return pg_num_rows($stmt);
		}

		/** 
		 * Fetch a row as an associative array
		 * @stmt[]: PostgreSQL query result resource, returned by pg_query(), pg_query_params() or pg_execute() (among others).
		 * returns: An array indexed associatively (by field name). Each value in the array is represented as a string. Database NULL values are returned as NULL.
		 */
		public function fetch_assoc($stmt) 
		{
			return pg_fetch_assoc($stmt);
		}

		/** 
		 * Get a row as an enumerated array
		 * @stmt[]: PostgreSQL query result resource, returned by pg_query(), pg_query_params() or pg_execute() (among others).
		 * returns: An array, indexed from 0 upwards, with each value represented as a string. Database NULL values are returned as NULL.
		 */
		public function fetch_row($stmt) 
		{
			return pg_fetch_row($stmt);
		}

		/** 
		 * Insert a new row into the predefined database table 
		 * @query: Query string
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function insert_new_row($query)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Query database
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}

		/** 
		 * Delete a row into the predefined database table, by ID
		 * @query: Query string
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function delete_row($query)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Query database
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}
		
		/** 
		 * Update row into the predefined database table 
		 * @query: Query string
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function update_row($query)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Query database
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}

		/** 
		 * Select row into the predefined database table 
		 * @query: Query string
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function get_row($query)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Query database
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}
    }
?>