<?php

use Resource\Native\Objective;
use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

/**
 * The Database Class, extending from the PDO class and implementing Objective interface
 * It adds new features beyond PDO's capability, and implements the object's interface to be used in Collections.
 * @category Resource
 * @package Core
 * @author Fadillzzz
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not much at this point.
 *
 */

class Database extends PDO implements Objective{
    /**
     * Tables' prefix
     *
     * @access private
     * @var string
     */
    private $_prefix;

    /**
     * Keep track of total rows from each query
     *
     * @access private
     * @var array
     */
    private $_total_rows = array();

    /**
     * Stores join table
     *
     * @access private
     * @var array
     */
    private $_joins = array();

    /**
     * If you don't know what this is, you shouldn't be here
     *
     * @param string $dbname
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $prefix    Tables' prefix
     * @access public
     */
    public function __construct($dbname, $host, $user, $password, $prefix = 'adopts_'){
        parent::__construct('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password);
        $this->_prefix = $prefix;
    }
	
    /**
     * The equals method, checks whether target object is equivalent to this one.
     * @param Objective  $object	 
     * @access public
     * @return Boolean
     */
    public function equals(Objective $object){
        return ($this == $object);
    } 	

    /**
     * The getClassName method, returns class name of an instance. 
     * @access public
     * @return String
     */
    public function getClassName(){
        return new Mystring(get_class($this));
    }

	/**
     * The hashCode method, returns the hash code for the very Database.
     * @access public
     * @return Int
     */			
    public function hashCode(){
	    return hexdec(spl_object_hash($this));
    }

	/**
     * The serialize method, serializes this Database Object into string format.
     * @access public
     * @return String
     */
    public function serialize(){
        return serialize($this);
    }
   
    /**
     * The unserialize method, decode a string to its object representation.
	 * @param String  $string
     * @access public
     * @return String
     */
    public function unserialize($string){
        return unserialize($string);
    }	
	
    /**
     * Basic INSERT operation
     *
     * @param string $tableName
     * @param array  $data         A key-value pair with keys that correspond to the fields of the table
     * @access public
     * @return object 
     */
    public function insert($tableName, array $data){
        return $this->_query($tableName, $data, 'insert');
    }	
	
    /**
     * Basic UPDATE operation
     *
     * @param string $tableName
     * @param array  $data         A key-value pair with keys that correspond to the fields of the table
     * @access public
     * @return object 
     */
    public function update($tableName, array $data, $clause = NULL){
        return $this->_query($tableName, $data, 'update', $clause);
    }
	
	public function update_decrease($tableName, array $rows, $value, $clause = NULL){
        return $this->_query($tableName, $rows, 'update_decrease', $clause, $value);
	}

	public function update_increase($tableName, array $rows, $value, $clause = NULL){
        return $this->_query($tableName, $rows, 'update_increase', $clause, $value);
	}

    /**
     * Basic SELECT operation
     *
     * @param string $tableName
     * @param array  $data        A key-value pair with values that correspond to the fields of the table
     * @param string $clause    Clauses for creating advance queries with JOINs, WHERE conditions, and whatnot
     * @access public
     * @return object
     */
    public function select($tableName, array $data = array(), $clause = NULL){
        return $this->_query($tableName, $data, 'select', $clause);
    }

    /**
     * Basic DELETE operation
     *
     * @param string $tableName
     * @param string $clause    Clauses for creating advance queries with JOINs, WHERE conditions, and whatnot
     * @access public
     * @return object
     */
    public function delete($tableName, $clause = NULL){
        return $this->_query($tableName, array(), 'delete', $clause);
    }

    /**
     * Adds JOIN to the next SELECT operation
     *
     * @param string $tableName
     * @param string $cond
     * @access public
     * @return object
     */
    public function join($tableName, $cond){
        $this->_joins[] = array($tableName, $cond);
        return $this;
    }

    /**
     * Get total rows affected by previous queries
     *
     * @param int    $index
     * @return int
     */
    public function get_total_rows($index){
        if ($index < 0){
            return $this->_total_rows[count($this->_total_rows) + $index];
        }
        return $this->_total_rows[$index];
    }

    /**
     * Handles queries
     *
     * @param string $tableName
     * @param array  $data         A key-value pair with keys that correspond to the fields of the table
     * @param string $operation Defines what kind of operation we'll carry on with the database
     * @access private
     * @return object
     */
    private function _query($tableName, array $data, $operation, $clause = NULL, $value = NULL){
		if ( ! is_string($tableName)){
            throw new Exception('Argument 1 to ' . __CLASS__ . '::' . __METHOD__ . ' must be a string');
        }
 
        // added "update_decrease" and "update_increase" to this list
        if ( ! in_array($operation, array('insert', 'update', 'update_decrease', 'update_increase', 'select', 'select_distinct', 'delete'))){
            throw new Exception('Unknown database operation.');
        }
   
             // <new code>
        if(!$value) {
            $query = call_user_func_array(array(&$this, '_' . $operation . '_query'), array($tableName, &$data));
        }
        else {
            $query = call_user_func_array(array(&$this, '_' . $operation . '_query'), array($tableName, &$data, &$value));    
        }
              //</new code>
       
        if ( ! empty($clause)){
            $query .= ' WHERE ' . $clause;
        }
        //The comments can be removed for debugging purposes.
        //echo $query;
        $stmt = $this->prepare($query);
        $this->_bind_data($stmt, $data);
 
        if ( ! $stmt->execute()){
            $error = $stmt->errorInfo();
            throw new Exception('Database error ' . $error[1] . ' - ' . $error[2]);
        }
 
        $this->_total_rows[] = $stmt->rowCount();
        return $stmt;
 
	}

    /**
     * Generates prepared INSERT query string
     *
     * @param string $tableName
     * @param array  $data         A key-value pair with keys that correspond to the fields of the table
     * @access private
     * @return string
     */
    private function _insert_query($tableName, &$data){
        $tableFields = array_keys($data);
        return 'INSERT INTO ' . $this->_prefix . $tableName . ' 
                  (`' . implode('`, `', $tableFields) . '`) 
                  VALUES (:' . implode(', :', $tableFields) . ')';
    }

    /**
     * Generates prepared UPDATE query string
     *
     * @param string $tableName
     * @param array  $data         A key-value pair with keys that correspond to the fields of the table
     * @access private
     * @return string
     */
    private function _update_query($tableName, &$data){
        $setQuery = array();
        foreach ($data as $field => &$value){
            $setQuery[] = '`' . $field . '` = :' . $field;
        }
        return 'UPDATE ' . $this->_prefix . $tableName . '
                  SET ' . implode(', ', $setQuery);
    }
	
	private function _update_decrease_query($tableName, &$data, &$num){
        $setQuery = array();
        foreach ($data as $field){
            $setQuery[] = '`' . $field . '` = `' . $field . "` -" . $num;
        }
        return 'UPDATE ' . $this->_prefix . $tableName . '
                 SET ' . implode(', ', $setQuery);
	}
 
	private function _update_increase_query($tableName, &$data, &$num){
        $setQuery = array();
        foreach ($data as $field){
            $setQuery[] = '`' . $field . '` = `' . $field . "` +" . $num;
        }
        return 'UPDATE ' . $this->_prefix . $tableName . '
                 SET ' . implode(', ', $setQuery);
	}

    /**
     * Generates prepared SELECT query string
     *
     * @param string $tableName
     * @param array  $data         A key-value pair with values that correspond to the fields of the table
     * @access private
     * @return string
     */
    private function _select_query($tableName, &$data){
        $joins = '';
        if ( ! empty($this->_joins)){
            foreach ($this->_joins as $k => &$join)
            {
                $exploded = explode('=', $join[1]);
                $join_cond = '`' . $this->_prefix . implode('`.`', explode('.', trim($exploded[0]))) . '` = `' . $this->_prefix . implode('`.`', explode('.', trim($exploded[1]))) . '`';    
                $joins .= ' INNER JOIN `' . $this->_prefix . $join[0] . '` ON ' . $join_cond;
            }
            $this->_joins = NULL;
            $this->_joins = array();
        }
        $fields = empty($data) ? '*' : '`' . implode('`, `', array_values($data)) . '`';
        return 'SELECT ' . $fields . '
                  FROM `' . $this->_prefix . $tableName . '`' . $joins;
    }

    /**
     * Generates prepared DELETE query string
     *
     * @param string $tableName
     * @access private
     * @return string
     */
    private function _delete_query($tableName){
        return 'DELETE FROM `' . $this->_prefix . $tableName . '`';
    }

    /**
     * Binds data to the prepared statement
     *
     * @param object $stmt A PDOStatement object
     * @param array  $data A key-value pair to be bound with the statement
     * @access private
     * @return object
     */
    private function _bind_data(&$stmt, &$data){
        if ( ! empty($data)){
            foreach ($data as $field => &$value){
                $stmt->bindParam(':' . $field, $value);
            }    
        }
        return $this;
    }

	/**
     * The fetchList method, fetches a LinkedList of column data.
     * @param PDOStatement  $stmt
     * @access public
     * @return LinkedList
     */
    public function fetchList(PDOStatement $stmt){
        $list = new LinkedList;
        while($field = $stmt->fetchColumn()){
            $list->add(new Mystring($field));
        }
        return $list;
    }

	/**
     * The fetchMap method, fetches a LinkedHashMap of column data.
     * @param PDOStatement  $stmt
     * @access public
     * @return LinkedHashMap
     */
    public function fetchMap(PDOStatement $stmt){
        $map = new LinkedHashMap;
        while($fields = $stmt->fetch(PDO::FETCH_NUM)){
            if(count($fields) == 1) $fields[1] = $fields[0];
            $map->put(new Mystring($fields[0]), new Mystring($fields[1]));
        }
        return $map;
    }
	
    /**
     * Magic method __toString() for Database class, returns database information.
     * @access public
     * @return String
     */
    public function __toString(){
        return "Database Object.";
    }    	
} 
?>