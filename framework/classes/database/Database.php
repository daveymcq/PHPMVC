<?php

class Database
{
    private static PDO $connection;
    private static Database $instance;
    private static string $adapter;

    public function __construct()
    {
        self::setDatabaseAdapter(DB_ADAPTER);

        switch(self::$adapter)
        {
            case 'mysql':

                try
                {
                    $options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ];
                    $adapter_string = self::$adapter . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
                    self::$connection = (isset(self::$connection)) ? self::$connection : new PDO($adapter_string, DB_USER, DB_PASS, $options);
                }
                catch(PDOException $e)
                {
                    echo $e->getMessage();
                    exit;
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
}
