<?php
  // Функция транслитерации строк
  function translit($string) { 
      $translit = array(
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ы' => 'y', 'ъ' => '', 'ь' => '', 'э' => 'eh', 'ю' => 'yu', 'я'=>'ya');

      return str_replace(' ', '_', strtr(mb_strtolower(trim($string)), $translit));
   }

   // 
   function changeImage($h, $w, $src, $newsrc, $type) {
    // Функция создания нового полноцветного изображения, заданного размера   
    $newimg = imagecreatetruecolor($h, $w);
       // Оператором switch проверяем тип изображения
    switch ($type) {
      case 'jpeg':
        // создаем новое изображение
        $img = imagecreatefromjpeg($src);
        //Функция, копирует и изменяет размеры изображения без потери четкости. imagesx - получаем ширину, imagesy - получаем высоту
        imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
        //Создаем файл изображения
        imagejpeg($newimg, $newsrc);
        break;
      case 'png':
        // создаем новое изображение
        $img = imagecreatefrompng($src);
        imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
        imagepng($newimg, $newsrc);
        break;
      case 'gif':
        // создаем новое изображение
        $img = imagecreatefromgif($src);
        imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
        imagegif($newimg, $newsrc);
        break;
    }
   }
  // Проверяем если была отправлена через запрос $_POST переменная 'send' которую мы берем на кнопке загрузить в индексном файле
  if (isset($_POST['send'])) {
    // Проверяем если пришел код ошибки
    if ($_FILES['userfile']['error']) {
      // В переменную $message присваиваем сообщение об ошибке
      $message = 'Ошибка загрузки файла!';
    // Проверяем размер файла, если он больше 1 000 000 байт, в переменную $message сохраняем сообщение
    } elseif ($_FILES['userfile']['size'] > 1000000) {
    //в переменную $message сохраняем сообщение
      $message = 'Файл слишком большой';
        // Проверяем тип отправленного файла
    } elseif (
        $_FILES['userfile']['type'] == 'image/jpeg'||
        $_FILES['userfile']['type'] == 'image/png' ||
        $_FILES['userfile']['type'] == 'image/gif'
      ) {
        // Проверяем если удается копировать временный файл в папку images, при этом применяется функция транслитерации, если файл был назван по русски
          if (copy($_FILES['userfile']['tmp_name'], PHOTO.translit($_FILES['userfile']['name']))) {
            // В переменную $path сохраняем путь img/imya_fayla_na_PC_pol'zovatelya
            $path = PHOTO_SMALL.translit($_FILES['userfile']['name']);
            // В переменную $type сохраняем только тип изображения, без image, то есть например $_FILES['userfile']['type'] = image/jpeg с помощью  explode('/', $_FILES['userfile']['type'])[1] мы убираем image и остается только тип изображения
            $type = explode('/', $_FILES['userfile']['type'])[1];
            // Применяем функцию изменения изображения
            changeImage(150, 150, $_FILES['userfile']['tmp_name'], $path, $type);
          } else {$message = 'Ошибка загрузки файла!';}
      } else {
        $message = 'Не правильный тип файла!';
    }
  }
  // Присваиваем в переменную $images срез массива, с третьего элемента, который мы получили после сканирования папки с маленкими фото  
  $images = array_slice(scandir(PHOTO_SMALL), 2);
  /* Есть пару замечаний
  1. Вместо проверки $_FILES['userfile']['error'] можно было проверить размер файла, если он равен нулю, то произошла ошибка
  2. Мне кажется лучше описать это все в отдельном файле
  */
?>
