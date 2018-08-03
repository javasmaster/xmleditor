<!doctype html>
<?php if (file_exists('test-1.xml')) {
    $xml = simplexml_load_file('test-1.xml');
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
    <title>Editor</title>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/starter-template/starter-template.css" rel="stylesheet">
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/table.css" rel="stylesheet">
    <script src="public/js/bootstrap.min.js"></script>
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
              <td class="row" id="<?= $i ?>"><?= $i ?></td>
              <td class="edit"><a href="edit/<?= $i ?>">Edit</a></td> <!-- onClick="getElementById('win').removeAttribute('style');" -->
              <td><a href="#">Delete</a></td>
              <td><?= $news->articleURI ?></td>
              <td><?= $news->title ?></td>
              <td><?php 
              $d = $i+1; // xpath works from the 1 index
              $tags = $xml->xpath("/newsList/news[".$d."]"); 
              foreach($tags as $tag) { // gets all the images related to the article
                  echo $tag->xpath("imageURI")[0];
                //   print_r($tag->xpath("imageURI".$n));
                for($n = 2; $n < 10; $n++) {
                    if(!empty($tag->xpath("imageURI".$n))) {
                        echo "<br />".$tag->xpath("imageURI".$n)[0];
                    }
                    else break;
                }
              } 
              ?></td>
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
                url: "sort",
                data: { "data": order_data },
                success: function(msg){
                    let i = 0;
                    $( ".row" ).each(function() {
                        $(this).html(i);
                        i++;
                    }); 
                    console.log( "Прибыли данные: " + msg );
                }
            });
        }
    
    });
    </script>
    <script>
    // $(document).ready(function() {
    //     $('.edit').on('click', function() {
    //         let id = $(this).closest('tr').find('.row').attr('id');
    //             $.ajax({
    //                 type: "GET",
    //                 url: "/public/edit/" + id,
    //                 success: function(msg){
    //                     console.log( "Прибыли данные: " + msg );

    //                     console.log($title);
    //             }
    //         });

    //     // console.log(d);
    //     })
        
    // })
    </script>
<div id="win" style="display:none;">
      <div class="overlay"></div>
          <div class="visible">
            <h2>Зарегистрироваться</h2>
              <div class="content">
                  <?= 'Hello, Dolly'; ?>
              </div>
           <button type="button" onClick="getElementById('win').style.display='none';" class="close">закрыть</button>
      </div>
    </div>

  </body>
</html>