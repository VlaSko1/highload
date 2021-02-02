<h2>Каталог товаров:</h2>
<?php foreach ($catalog as $value):?>
<div>
    <h2><?=$value['name']?></h2>
    Стоимость:  <?=$value['price']?><br>
    <button>Купить</button> <hr>
</div>
<?php endforeach;?>