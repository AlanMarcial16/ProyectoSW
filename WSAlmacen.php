<?php
    class WSAlmacen{
        private $client;

        function __construct($endpoint){
            $this->client = new SoapClient($endpoint);
        }

        public function updateProd( $user, $pass, $isbn, $detalles ){
            $result = $this->client->__soapCall('updateProd', array(
                'user' => $user,
                'pass' => $pass,
                'isbn' => $isbn,
                'detalles' => $detalles
            ));
            return json_encode($result);
        }
    }
?>