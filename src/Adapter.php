<?

class Auto
{
    public function drive(): string
    {
        return 'beep';
    }
}

class Plane
{
    public function fly(): string
    {
        return 'whee';
    }
}

interface IAdapter
{
    public function go(): string;
}

class AutoAdapter implements IAdapter
{
    private $auto;

    public function __construct()
    {
        $this->auto = new Auto();
    }

    public function go(): string
    {
        return $this->auto->drive();
    }
}

class PlaneAdapter implements IAdapter
{
    private $plane;

    public function __construct()
    {
        $this->plane = new Plane();
    }

    public function go(): string
    {
        return $this->plane->fly();
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

function test(IAdapter $adapter): string
{
    return $adapter->go();
}

$beep = test(new AutoAdapter());
$whee = test(new PlaneAdapter());
