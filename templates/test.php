<?php
// Файл test.xml содержит XML-документ с корневым элементом 
// и по меньшей мере элемент /[root]/title.

if (file_exists('../shkabaj.xml')) {
    $xml = simplexml_load_file('../shkabaj.xml');
    foreach($xml->news as $news) {
        echo $news->articleURI;
        echo '<br />';
    }
    // print_r($xml->news[2]);
} else {
    exit('Не удалось открыть файл test.xml.');
}
?>