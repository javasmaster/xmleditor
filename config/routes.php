<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("It works! This is the default welcome page.");

    return $response;
})->setName('root');

$app->get('/hello', function (Request $request, Response $response) {
    // $name = $request->getAttribute('name');
    $templates = new League\Plates\Engine('../templates');

    echo $templates->render('table');
    
});

$app->post('/sort', function (Request $request, Response $response) {

    if (file_exists('test.xml')) {
        $xml = simplexml_load_file('test.xml');
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
        print_r($get_number);
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
    $dom->load("test.xml");
    $root = $dom->documentElement; 
    $element = $dom->getElementsByTagName('news')->item($toChange);
    $element_insert = $dom->getElementsByTagName('news')->item($changed);
    $reorder_item = $root->removeChild($element);
    $insert = $element_insert->parentNode->insertBefore($reorder_item,$element_insert);
    header('Content-Type: text/xml');  
    echo $dom->save('test.xml');
});