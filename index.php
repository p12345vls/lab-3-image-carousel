<?php
$backgroundImage = "img/sea.jpg";
$selected = NULL;

if (!isset($_GET['keyword']) && !isset($_GET['category'])) {
    $selected = NULL;

} else {
    if (!empty($_GET['keyword'])) {
        $selected = $_GET['keyword'];
    } elseif (!empty($_GET['category'])) {
        $selected = $_GET['category'];
    }
    //  echo ($selected);

    if ($selected==NULL) {
        
        echo "<script>alert('Please Enter a Value');</script>";

    } else {
        include 'api/pixabayAPI.php';
        $imageURLs = getImageURLs($selected ,$_GET['layout']);
        $backgroundImage = $imageURLs[array_rand($imageURLs)];
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Image Carousel</title>
        <meta charset="UTF-8">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" >

        <style>
            @import url("css/styles.css");
            body {
                background-image: url('<?=$backgroundImage ?>');
                background-size: cover;
            }
        </style>
    </head>

    <body>
        <br>
        <?php
            if (!isset($imageURLs)) {
                echo "<h2> Type a keyword to display a slideshow <br> with random images from Pixbay.com </h2>";
            } else {
            //print_r($imageURLs);

        ?>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php
                for($i = 0; $i<7; $i++) {
                    echo "<li data-target='#carousel-example-generic' data-slide-to='$i'";
                    echo ($li == 0) ? "class='active'" : "";
                    echo "></li>";
                }
                ?>
            </ol>

            <div class="carousel-inner" role="listbox">
                <?php
                    for($i = 0; $i<7; $i++) {
                        do {
                            $randomIndex = rand(0, count($imageURLs));
                        } while (!isset($imageURLs[$randomIndex]));
        
                        echo '<div class="item';
                        echo ($li == 0) ? "active" : "";
                        echo '">';
                        echo '<img src="' . $imageURLs[$randomIndex] . '">';
                        echo '</div>';
                        unset($imageURLs[$randomIndex]);
    
                    }
                ?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <?php
            }
        ?>
        <br>
        <form>
            <input type="text" name="category" placeholder="Category" value="<?=$selected?>"/>
            <input type="radio" id="lhorizontal" name="layout" value="horizontal"/>
            <label for = "Horizontal"></label><label for="lhorizontal">Horizontal</label>
            <input type="radio" id="lvertical"  name="layout" value="vertical"/>
            <label for="Vertical"></label><label for="lvertical">Vertical</label>
            
            <select name="keyword">
                <option value="">keyword</option>
                <option value="valey">Valey</option>
                <option>Otter</option>
                <option>Sky</option>
                <option>Car</option>
            </select>
            
            <input type="submit" value="Search"/>
        </form>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <h1 id="alert"></h1>
    </body>
</html>
