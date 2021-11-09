<?php
    class WSAlmacen{
        private $client;

        function __construct($endpoint){
            $this->client = new SoapClient($endpoint);
        }

        public function updateProd( $user, $pass, $isbn, $detalles ){
            $result = $this->client->updateProd(array(
                'user' => $user,
                'pass' => $pass,
                'isbn' => $isbn,
                'detalles' => json_encode($detalles)
            ));
            return json_encode($result->updateProdResult);
        }
    }
?>