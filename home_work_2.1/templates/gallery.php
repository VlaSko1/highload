<div id="main">
    <div class="post_title"><h2>Моя галерея</h2></div>
    <div class="gallery">
        <?php foreach ($imageArr as $image): ?>
            <a rel="gallery" class="photo" href="images/gallery_img/big/<?=$image?>"><img src="images/gallery_img/small/<?=$image?>" width="150" height="100" /></a>
        <?php endforeach; ?>

    </div>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="myfile">
        <input type="submit" value="Загрузить" name="load">
        <p><?=$say?></p>
    </form>
</div>