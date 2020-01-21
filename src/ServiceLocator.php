<?

class ServiceManager
{
    private array $serviceList = [];

    public function add(string $name, object $instance): void
    {
        if (!isset($this->serviceList[$name])) {
            $this->serviceList[$name] = $instance;
        }
    }

    public function get(string $name): ?object
    {
        if (!isset($this->serviceList[$name])) {
            return null;
        }

        return $this->serviceList[$name];
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$object = new class { public function execute():string { return 'PEW-PEW'; } };

$sm = new ServiceManager();
$sm->add('test', $object);

echo $sm->get('test')->execute(); # PEW-PEW
