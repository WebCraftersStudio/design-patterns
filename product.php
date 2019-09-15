<?php
/* 
   ADAPTER

   Adapter założenia:
   - sprawia że niekompatybilne klasy mogą ze sobą współpracować
   - "przejściówka"

   Przykład:
   - klient spodziewa się displayPrice()
   - interfejs dostarcza getPrice() która robi to samo
   - potrzebujemy adaptera który użyje getPrice i opakuje ją w metodą displayPrice()

*/

// Klasa pierwotna
class Product{

    protected $names;
    protected $products;
    protected $names_arr = array();


    public function __construct($products){

        $this->products = $products;

    }
    
    public function getNames(){

        while($row = mysqli_fetch_array($this->products)){
            array_push($this->names_arr, $row['name']); 
        }

        return $this->names_arr;

    }

}

// Adapter zapewniający kompatybilność
class ProductAdapter{

    protected $product;

    // pobieramy instancję klasy product i przypisuje go do chronionej zmienne $product
    public function __construct(Product $product){
        $this->product = $product;
    }

    // rzutujemy metodę na inną - odpowiadającą nowej klasie
    public function getFirstNames(){
        return $this->product->getNames();
    }

}