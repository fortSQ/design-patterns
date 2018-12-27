<?

interface IUser
{
    public function getName(): string;
    public function addToChat(Chat $chat);
    public function sendMessage(string $text);
}

class User implements IUser
{
    private $name;
    private $chat;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addToChat(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function sendMessage(string $text)
    {
        $this->chat->showMessage($this, $text);
    }
}

interface Mediator {
    public function showMessage(IUser $user, string $message);
}

class Chat implements Mediator
{
    public function showMessage(IUser $user, string $message)
    {
        echo "{$user->getName()}: {$message}" . PHP_EOL;
    }
}

/* ------------------------------------------------------------------------------------------------------------------ */

$chat = new Chat();

$user1 = new User('Dmitry');
$user1->addToChat($chat);

$user2 = new User('Ksenia');
$user2->addToChat($chat);

$user1->sendMessage('Ping'); # Dmitry: Ping
$user2->sendMessage('Pong'); # Ksenia: Pong
