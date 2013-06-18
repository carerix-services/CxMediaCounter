<?php
/**
 * Abstract class used to allow the model to be stored in a sqlite DB. 
 * @author Jasper Stafleu
 */
abstract class SQLiteObject {
	/**
	 * Default date format with which to store dates in the DB
	 * 
	 * @var string
	 */
	const DateFormat = DateTime::ISO8601;
	
	/**
	 * The static PDO object created by DBConnect
	 * 
	 * @var PDO
	 */
	public static $_pdo = null;

	/**
	 * Static array holding existing table names
	 * 
	 * @var strings[]
	 */
	protected static $_tables = array();
	
	/**
	 * Holds the current ISO8601 timestamp
	 * 
	 * @var string
	 */
	protected static $_now = null;
	
	/**
	 * Location of the lock on the disk. Will be set by setLockLoc()
	 * 
	 * @var string	path/to/loc
	 */
	private static $_lockLoc = '';
	
	/**
	 * Creates the SQL lite DB as based upon the SQLLiteObject's field array
	 */
	protected function _createDB() {
		$fields = $this->getModel();
		if ( empty($fields) ) {
			throw new Exception('No fields definition found');
		}
		
		$columnDefs = array();
		foreach ( $fields as $property => $definition ) {
			$columnDef = "`{$property}` {$definition->type}";
			if ( !empty($definition->constraint) ) {
				$columnDef .= " {$definition->constraint}";
			}
			$columnDefs[] = $columnDef; 
		} // foreach
		
		$create = "CREATE TABLE IF NOT EXISTS " . get_class($this) . " (" . implode(", ", $columnDefs) . ")";
		if ( self::$_pdo->query($create) ) {
			self::$_tables[] = get_class($this);
		} else {
			$err = self::$_pdo->errorInfo();
			throw new Exception("PDO Error while creating table " . get_class($this) . ": " . $err[2]);
		}
	} // _createDB();
	
	/**
	 * Retrieves a (static) current ISO8601 timestamp for consistent use in the DB
	 * 
	 * @param string $refresh	If set to true (default), this will generate a new 
	 * 												timestamp; the previous timestamp will used otherwise
	 * @return string
	 */
	public static function getNow($refresh = true) {
		if ( $refresh || empty(self::$_now) ) {
			$now = new DateTime();
			$now->setTimezone(new DateTimeZone('GMT'));
			self::$_now = $now->format(SQLiteObject::DateFormat);
		}
		return self::$_now;
	} // getNow();
	
	/**
	 * Creates the available fields and fills their values. Available only once.
	 */
	private final function _setDefaults() {
		foreach ( $this->getModel() as $property => $definition ) {
			if ( !property_exists($this, $property) ) {
				$this->$property = isset($definition->default) ? $definition->default : null;
			}
		} // foreach
	} // _setDefaults();
	
	/**
	 * Construct the object by looking for its DB and creating it if absent
	 */
	public function __construct() {
		// if not yet available: reference the PDO instance
		if ( self::$_pdo === null ) {
			self::$_pdo = self::getPDO();
		}
		
		// if not yet available: determine the tables that are currently available
		if ( empty(self::$_tables) ) {
			foreach(self::$_pdo->query("SELECT name FROM sqlite_master") as $row ) {
				self::$_tables[] = $row['name'];
			} // foreach
		}
		
		// if this class does not have a table yet, create it
		if ( !in_array(get_class($this), self::$_tables) ) {
			$this->_createDB();
		}
		
		self::setLockLoc();
		
		// set the defaults for this object
		$this->_setDefaults();
	} // __construct();
	
	/**
	 * Ensures the lock location is set.
	 */
	public static function setLockLoc() {
		if ( empty(self::$_lockLoc) ) {
			self::$_lockLoc = ROOTDIR . 'db/.dblock';
		}
	} // setLockLoc();
	
	/**
	 * Write the lock file. While the loc file exists, nothing is done, but once
	 * the file no longer exists, it is created and a shutdown function is added.
	 */
	public static function lock() {
		self::setLockLoc();
		
		$it = 1;
		while ( is_file(self::$_lockLoc) ) {
			sleep(1);
			if ( ++$it > 1000 ) {
				// if you're already waiting 1000 iterations, perhaps something went 
				// wrong with unlocking in a previous iteration. Therefore: unlock it 
				// and continue anyways. Even computers have a limit to patience...
				self::unlock();
				break;
			}
		}
		touch(self::$_lockLoc);
		new ShutDownClass;
	} // lock();
	
	/**
	 * Remove the lock file. Semantically, this means a new lock can be obtained,
	 * and thus the proces is "unlocked"
	 */
	public static function unlock() {
		self::setLockLoc();
		if ( is_file(self::$_lockLoc) ) {
			unlink(self::$_lockLoc);
		}
	} // unlock();
	
	/**
	 * Returns the PDO isntance
	 * 
	 * @return PDO
	 */
	public static function getPDO() {
		return self::$_pdo ? self::$_pdo : DBConnect::getPDO();
	} // getPDO
	
	/**
	 * Store the object into the DB, retrieving and setting it's AI key if needed 
	 */
	public function store() {
		// retrieve the fields and values of $this as per the public non-static 
		// and properties and store them and their values for later use
		$fields = $values = array();
		foreach ( $this->getModel() as $property => $loos ) {
			$fields []= $property;
			$values [$property] = $this->$property;
		} // foreach
		
// 		$refl = new ReflectionObject($this);
// 		foreach ( $refl->getProperties(ReflectionProperty::IS_PUBLIC) as $prop ) {
// 			if ( $prop->isStatic() ) continue;
// 			$fields []= $prop->name;
// 			$values [$prop->name]= $prop->getValue($this);
// 		} // foreach

		// create the INSERT query as per the fields and values gathered above
		$sql = "INSERT OR REPLACE INTO " . get_class($this)
						. " (`" . implode("`, `", $fields) . "`) "
						. " VALUES (:" . implode(", :", $fields) . ")";
		
		// prepare the statement and bind it's values
		if ( !($stmt = self::$_pdo->prepare($sql)) ) {
			$err = self::$_pdo->errorInfo();
			throw new Exception("PDO Error preparing statement for " . get_class($this) . ": " . $err[2]);
		}
 		foreach ( $values as $field => $value ) {
 			$stmt->bindValue(':'.$field, $value);
 		} // foreach
 		
 		// execute the statement and be verbose about its errors
 		if ( !$stmt->execute() ) {
 			$err = self::$_pdo->errorInfo();
 			throw new Exception("PDO Error while executing " . get_class($this) . "::store() : " . $err[2]);
 		}
 		
 		$stmt->closeCursor();
 		
 		// retrieve the newly created object's AI key
 		$this->id = self::$_pdo->lastInsertId();
	} // store();
	
} // SQLLiteObject();

/**
 * Since register_shutdown_function doesn't appear to work on the Carerix server,
 * this should "fake" it. 
 * @author Reserve 1
 *
 */
class ShutDownClass {
	/**
	 * All instances of the shutdown class need to be stored in order to ensure
	 * PHP's garbage collector only collects them once the entire script has been
	 * executed.
	 * 
	 * @var ShutDownClass[]
	 */
	private static $_instances = array();
	
	/**
	 * Constructor: write the instance.
	 */
	public function __construct() {
		self::$_instances[] = $this;
	} // __construct();
	
	/**
	 * Destructor: called once the script execution ends (due to each instance 
	 * being stored in the $_instances array).
	 */
	public function __destruct() {
		SQLiteObject::unlock();
	} // __destruct();
	
} // end class ShutDownClass();
