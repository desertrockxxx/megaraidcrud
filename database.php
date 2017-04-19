<?php
class Database
{
    private static $dbName = 'megaraidcrud' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'markschuster';
    private static $dbUserPassword = '';
     
    private static $cont  = null;
    
    
    /*__construct(): Das ist der Konstruktor der Klasse Database. 
    Da es eine static Klasse ist, ist die Initialisierung dieser Klasse nicht erlaubt. 
    Um Missbrauch der Klasse vorzubeugen, benutzen Wir die "die" Funktion, um Nutzer daran zu erinnern.*/
    public function __construct() {
        die('Init function is not allowed');
    }
    
    /*Das ist die Main Funktion der Klasse. 
    Es benutzt Singleton Pattern 
    (Es stellt sicher, dass von einer Klasse genau ein Objekt existiert.)
    um sicherzustellen, dass nur eine PDO Verbindung exist across the whole application. 
    Da es eine static Methode ist. 
    Wir benutzen Database::connect(), um eine Verbindung herzustellen.*/
    public static function connect()
    {
       /* Ein Verbindung through whole application.
       self ist Klasse Database*/
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
    
    /*Disconnect from database. 
    Es setzt die connection zu NULL. 
    Wir müssen diese aufrufen, um die Verbindung zu schließen.*/
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>