<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Message\AMQPMessage;
//$connection = new AMQPStreamConnection('reindeer.rmq.cloudamqp.com', 5672, 'kbhayamz', '	Pb_GYy4j9Hxi6z_LoJVhDt_frz3c96tO');

$ssl_options = array(
    'capath' => '',
    'cafile' => '', // my downloaded cert file
    'verify_peer' => false,
);
$connection = new AMQPSSLConnection(
    'reindeer.rmq.cloudamqp.com',
     5671,
    'kbhayamz',
    'Pb_GYy4j9Hxi6z_LoJVhDt_frz3c96tO',
    'kbhayamz',
     $ssl_options
);
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
$msg = new AMQPMessage('hello world !');
$channel->basic_publish($msg, '', 'hello');
echo " [x] Sent 'Hello World !'\n";
$channel->close();
$connection->close();
?>