<?

class Singleton
{
    private static $instance;

    protected function __construct() {}

    final private function __clone() {}

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$a = Singleton::getInstance();
$b = Singleton::getInstance();
echo $a === $b; # true
