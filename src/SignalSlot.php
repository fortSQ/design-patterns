<?

class Dispatcher
{
    private static $instance = null;

    private $objectList = [];

    private $connectionList = [];

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function attachObject(object $object): int
    {
        $id = spl_object_id($object);
        if (!isset($this->objectList[$id])) {
            $this->objectList[$id] = $object;
        }

        return $id;
    }

    public function connect(object $fromObject, string $signal, object $toObject, string $slot): void
    {
        $fromObjectId   = $this->attachObject($fromObject);
        $toObjectId     = $this->attachObject($toObject);

        $this->connectionList[$fromObjectId][$signal][$toObjectId][] = $slot;
    }

    public function dispatch(object $fromObject, string $signal, array $params = []): void
    {
        $fromObjectId = spl_object_id($fromObject);

        if (isset($this->connectionList[$fromObjectId], $this->connectionList[$fromObjectId][$signal])) {
            foreach ($this->connectionList[$fromObjectId][$signal] as $objectId => $slotList) {
                foreach ($slotList as $slot) {
                    call_user_func_array([$this->objectList[$objectId], $slot], $params);
                }
            }
        }
    }
}

trait Emitter
{
    protected function emit(string $signal, ?array $params = null): void
    {
        if (method_exists($this, $signal)) {
            call_user_func_array([$this, $signal], $params);
        }
        Dispatcher::getInstance()->dispatch($this, $signal, $params);
    }
}

class RadioPoint
{
    use Emitter;

    public const SIGNAL_SEND = 'signalSend';

    public function signalSend(string $message): void
    {
        echo '>>> ' . $message . PHP_EOL;
    }

    public function broadcast(string $message): void
    {
        $this->emit(self::SIGNAL_SEND, [$message]);
    }
}

class RadioReceiver
{
    public const SLOT_LISTEN = 'slotListen';

    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function slotListen(string $message): void
    {
        echo $this->name . ': ' . $message . PHP_EOL;
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$point  = new RadioPoint();
$i      = new RadioReceiver('Dmitry');
$son    = new RadioReceiver('Igor');

Dispatcher::getInstance()->connect($point, RadioPoint::SIGNAL_SEND, $i, RadioReceiver::SLOT_LISTEN);
Dispatcher::getInstance()->connect($point, RadioPoint::SIGNAL_SEND, $son, RadioReceiver::SLOT_LISTEN);

$point->broadcast('Hello world!'); # Dmitry: Hello world! Igor: Hello world!
