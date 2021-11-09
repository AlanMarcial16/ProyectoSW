<?php
    class WSVentas{
        private $client;

        function __construct($endpoint){
            $this->client = new SoapClient($endpoint);
        }

        public function getProd( $user, $pass, $categoria ){
            $result = $this->client->__getFunctions();
            return json_encode($result);
            // $result = $this->client->__soapCall('getProd', array(
            //     'user' => $user,
            //     'pass' => $pass,
            //     'categoria' => $categoria
            // ));
            // return json_encode($result);
        }
    }
?>