<?

interface IStrategy
{
    public function apply(string $text);
}

class SerializeStrategy implements IStrategy
{
    public function apply(string $text)
    {
        return unserialize($text);
    }
}

class JsonStrategy implements IStrategy
{
    public function apply(string $text)
    {
        return json_decode($text, true);
    }
}

class Parser
{
    private $strategy;

    public function setStrategy(IStrategy $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function parse(string $text)
    {
        return $this->strategy->apply($text);
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$test = ['test' => 'ok'];

$parser = new Parser();

$testSerialize = serialize($test);
$parser->setStrategy(new SerializeStrategy());
$testSerialize = $parser->parse($testSerialize);

$testJson = json_encode($test);
$parser->setStrategy(new JsonStrategy());
$testJson = $parser->parse($testJson);

echo $testSerialize === $testJson;
