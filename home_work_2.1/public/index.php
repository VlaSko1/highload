<?php

//Подгружаем библиотеку Monolog
require_once('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Подключаем XDebug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Создаем канал логирования
$log = new Logger('memory');
$log->pushHandler(new StreamHandler('../log/mem.log', Logger::DEBUG));

$memory1 = memory_get_usage();
$log->debug("Старт программы: {$memory1}");
$log->info(date("H:i:s"));

//Первым делом подключаем файл с константами настроек
include $_SERVER['DOCUMENT_ROOT'] . "/../config/config.php";

// Читаем параметры page из url, чтобы определить, какую страницу-шаблон
// хочет увидеть пользователь, по умолчанию это будет index
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'index';
}

// Задание 2. Определяем время начало генерации страницы 'gallery'
if (XDEBUG === true && $page === 'gallery') {
    $start = date("H:i:s");
    $log->Notice("Начало генерации страницы gallery: {$start}");
}

// Для каждой страницы готовим массив со своим набором переменных
// для подстановки их в соответствующий шаблон
$params = [];
switch ($page) {
    case 'index':
        $params['name'] = 'Василий';
        break;
    case 'catalog':
        $params['catalog'] = [
            [
                'name' => 'Пицца',
                'price' => 24
            ],
            [
                'name' => 'Чай',
                'price' => 1
            ],
            [
                'name' => 'Яблоко',
                'price' => 12
            ],
        ];
        break;
    case 'apicatalog':
        $params['catalog'] = [
            [
                'name' => 'Пицца',
                'price' => 24
            ],
            [
                'name' => 'Чай',
                'price' => 1
            ],
            [
                'name' => 'Яблоко',
                'price' => 12
            ],
        ];
        echo json_encode($params, JSON_UNESCAPED_UNICODE);
        exit;
    case 'gallery' :
        $params['imageArr'] = getImg(IMG_BIG);
        $params['say'] = $say;
        if (XDEBUG === true) { 
            for ($i = 0; $i < count($params['imageArr']); $i++) {
                $log->Notice("Элемент {$i} массива imageArr: {$params['imageArr'][$i]}");
            }
            $log->Notice("Переменная say: {$say}");
        }
}

$memory2 = memory_get_usage();
$memory2_1 = $memory2 - $memory1;
$log->debug("Потребление памяти после чтения параметров: {$memory2}. Разница в потреблении памяти: {$memory2_1}");

echo render($page, $params);

$memory3 = memory_get_usage();
$memory3_1 = $memory3 - $memory1;

$log->debug("Потребление памяти после загрузки страницы: {$memory3}. Разница между потреблением памяти в начале выполнения программы и в конце {$memory3_1}");

if (XDEBUG === true && $page === 'gallery') {
    $end = date("H:i:s");
    $memoryGallery = memory_get_usage();
    $log->Notice("Окончание генерации страницы gallery: {$start}");
    $log->Notice("Потребление памяти на загрузку страницы gallery: {$memoryGallery}");
}