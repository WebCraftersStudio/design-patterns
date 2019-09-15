<?php


require_once './DBConnection.php';
require_once './product.php';
require_once './users.php';
require_once './notifications.php';

$dbPass = parse_ini_file("./database/config.ini");

$config = [
    'server'    => $dbPass['host'],
    'user'      => $dbPass['user'],
    'password'  => '',
    'database'  => $dbPass['name']
];

echo '<h2>Singleton - pobranie rekordów z bazy danych</h2><br>';
$products = DBConnection::getInstance($config)->getProducts();
print_r($products);

echo '<br><br><hr>';

echo '<h2>Adapter - klient chce użyć innych metod(nie zawartych w interfejsie</h2><br>';
echo 'Normalne wywołanie metody zawartej w interfejsie $pizza->getNames():<br>';
$product = new Product($products);
print_r($product->getNames());

echo '<br><br>';

$productAdapter = new ProductAdapter($product);
echo 'Klienckie wywołanie metody nie zwartej w interfejsie $pizza->getFirstNames():<br>';
print_r($productAdapter->getFirstNames());

echo '<br><br><hr>';
echo '<h2>Obserwator</h2><br>';

$users = DBConnection::getInstance($config)->getUsers();
print_r($users);
echo '<br>';
$users = new User($users);

// klient
echo '<br><br>Użytkownicy zapisani na newsletter:';

// stworzenie listy obiektów subskrybentów pobranych z brazy danych
$user_arr = array();
foreach($users->getNames() as $user){
    $user = new Subscriber($user);
    array_push($user_arr, $user);
    echo '<br>' . $user->getUserName();
}

echo '<br><br>';

// dodanie obserwatorów do listy notyfikacj i wysłanie wiadomości
$ns = new NotificationService();

foreach($user_arr as $singleUser){
    $ns->addObserver($singleUser);
}

$ns->sendMessage(new Message('Witaj'));