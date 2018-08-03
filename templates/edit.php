<!doctype html>
<?php if (file_exists('test-1.xml')) {
    $xml = simplexml_load_file('test-1.xml');
    $edit = $xml->news[intval($this->e($id))];
    // print_r($edit);
}
else {
    exit('Не удалось открыть файл test.xml.');
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit news</title>
    <link href="https://getbootstrap.com/docs/4.0/examples/starter-template/starter-template.css" rel="stylesheet">
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/edit.css" rel="stylesheet">
    <script src="../public/js/bootstrap.min.js"></script>

  </head>

  <body>

    <h1 class="container">Edit news</h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <form action="/xmleditor/edit/<?= $this->e($id) ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label><br />
                    <input name="title" type="text" value="<?= $edit->title ?>" />
                </div>
                <div class="form-group">
                    <label for="articleURI">Article URI</label><br />
                    <input name="articleURI" type="text" value="<?= $edit->articleURI ?>" />
                </div>
                <div class="form-group">
                    <label for="imageURI">Image URI</label><br />
                    <input type="file" name="image" accept="image/gif, image/jpeg, image/png">
                    <input name="imageURI" type="text" value="<?= $edit->imageURI ?>" />
                </div>
                <div class="form-group">
                    <label for="imageCredit">Image Credit</label><br />
                    <input name="imageCredit" type="text" value="<?= $edit->imageCredit ?>" />
                </div>
                <div class="form-group">
                    <label for="sourceName">Source Name</label><br />
                    <input name="sourceName" type="text" value="<?= $edit->sourceName ?>" />
                </div>
                <div class="form-group">
                    <label for="sourceImageURI">Source Image URI</label><br />
                    <input name="sourceImageURI" type="text" value="<?= $edit->sourceImageURI ?>" />
                </div>
                <div class="form-group">
                    <label for="timeUpdated">Time Updated</label><br />
                    <input name="timeUpdated" type="text" value="<?= $edit->timeUpdated ?>" />
                </div>
                <div class="form-group">
                    <label for="webTooltip">Web Tooltip</label><br />
                    <input name="webTooltip" type="text" value="<?= $edit->webTooltip ?>" />
                </div>
                <div class="form-group">
                    <label for="webURI">Web URI</label><br />
                    <input name="webURI" type="text" value="<?= $edit->webURI ?>" />
                </div>
                <div class="form-group">
                    <label for="photoTooltip">Photo Tooltip</label><br />
                    <input name="photoTooltip" type="text" value="<?= $edit->photoTooltip ?>" />
                </div>
                <div class="form-group">
                    <label for="webURI">Web URI</label><br />
                    <input name="webURI" type="text" value="<?= $edit->webURI ?>" />
                </div>
                <div class="form-group">
                    <label for="photoURI">Photo URI</label><br />
                    <input name="photoURI" type="text" value="<?= $edit->photoURI ?>" />
                </div>
                <div class="form-group">
                    <label for="description">Description</label><br />
                    <textarea name="description"><?= $edit->description ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
            </div>  
        </div>
    </div>

</body>