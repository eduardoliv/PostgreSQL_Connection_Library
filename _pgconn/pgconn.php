<?php    
    /**
	 * PostgreSQL PHP basic library
	 *
	 * This library allows communication between a server-side PostgreSQL Database and PHP web application.
	 * 
	 * Included functions in this class can be used to connect/disconnect from the DB or Query.
	 * 
	 * Requires: config.php file with the database configuration data.  
	 * 
	 * PHP version 7
	 *
	 * @author     Eduardo Oliveira <eduardo.oliveira@ieee.org>
	 * @copyright  IPCA-EST. All rights reserved.
	 * @version    SVN: 0.0.1
	 */
    
	class PostgreSQLConn {

        // Database conection
		private $dbhost, $dbport, $dbuser, $dbpass, $dbname, $charset, $conn;

		/** 
		 * Constructor: Connect to the PostgreSQL DB
		*/
		public function __construct() 
		{
			// Set database connection configuration
			$this->set_db_config();

			// Provide access to the DB - PostgreSQL
			try
			{
				$this->conn = pg_connect("host=$this->dbhost port=$this->dbport dbname=$this->dbname user=$this->dbuser password=$this->dbpass options='--client_encoding=$this->charset'"); 
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
			// Require the config file
			require_once './config.php';

			// Set Property Value
			$this->dbhost = DB_HOST;
			$this->dbport = DB_PORT;
			$this->dbuser = DB_USER;
			$this->dbpass = DB_PASS;
			$this->dbname = DB_NAME;
			$this->charset = CHARSET;

			return;
		}

        /**
		 *  Close connection
		*/
		public function close()
		{
			return pg_close($this->conn);
		}
        
        /** 
		 * Get connection status
		 */
        public function connection()
        {
            return $this->conn;
		}
		
		/** 
		 * Escape string
		 * @string: A string containing text to be escaped.
		 * returns: A string containing the escaped data.
		 */
		public function escape_seq($string) 
		{
			return pg_escape_string($this->connection(), utf8_encode($string));
		}

		/** 
		 * Will return the number of rows in a PostgreSQL result resource.
		 * @query: PostgreSQL query result resource, returned by pg_query(), pg_query_params() or pg_execute() (among others).
		 * returns: The number of rows in the result. On error, -1 is returned.
		 */
		public function get_num_rows($query) 
		{
			return pg_num_rows($query);
		}

		/** 
		 * Fetch a row as an associative array
		 * @query[]: PostgreSQL query result resource, returned by pg_query(), pg_query_params() or pg_execute() (among others).
		 * returns: An array indexed associatively (by field name). Each value in the array is represented as a string. Database NULL values are returned as NULL.
		 */
		public function fetch_assoc($query) 
		{
			return pg_fetch_assoc($query);
		}

		/** 
		 * Get a row as an enumerated array
		 * @query[]: PostgreSQL query result resource, returned by pg_query(), pg_query_params() or pg_execute() (among others).
		 * returns: An array, indexed from 0 upwards, with each value represented as a string. Database NULL values are returned as NULL.
		 */
		public function fetch_row($query) 
		{
			return pg_fetch_row($query);
		}

		/** 
		 * Insert a new row into the predefined database table 
		 * @table: DB table to insert the row
		 * @fields: Fields of the table
		 * @values: Values of the fields
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function insert_new_row($table, $fields, $values)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Syntax check
			$fields = preg_replace('/`/', '"', $fields);
			$values = preg_replace('/"/', '\'', $values);

			// Create string with query args
			$query = sprintf('INSERT INTO %s (%s) VALUES (%s);', $table, $fields, $values);

			// Query db
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}

		/** 
		 * Delete a row into the predefined database table, by ID
		 * @table: DB table to delete row
		 * @where: Primary key field name and value (or others)
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function delete_row($table, $where)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Create string with query args
			$query = sprintf('DELETE FROM %s WHERE %s;', $table, $where);

			// Query database
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}
		
		/** 
		 * Update row into the predefined database table 
		 * @table: DB table to update row
		 * @fields: Fields of the table
		 * @where: Primary key field name and value (or others)
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function update_row($table, $fields, $where)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Create string with query args
			$query = sprintf('UPDATE %s SET %s WHERE %s;', $table, $fields, $where);

			// Query database
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}

		/** 
		 * Select row into the predefined database table 
		 * @table: DB table to select row
		 * @fields: Fields of the table
		 * @where: Primary key field name and value (or others)
		 * returns: A query result resource on success or FALSE on failure.  
		 */
		public function get_row($table, $fields, $where)
		{
			// Check connection
			if (pg_last_error($this->connection())) exit(pg_last_error($this->connection()));

			// Create string with query args
			$query = sprintf('SELECT %s FROM %s WHERE %s;', $fields, $table, $where);

			// Query database
			$result = pg_query($this->connection(), $query);

			// Return result
			return $result;
		}
	}
?>