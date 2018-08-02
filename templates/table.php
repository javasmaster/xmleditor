<!doctype html>
<?php if (file_exists('test.xml')) {
    $xml = simplexml_load_file('test.xml');
    $i = 0;
}
else {
    exit('Не удалось открыть файл test.xml.');
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Easy Drag and Drop HTML Table Rows With jQuery</title>
    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/starter-template/starter-template.css" rel="stylesheet">
    <link href="../public/css/table.css" rel="stylesheet">

  </head>

  <body>

    <main role="main" class="container">

     <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Row</th>
                <th></th>
                <th></th>
                <th>Article URI</th>
                <th>Title</th>
                <th>Image URI</th>
                <th>Description</th>
                <th>Image Credit</th>
                <th>Source Name</th>
                <th>Source Image URI</th>
                <th>Time Updated</th>
                <th>Web Tooltip</th>
                <th>Web URI</th>
                <th>Photo Tooltip</th>
                <th>Photo URI</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach($xml->news as $news) { ?>
            <tr id="row_links_list_<?= $i ?>">
              <td><?= $i ?></td>
              <td><a href="#">Edit</a></td>
              <td><a href="#">Delete</a></td>
              <td><?= $news->articleURI ?></td>
              <td><?= $news->title ?></td>
              <td><?= $news->imageURI ?></td>
              <td class="description"><?= $news->description ?></td>
              <td><?= $news->imageCredit ?></td>
              <td><?= $news->sourceName ?></td>
              <td><?= $news->sourceImageURI ?></td>
              <td><?= $news->timeUpdated ?></td>
              <td><?= $news->webTooltip ?></td>
              <td><?= $news->webURI ?></td>
              <td><?= $news->photoTooltip ?></td>
              <td><?= $news->photoURI ?></td>
            </tr>
            <?php $i++; } ?>
        </tbody>
    </table>

    </main><!-- /.container -->

    <!-- Bootstrap & Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
    <script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    //   $('tbody').sortable();
    $( "tbody" ).sortable({
        update: function( event, ui ) {
            var order_data = $( "tbody" ).sortable('serialize', { key: "sort" });
            // console.log(JSON.stringify(order_data));
            $.ajax({
                type: "POST",
                url: "/public/sort",
                data: { "data": order_data },
                success: function(msg){
                    console.log( "Прибыли данные: " + msg );
                }
            });
        }
    
    });
        </script>

  </body>
</html>