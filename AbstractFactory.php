<?

interface ICheapAuto {}
interface IPremiumAuto {}

class AudiA4 implements ICheapAuto {}
class AudiA8 implements IPremiumAuto {}

class Bmw3 implements ICheapAuto {}
class Bmw7 implements IPremiumAuto {}

abstract class AutoFactory
{
    abstract public function getCheapAuto(): ICheapAuto;
    abstract public function getPremiumAuto(): IPremiumAuto;
}

class AudiFactory extends AutoFactory
{
    public function getCheapAuto(): ICheapAuto
    {
        return new AudiA4();
    }

    public function getPremiumAuto(): IPremiumAuto
    {
        return new AudiA8();
    }
}

class BmwFactory extends AutoFactory
{
    public function getCheapAuto(): ICheapAuto
    {
        return new Bmw3();
    }

    public function getPremiumAuto(): IPremiumAuto
    {
        return new Bmw7();
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

function getCheapAuto(AutoFactory $factory): ICheapAuto
{
    return $factory->getCheapAuto();
}

$audiA4 = getCheapAuto(new AudiFactory());
$bmw3 = getCheapAuto(new BmwFactory());
