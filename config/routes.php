<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) {
    $templates = new League\Plates\Engine('templates');

    echo $templates->render('table');
})->setName('root');

$app->get('/hello', function (Request $request, Response $response) {
    // $name = $request->getAttribute('name');

});

$app->get('/edit/{id}', function (Request $request, Response $response, $args) {
    $templates = new League\Plates\Engine('templates');
    $order_number = intval($args['id']);

    echo $templates->render('edit', ["id" => $order_number] );
});

$app->post('/edit/{id}', function (Request $request, Response $response, $args) {
    function imagesUploading($image) {
        print_r($image);
        // Перезапишем переменные для удобства
        $filePath  = $image['image']['tmp_name'];
        $errorCode = $image['image']['error'];

        // Проверим на ошибки
        if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {

            // Массив с названиями ошибок
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
            ];

            // Зададим неизвестную ошибку
            $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

            // Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
            $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;

            // Выведем название ошибки
            die($outputMessage);
        }

        $name = pathinfo($image['image']['name'], PATHINFO_FILENAME); // get name without extension

        $imageInfo = getimagesize($filePath);
        // Сгенерируем расширение файла на основе типа картинки
        $extension = image_type_to_extension($imageInfo[2]);

        // Сократим .jpeg до .jpg
        $format = str_replace('jpeg', 'jpg', $extension);
        $relatedLink =  'public/images/'. $name . $format;
        // Переместим картинку с новым именем и расширением в папку /pics
        if (!move_uploaded_file($filePath, $relatedLink)) {
            die('При записи изображения на диск произошла ошибка.');
        }

        return $relatedLink;
    }

    $order_number = intval($args['id']);
    $post = $request->getParsedBody();
    // Images uploading
    // $image = $_FILES;
    // $imagePath = imagesUploading($_FILES);
    // print_r($imagePath);
    // exit();
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->load("test-1.xml");
    $root = $dom->documentElement;

    foreach($post as $key => $value) {
        // print_r($key)
        $element = $dom->getElementsByTagName('news')->item($order_number)->getElementsByTagName($key)->item(0);
        if(empty($element)) {
            $node = $dom->createElement($key);
            $newnode = $dom->getElementsByTagName('news')->item($order_number)->appendChild($node);
            $newnode = $newnode->nodeValue = $value; // не сохранять некоторые поля в сдата (доделать)
            // $xml->saveXML('test-1.xml'); 
        }
        else {
            $element->nodeValue = '';
            $element->appendChild($dom->createCDATASection($value));
        }

    }
      
    $dom->formatOutput = true;
    $dom->save('test-1.xml');

    $templates = new League\Plates\Engine('templates');
    $order_number = intval($args['id']);

    echo $templates->render('edit', ["id" => $order_number] );

});

$app->post('/sort', function (Request $request, Response $response) {

    if (file_exists('test-1.xml')) {
        $xml = simplexml_load_file('test-1.xml');
        $i = 0;
    }
    else {
        exit('Не удалось открыть файл test.xml.');
    }
    $sortable = []; // array of new order numbers
    $reorder = []; // array for reorder items
    $order = $request->getParsedBody();
    $new_sort = explode("sort=", $order['data']);
    array_shift($new_sort);
    foreach($new_sort as $new_place) {
        $get_number = intval($new_place);
        // preg_match_all('!\d+!', $new_place[0], $matches);
        $sortable[] = $get_number;
        // print_r($get_number);
    }

    foreach($sortable as $key => $value) {
        if($key !== $value) {
            $changed =  $key;
            $toChange = $value;
            break;
        }
    }
    // need to add <br> after news tabg

    // print_r($reorder);
    $dom = new DOMDocument;
    $dom->load("test-1.xml");
    $root = $dom->documentElement; 
    $element = $dom->getElementsByTagName('news')->item($toChange);
    $element_insert = $dom->getElementsByTagName('news')->item($changed);
    $reorder_item = $root->removeChild($element);
    $insert = $element_insert->parentNode->insertBefore($reorder_item,$element_insert);
    // header('Content-Type: text/xml');  
    echo $dom->save('test-1.xml');
    return true;
});