<?php 

class DB{
	private static $_instance = null;
	private $conn;
			
	private function __construct()
	{
		try {
			$this ->conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}
	
	public static function getInstance() : DB
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	/* Getter section */

	public function get_entry( string $table, int $entry_id ) : ?object // Get using id
	{
		$query="SELECT * FROM {$table} WHERE id = ? LIMIT 0,1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$entry_id);
		$stmt->execute();
		return ( $stmt->rowCount() ) ? $stmt->fetch(PDO::FETCH_OBJ) : null;
	}

	public function get_entries( string $table ) : array
	{
		$query="SELECT * FROM {$table} WHERE 1";
		$stmt=$this->conn->prepare($query);
		$stmt->execute();

		$entries = [];

		if ( $stmt->rowCount() ) {
            while ( $entry = $stmt->fetch(PDO::FETCH_OBJ) ){
              array_push($entries, $entry );
            }
        }

		return $entries;
	}

	public function get_entry_field( string $table, int $entry_id, string $field )
	{
		$query="SELECT {$field} FROM {$table} WHERE id = ? LIMIT 0,1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$entry_id);
		$stmt->execute();
		return ( $stmt->rowCount() ) ? $stmt->fetch(PDO::FETCH_ASSOC)[$field] : null;
	}

	public function find_entry( string $table, string $field, $value ) : ?object // Get using field and value
	{
		$query="SELECT * FROM {$table} WHERE {$field} = ? LIMIT 0,1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$value);
		$stmt->execute();
		return ( $stmt->rowCount() ) ? $stmt->fetch(PDO::FETCH_OBJ) : null;
	}

	public function get_relational_entries( string $table, string $relation_field, $relation_value ) : array
	{
		$query="SELECT * FROM {$table} WHERE {$relation_field} = ?";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$relation_value);
		$stmt->execute();

		$entries = [];

		if ( $stmt->rowCount() ) {
            while ( $entry = $stmt->fetch(PDO::FETCH_OBJ) ){
              array_push($entries, $entry );
            }
        }

		return $entries;
	}

	public function get_multikey_relational_entries( string $table, array $relation_fields, $relation_value ) : array
	{
		$query="SELECT * FROM {$table} WHERE {$relation_fields[0]} = ? OR {$relation_fields[1]} = ?";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$relation_value);
		$stmt->bindValue(2,$relation_value);
		$stmt->execute();

		$entries = [];

		if ( $stmt->rowCount() ) {
            while ( $entry = $stmt->fetch(PDO::FETCH_OBJ) ){
              array_push($entries, $entry );
            }
        }

		return $entries;
	}

	public function get_multikey_relational_entry( string $table, array $fields, array $test_values ) : ?object
	{
		$query="SELECT * FROM {$table} WHERE ( {$fields[0]} = ? AND {$fields[1]} = ? ) OR ( {$fields[0]} = ? AND {$fields[1]} = ? ) LIMIT 0,1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$test_values[0]);
		$stmt->bindValue(2,$test_values[1]);
		$stmt->bindValue(3,$test_values[1]);
		$stmt->bindValue(4,$test_values[0]);
		$stmt->execute();
		return ( $stmt->rowCount() ) ? $stmt->fetch(PDO::FETCH_OBJ) : null;
	}

	public function entry_field_value_exists( string $table, string $field, $test_value ) : bool
	{
		$query="SELECT {$field} FROM {$table} WHERE {$field} = ? LIMIT 0,1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$test_value);
		$stmt->execute();
		return ( $stmt->rowCount() ) ? true : false;
	}

	public function multikey_entry_field_value_exists( string $table, array $fields, array $test_values ) : bool
	{
		$query="SELECT * FROM {$table} WHERE ( {$fields[0]} = ? AND {$fields[1]} = ? ) OR ( {$fields[0]} = ? AND {$fields[1]} = ? ) LIMIT 0,1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$test_values[0]);
		$stmt->bindValue(2,$test_values[1]);
		$stmt->bindValue(3,$test_values[1]);
		$stmt->bindValue(4,$test_values[0]);
		$stmt->execute();
		return ( $stmt->rowCount() ) ? true : false;
	}

	/* Add */
	public function add_entry( string $table, array $fields ) : ?object
	{
		$keys = array_keys($fields);

		$values = '';
		$x = 1;
		foreach ($fields as $field){
			$values .= '?';
			if ($x < count($fields)){
				$values .= ', ';
			}
			$x++;
		}

		$query = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

        $stmt=$this->conn->prepare($query);

		$x = 1;
		foreach($fields as $field){
			$stmt->bindValue($x, $field);
			$x++;
		}

		return ( $stmt->execute() ) ? $this->get_entry( $table , $this->conn->lastInsertId() ) : null;
	}

	/* Update */
	public function update_entry( string $table, int $entry_id, array $fields ) : ?object
	{
		$set = '';
		$x = 1;
		
		foreach($fields as $name => $value){
			$set .= "{$name} = ?";
			if ($x < count($fields)){
				$set .= ', ';
			}
			$x++;
		}
		
		$query = "UPDATE {$table} SET {$set} WHERE id = {$entry_id}";

		$stmt=$this->conn->prepare($query);

		$x = 1;
		foreach($fields as $field){
			$stmt->bindValue($x, $field);
			$x++;
		}

		return ( $stmt->execute() ) ? $this->get_entry( $table , $entry_id ) : null;
	}

	/* Delete */
	public function delete_entry( string $table, int $entry_id ): bool
	{
		$query="DELETE FROM {$table} WHERE id = ?";
		$stmt=$this->conn->prepare($query);
		$stmt->bindValue(1,$entry_id);
		return ( $stmt->execute() ) ? true : false;
	}
}