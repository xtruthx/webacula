<?php
/**
 * Class for Logbook
 *
 * @package    webacula
 * @author Yuri Timofeev <tim4dev@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU Public License
 */

/*
 * workaround http://zendframework.com/issues/browse/ZF-7070
 * http://www.zfforums.com/zend-framework-components-13/databases-20/problem-postgres-2151.html#post11910
 */

class Wblogtype extends Zend_Db_Table
{
	public $db_adapter;
	
	public function __construct($config = array())
	{
		$this->db_adapter = Zend_Registry::get('DB_ADAPTER_WEBACULA');
		$config['db']      = Zend_Registry::get('db_webacula'); // database
		$config['sequence']= true;	
		parent::__construct($config);
	}
	
	protected function _setupTableName()
    {
        switch ($this->db_adapter) {
        case 'PDO_PGSQL':
            $this->_name = 'wblogtype';
            break;
        default:  // including mysql, sqlite
        	$this->_name = 'wbLogType';
        }
        parent::_setupTableName();
    }

    protected function _setupPrimaryKey()
    {
        $this->_primary = 'typeid';
        parent::_setupPrimaryKey();
    }

    public function init() {
        $db = Zend_Db_Table::getAdapter('db_webacula');
        $select = new Zend_Db_Select($db);
        switch ($this->db_adapter) {
            case 'PDO_MYSQL':       
                $db->query('SET NAMES utf8');
                $db->query('SET CHARACTER SET utf8');
                break;
            case 'PDO_PGSQL':
                $db->query("SET NAMES 'UTF8'");
                break;
        }
    }
    
}
