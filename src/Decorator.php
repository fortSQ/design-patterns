<?

class AgeDecorator
{
    private $birthDay;

    public function __construct(DateTime $birthDay)
    {
        $this->birthDay = (clone $birthDay)->setTime(0, 0);
    }

    public function getDateInterval(): DateInterval
    {
        return (new DateTime())->diff($this->birthDay);
    }

    public function getYears(): int
    {
        return $this->getDateInterval()->y;
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$birthDay = DateTime::createFromFormat('d.m.Y', '17.09.1993');
$ageDecorator = new AgeDecorator($birthDay);

echo "My age: {$ageDecorator->getYears()}"; # 26 (at 21.01.2020)
