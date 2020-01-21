<?

class Person
{
    private $name;
    private $age;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function __toString(): string
    {
        return "{$this->name}, {$this->age}";
    }
}

abstract class BuilderPerson
{
    /** @var Person */
    protected $person;

    public function createPerson(): void
    {
        $this->person = new Person();
    }

    public function getPerson(): Person
    {
        return $this->person;
    }

    abstract public function buildName(): void;
    abstract public function buildAge(): void;
}

class BuilderYoungPerson extends BuilderPerson
{
    public function buildName(): void
    {
        $nameList = [
            'Dima',
            'Ksyusha',
        ];
        $name = $nameList[array_rand($nameList)];

        $this->person->setName($name);
    }

    public function buildAge(): void
    {
        $age = mt_rand(18, 44);

        $this->person->setAge($age);
    }
}

class BuilderOldPerson extends BuilderPerson
{
    public function buildName(): void
    {
        $nameList = [
            'Dmitry Valeryevich',
            'Kseniya Aleksandrovna',
        ];
        $name = $nameList[array_rand($nameList)];

        $this->person->setName($name);
    }

    public function buildAge(): void
    {
        $age = mt_rand(45, 80);

        $this->person->setAge($age);
    }
}

class PersonBuilder
{
    /** @var BuilderPerson */
    private $builderPerson;

    public function setBuilderPerson(BuilderPerson $builderPerson): void
    {
        $this->builderPerson = $builderPerson;
    }

    public function generate(): Person
    {
        $this->builderPerson->createPerson();
        $this->builderPerson->buildName();
        $this->builderPerson->buildAge();

        return $this->builderPerson->getPerson();
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$youngBuilder   = new BuilderYoungPerson();
$oldBuilder     = new BuilderOldPerson();
$personGenerator = new PersonBuilder();

$personGenerator->setBuilderPerson($youngBuilder);
$youngPerson = $personGenerator->generate();
echo $youngPerson; # (may be) Ksyusha, 23

$personGenerator->setBuilderPerson($oldBuilder);
$oldPerson = $personGenerator->generate();
echo $oldPerson; # (may be) Dmitry Valeryevich, 64
