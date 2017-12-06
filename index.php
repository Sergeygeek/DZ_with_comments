<?php
  // Подключаем файл config.php, в котором описываем путь к большим фотографиям и к маленьким
  include_once 'models/config.php';
  // Подключаем файл photo.php
  include_once 'models/photo.php';  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Работа с файлами</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <h1>ГАЛЕРЕЯ ФОТО</h1>
  </header>

  
  <div class="images">
    <?php
      // Пробегаем по массиву $images и на каждой итерации подставляем в ссылку параметр photo равный загруженным фото
      for ($i=0; $i < count($images); $i++) : ?>
      <a href="image.php?photo=<?=$images[$i] ?>">
        <img src="<?=PHOTO_SMALL.$images[$i] ?>">
      </a>
    <?php endfor; ?>
  </div>

  <div class="add_foto">
    <form action="" method="POST" enctype="multipart/form-data">
      <span> <b>Добавить файл: </b> </span>
      <input type="file" name="userfile"> 
      <button type="submit" name="send">ЗАГРУЗИТЬ</button> <br>
      
      <!--Здесь надо было бы проверить задана ли переменная $message и выводить ее если задана-->
      <span><?=$message?></span>
    </form>
  </div>    
  
</body>
</html>
