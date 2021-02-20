<?php
require_once('vendor/autoload.php');

// Подключаем XDebug
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Message\AMQPMessage;

// фукции обработки событий очереди.

// Перевод товара после попадания в очередь Order и оплаты (условно) в очередь Payment
function paymentSet(AMQPMessage $msg) {
    $connection = new AMQPStreamConnection('localhost', 5672, 'test', 'test'); 
    $channel_2 = $connection->channel();
    $channel_2->queue_declare('Payment', false, true, false, false);
    $message = new AMQPMessage($msg->body . '_pay');
    $channel_2->basic_publish($message, '', 'Payment');
    $channel_2->basic_consume('Payment', '', false, true, false, false, deliverySet($message));
    $channel_2->close();
    $connection->close();
}

// Перевод товара после попадания в очередь Payment и доставки (условно) в очередь Delivery
function deliverySet(AMQPMessage $msg) {
    $connection = new AMQPStreamConnection('localhost', 5672, 'test', 'test');
    $channel_3 = $connection->channel();
    $channel_3->queue_declare('Delivery', false, true, false, false);
    $message = new AMQPMessage($msg->body . '_delivery');
    $channel_3->basic_publish($message, '', 'Delivery');
    $channel_3->basic_consume('Delivery', '', false, true, false, false, feedbackSet($message));
    $channel_3->close();
    $connection->close();
}

// Перевод товара после попадания в очередь Delivery и написания отзыва (условно) в очередь Feedback
function feedbackSet(AMQPMessage $msg) {
    $connection = new AMQPStreamConnection('localhost', 5672, 'test', 'test'); 
    $channel_4 = $connection->channel();
    $channel_4->queue_declare('Feedback', false, true, false, false);
    $message = new AMQPMessage($msg->body . '_feedback');
    $channel_4->basic_publish($message, '', 'Feedback');
    $channel_4->close();
    $connection->close();
}

try {
    // соединяемся с RabbitMQ
    $connection = new AMQPStreamConnection('localhost', 5672, 'test', 'test'); 

    // Создаем канал общения с очередью Order
    $channel_1 = $connection->channel();
    $channel_1->queue_declare('Order', false, true, false, false);
    
    // создаем сообщение
    $msg = new AMQPMessage("order_product2");

    
    // размещаем сообщение в очереди
    $channel_1->basic_publish($msg, '', 'Order');

    $channel_1_2 = $connection->channel();
    $channel_1_2->basic_consume('Order', '', false, true, false, false, paymentSet($msg));
    
    // закрываем соединения
    $channel_1->close();
    $connection->close();
}
catch (AMQPProtocolChannelException $e){
    echo $e->getMessage();
}
catch (AMQPException $e){
    echo $e->getMessage();
}




?>
