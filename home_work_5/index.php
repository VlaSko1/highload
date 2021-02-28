<?php

// Подключаем DEBUG
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Константы для подключения к базе Redis
define('REDIS_SERVER', '127.0.0.1');
define('REDIS_PORT', 6379);
define('TIME_LIVE', 2000000000);



// Подключаем Redis
class redisCacheProvider {
    private $connection = null;
    private function getConnection(){
        if($this->connection===null){
            $this->connection = new Redis();
            $this->connection->connect(REDIS_SERVER, REDIS_PORT);
        }
        return $this->connection;
    }

    public function get($key){
        $result = false;
        if($c = $this->getConnection()){
            $result = unserialize($c->get($key));
        }
        return $result;
    }
    public function set($key, $value, $time=TIME_LIVE){
        if($c=$this->getConnection()){
            $c->set($key, serialize($value), $time);
        }
    }

    public function del($key){
        if($c=$this->getConnection()){
            $c->delete($key);
        }
    }

    public function clear(){
        if($c=$this->getConnection()){
            $c->flushDB();
        }
    }
}

$r = new redisCacheProvider();

$r->del("str", 'to delete');
$str = '';
// Чтение файла 
if (!$r->get('str')) {
    $fd = fopen("100.txt", 'r') or die("не удалось открыть файл");
    
    while(!feof($fd)) {

        $str .= htmlentities(fread($fd, 5));   
    }
    fclose($fd);
    $r->set('str', $str);
} else {
    $str = $r->get('str');
    var_dump("work_redis");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Redis</title>
</head>
<body>
    <p class="text" style="overflow: scroll; width: 400px; height: 400px; background-color: #FF0000; color: black"><?php echo $str ?></p>
</body>
</html>