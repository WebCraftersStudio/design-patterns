<?php

/* 
    OBSERWATOR

    Definicja:
    - jesli zmienia sie stan obiektu obserwowanego to obiekty 
      zalezne zostana o tym powiadomione
    - obiekt obserwowany przechowuje liste obserwatorow
    - obiekt obserwowany powiadamia swoich obserwatorow w momencie 
      gdy zmieni sie jego stan
    - obeserwator moze ale nie musi zareagowac na otrzymane powiadomienie

*/

//  obiekt który można obserwować
interface Observable
{
    // dodanie obserwatora
    public function addObserver(Subscriber $subscriber);
    
    // powiadomienie obserwatorów
	public function notifyObservers(Message $message);
}

// obserwator
interface Observer
{
	public function __construct($name);
}

// klasa obserwatora
class Subscriber implements Observer{

    protected $name;

    public function __construct($name){
        $this->name = $name;
    }

    public function onMessagePosted(Message $message){
        echo $this->name . ' - otrzymałem wiadomość o treści: ' . $message->getContent() . '<br>';
    }

    public function getUserName(){
        return $this->name;
    }

}

// klasa wiadomości
class Message
{
	protected $content;

	public function __construct($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}
}

// klasa implementująca interfejs observable
class NotificationService implements Observable{
    
    // zainicjowanie listy obserwatorów którzy obserwują obiekt
    protected $subscribers = [];

    // dodanie obserwatorów
    public function addObserver(Subscriber $subscriber){

        $this->subscribers[] = $subscriber;

    }

    // powiadomienia dla użytkowników
    public function notifyObservers(Message $message){

        // foreach ponieważ wysyłamy do wszystkich
        foreach($this->subscribers as $subscriber){

            $subscriber->onMessagePosted($message);

        }

    }

    public function sendMessage(Message $message){

        $this->notifyObservers($message);

    }
}