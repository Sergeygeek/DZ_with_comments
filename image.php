<?php
  include_once 'models/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Работа с файлами</title>
</head>
<body>
  <a href="index.php"> Вернуться в галерею </a>
  <div>
   <!--Передаем в качестве гет параметра название фото, так как они у нас одинаковые в обеих папках, то работает большое фото-->
    <img src="<?=PHOTO.$_GET['photo'] ?>">
  </div>
</body>
</html>
