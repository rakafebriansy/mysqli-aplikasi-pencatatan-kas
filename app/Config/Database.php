<?php
namespace AplikasiKas\Config;
use mysqli;

class Database
{
    private static ?mysqli $mysqli = null;

    public static function getConnection(): mysqli
    {
        if(self::$mysqli == null) {
            $config = self::getConfig('test');
            if(isset($config)) self::$mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
        } else {
            return self::$mysqli;
        }
        return self::$mysqli;
    }
    private static function getConfig(string $env): array|bool
    {
        if($env == 'test') {
            return [
                    'host' => 'localhost',
                    'username' => 'root',
                    'password' => '',
                    'database' => 'aplikasi_kas'
                ];
            } else if ($env == 'prod') {
                return [
                    'host' => '',
                    'username' => '',
                    'password' => '',
                    'database' => 'aplikasi_kas'
                ];
        }
        return false;
    }
    public static function beginTransaction()
    {
        self::$mysqli->begin_transaction();
    }
    public static function commitTransaction()
    {
        self::$mysqli->commit();
    }
    public static function rollbackTransaction()
    {
        self::$mysqli->rollback();
    }
}