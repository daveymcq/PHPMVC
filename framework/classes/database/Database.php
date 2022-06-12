<?php
class Database
{
    private static PDO $connection;
    private static Database $instance;
    private static String $adapter;

    public function __construct()
    {
        self::setDatabaseAdapter(DB_ADAPTER);

        switch(self::$adapter)
        {
            case 'mysql':

                try
                {
                    $adapter_string = self::$adapter . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
                    self::$connection = (isset(self::$connection)) ? self::$connection : new PDO($adapter_string, DB_USER, DB_PASS);
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }

            break;
        }
    }

    protected static function getInstance()
    {
        self::$instance = (isset(self::$instance)) ? self::$instance : new self;
        return self::$instance;
    }

    protected static function getConnection()
    {
        return (isset(self::$connection)) ? self::$connection : null;
    }

    public static function setDatabaseAdapter($adapter = DB_ADAPTER)
    {
        self::$adapter = $adapter;
    }

    public static function getDatabaseAdapter()
    {
        return self::$adapter;
    }

    //////////////////////////////////////////////////////////////////////////

    protected function populateFieldsWithDatabase(ActiveRecordModel $object, Array $attributes = []) { return false; }
    public static function query(String $sql, Array $conditions = []) { return false; }
    public static function create(Array $attributes) { return false; }
    public function save() { return false; }
    public function exists() { return false; }
    public function update(Array $new_attributes) { return false; }
    public function delete() { return false; }
}
