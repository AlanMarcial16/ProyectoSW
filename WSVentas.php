<?php
    class WSVentas{
        private $client;

        function __construct($endpoint){
            $this->client = new SoapClient($endpoint);
        }

        public function getProd( $user, $pass, $categoria ){
            $result = $this->client->__soapCall('getProd', array(
                'user' => $user,
                'pass' => $pass,
                'categoria' => $categoria
            ));
            return json_encode($result);
        }

        public function getDetails($user, $pass, $isbn){
            $result = $this->client->__soapCall('getDetails', array(
                'user' => $user,
                'pass' => $pass,
                'isbn' => $isbn
            ));
            return json_encode($result);
        }

    }
?>