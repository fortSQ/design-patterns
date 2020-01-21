<?

interface IVehicle
{
    public function go(): string;
}

class Car implements IVehicle
{
    public function go(): string
    {
        return 'vrooom';
    }
}

class Train implements IVehicle
{
    public function go(): string
    {
        return 'choo-choo';
    }
}

abstract class Controller
{
    protected $vehicle;

    public function __construct(IVehicle $vehicle)
    {
        $this->connect($vehicle);
    }

    public function connect(IVehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    protected function commandGo(): string
    {
        return $this->vehicle->go();
    }
}

class KeyboardController extends Controller
{
    public function pressKeyUp(): string
    {
        return $this->commandGo();
    }
}

class GamepadController extends Controller
{
    public function pressButtonA(): string
    {
        return $this->commandGo();
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$train = new Train();
$keyboard = new KeyboardController($train);
$gamepad = new GamepadController($train);
echo $keyboard->pressKeyUp(); # choo-choo
echo $gamepad->pressButtonA(); # choo-choo

$car = new Car();
$gamepad->connect($car);
echo $gamepad->pressButtonA(); # vrooom