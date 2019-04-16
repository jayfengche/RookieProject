<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPSSLConnection;

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
echo " [*] Waiting for messages. To exit press CTRL+C\n";
$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};
$channel->basic_consume('hello', '', false, true, false, false, $callback);
while (count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>