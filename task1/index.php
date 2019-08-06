<?php

$dir = $_POST['name']?? 'c://';
$recursiveDir = new DirectoryIterator($dir.'/');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <?php foreach($recursiveDir as $file):
            $isDir = $file->isDir();
            $path = $file->getRealPath();
            $fileName = $file->getFilename();
        ?>
            <?php if ( $fileName == '.'): ?>
                <h3><?= $file->getPath() ?> </h3>
            <?php elseif( $fileName == '..'): ?>
                <div class="header">
                    <input class="input" type="submit" value="<?= $path ?>" name="name"><br>
                </div>

            <?php elseif( trim($file->getRealPath()) !== ''): ?>
            <div class="list">
                <label class="<?= $isDir? 'show' : 'hide' ?>" for="<?= $path ?>">&#8226;</label>
                <input id="<?= $path ?>" class="<?= $isDir? 'dir': 'file' ?>" type="<?= $isDir? 'submit' : 'button' ?>" value="<?= $path ?>" name="name">
            </div>

            <?php endif; ?>
        <?php endforeach; ?>
    </form>
</body>
</html>

