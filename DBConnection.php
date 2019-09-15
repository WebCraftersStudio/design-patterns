<?php 

/* 
   SINGLETON
   
   Singleton definicja:
   - ograniczamy możliwość tworzenia obiektów klasy tylko do jednej instancji
   - przydatny jeśli chcemy mieć jeden obiekt koordynujący działania w całyms systemie
   
   Przykład:
   - potrzebujemy obiektu połączenia z bazą danych
   - różne komponenty aplikacji korzystają z tej samej instancji połączenia aby 
     za każdmy razem nie tworzyć nowego połączenia
   
   Dodatkowe informacje:
   - często nadużywany
   - uważany za antywzorzec
   - wprowadza gobalny stan do aplikacji
   - trudność w testowaniu aplikacji

   Implementacja:
   - statyczny składnik przechowujący
   - prywatny konstruktor
   - statyczna publiczna metod zapewniając dostęp do instancji
*/

// klasa reprezentująca połączenie z bazą danych
// FINAL ponieważ nie chcemy aby ta klasa była modyfikowana przez INNE klasy
final class DBConnection{
    protected $resultsQuery = array();
    protected $usersQuery = array();
    private static $database; // prywatny ponieważ nie bęzie można bezpośrednio się do niego odwołać
    private static $instance; // prywatny ponieważ nie bęzie można bezpośrednio się do niego odwołać

    // teraz tworzymy prywatny kontruktor żeby inne klasy nie mogły konstruować instancji tej klasy
    private function __construct($config){
        self::$database = mysqli_connect($config['server'], $config['user'], $config['password'], $config['database']);
    }

    // metoda dostępowa
    // jeśli nie istnieje instancja tej klasy to należy ją stworzyć i zwrocić
    public static function getInstance($config){

        if(!self::$instance){ // jeśli nie ma instancji to ją należy stworzyć
            
            self::$instance = new Self($config); // rownie dobrze mogłó by być new DBConnection()
        
        }
        
        return self::$instance;

    }

    private function __clone(){
        // zablokowanie tworzenia instancji poprzez klonowanie
    }

    public function getProducts(){
        $this->resultsQuery = mysqli_query(self::$database,"SELECT * FROM produkty");

        return $this->resultsQuery;
    }
    public function getUsers(){
        $this->usersQuery = mysqli_query(self::$database,"SELECT * FROM users");

        return $this->usersQuery;
    }
}

// TESTY

// $db = new DBConnection(); // zwróci błąd ponieważ nie mogę tworzyć instancji ponieważ konstruktor jest prywatny

// $db1 = DBConnection::getInstance(); // obie odwołują się do jednej instancji
// $db2 = DBConnection::getInstance(); // obie odwołują się do jednej instancji

// print_r($db1 == $db2); // potwierdzenie tej samej instancji