<?php
class DbVisit extends SQLiteObject {
	/**
	 * Holder of the prepared statements. Should speed up the DB connection.
	 */
	protected static $_preparedStatements = array();
	
	/**
	 * Returns the field types for this object
	 * 
	 * @return multitype:StdClass
	 */
	public function getModel() {
		$class = __CLASS__;
		return array(
				'id' => (object) array(
						'type' => 'INTEGER',
						'constraint' => 'PRIMARY KEY AUTOINCREMENT',
						'description' => "Unique id of the {$class}",
				),
				'creation' => (object) array(
						'type' => 'TEXT',
						'default' => SQLiteObject::getNow(false),
						'realtype' => 'datetime',
						'description' => "When was the {$class} created",
				),
				'app' => (object) array(
						'type' => 'TEXT',
						'description' => "The customer's APP for this {$class}.", 
				),
				'exportcode' => (object) array(
						'type' => 'TEXT',
						'description' => "The exportcode that the created CRToDo must hold to",						
				),
				'customer' => (object) array(
						'type' => 'TEXT',
						'description' => "The customer name for this {$class}",	
				),
				'campaign' => (object) array(
						'type' => 'TEXT',
						'description' => "The campaign name for this {$class}", 	
				),
				'publication' => (object) array(
						'type' => 'INTEGER',
						'description' => "The publication ID for this {$class}",
				),
				'vacancy' => (object) array(
						'type' => 'INTEGER',
						'description' => "The vacancy ID for this {$class}",
				),
				'employee' => (object) array(
						'type' => 'INTEGER',
						'description' => "The employeeID for this {$class}",
				),
				'contact' => (object) array(
						'type' => 'INTEGER',
						'description' => "The employeeID for this {$class}",
				),
				'checksum' => (object) array(
						'type' => 'TEXT',
						'description' => "The checksum for this {$class}",
				),
				'email' => (object) array(
						'type' => 'INTEGER',
						'description' => "The ID of the corresponding mail for this {$class}",
				),
				'subject' => (object) array(
						'type' => 'STRING',
						'default' => empty($_REQUEST['subject']) ? null : $_REQUEST['subject'], 
				),
				'type' => (object) array(
						'type' => 'TEXT',
						'description' => "The type of the {$class}; used in handling how to send to CX",
				),
				'redirect' => (object) array(
						'type' => 'TEXT',
						'default' => '',
						'description' => "When the {$class} was created, this is where the user was redirected to",
				),
				'synchronise_started' => (object) array(
						'type' => 'TEXT',
						'realtype' => 'datetime',
						'description' => "Time when the {$class} synchronisation with CX was started",
				),
				'synchronise_finished' => (object) array(
						'type' => 'TEXT',
						'realtype' => 'datetime',
						'description' => "Time when the {$class} synchronisation with CX was completed",
				),
				'synchronise_error' => (object) array(
						'type' => 'TEXT',
						'description' => "Error given when synchronisation with CX was attempted. This result should coincide with a started date, but no finished date",
				),
				'activity' => (object) array(
						'type' => 'INTEGER',
						'default' => '',
						'description' => 'The id of the activity created during synchronisation',
				),
				'fullUri' => (object) array(
						'type' => 'TEXT',
						'default' => $_SERVER['REQUEST_URI'],
						'description' => "Full URI for the action that created the {$class}",
				),
				'ip' => (object) array(
						'type' => 'TEXT',
						'default' => $_SERVER['REMOTE_ADDR'],
					'description' => 'The IP of the user creating the activity',
				),
				'env' => (object) array(
						'type' => 'TEXT',
						'default' => var_export($_SERVER, 1),
						'description' => 'The $_SERVER array during creation',
				),
		);
	} // getFields();

	/**
	 * Returns a visit that has not been handled yet (synchronise_started is null)
	 */
	public static function getUnhandledVisit() {
 		self::lock();
		if ( empty(self::$_preparedStatements[__FUNCTION__]) ) {
			$sql = "SELECT * FROM " . get_class() . " WHERE synchronise_started IS NULL LIMIT 1";
			self::$_preparedStatements[__FUNCTION__] = self::getPDO()->prepare($sql);
		}
		if ( !self::$_preparedStatements[__FUNCTION__]->execute() ) {
			$err = self::getPDO()->errorInfo();
			throw new Exception("PDO Error while obtaining unhandled " . get_class() . ": " . $err[2]);
		}
		
		$res = self::$_preparedStatements[__FUNCTION__]->fetchObject(get_class());
		self::$_preparedStatements[__FUNCTION__]->closeCursor();
		return $res;
	} // getUnhandledVisit();
} // end class DbVisit