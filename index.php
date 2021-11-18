<?php
    $date = date_create();
    $privateKey = '6edf0cf3d74833b26a84b21acb2b3932428836c6';
    $publicKey = '0167460e90b6db53d568f0bdcb5a04aa';
    $ts = $date->format("M/D/Y");

    $hashVal = md5($ts.$privateKey.$publicKey, false);
    if(isset($_GET['startingWith'])){
        $url = "http://gateway.marvel.com/v1/public/characters?nameStartsWith=".$_GET['startingWith']."&limit=100&ts=".$ts."&apikey=".$publicKey."&hash=".$hashVal;
    }
    else{
        $url = "http://gateway.marvel.com/v1/public/characters?nameStartsWith=A&limit=100&ts=".$ts."&apikey=".$publicKey."&hash=".$hashVal;
    }
    require('cache_page.php');
    $record_count = $response['data']['count'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Marvel API Testing</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrap.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1 class="alert alert-info">Marvel API Testing</h1>
            <p><?php echo $response['attributionHTML']; ?></p>
            <p><span class="label label-success">Server Status:</span> <?php echo $response['status']; ?></p>
            <p><span class="label label-success">Results Found:</span> <?php echo $record_count; ?></p>
            <br>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Hero Search:
                </div>
                <div class="panel-body" style="text-align: center;">
                    <ul class="pagination">
                        <li><a href="index.php?startingWith=A">A</a></li>
                        <li><a href="index.php?startingWith=B">B</a></li>
                        <li><a href="index.php?startingWith=C">C</a></li>
                        <li><a href="index.php?startingWith=D">D</a></li>
                        <li><a href="index.php?startingWith=E">E</a></li>
                        <li><a href="index.php?startingWith=F">F</a></li>
                        <li><a href="index.php?startingWith=G">G</a></li>
                        <li><a href="index.php?startingWith=H">H</a></li>
                        <li><a href="index.php?startingWith=I">I</a></li>
                        <li><a href="index.php?startingWith=J">J</a></li>
                        <li><a href="index.php?startingWith=K">K</a></li>
                        <li><a href="index.php?startingWith=L">L</a></li>
                        <li><a href="index.php?startingWith=M">M</a></li>
                        <li><a href="index.php?startingWith=N">N</a></li>
                        <li><a href="index.php?startingWith=O">O</a></li>
                        <li><a href="index.php?startingWith=P">P</a></li>
                        <li><a href="index.php?startingWith=Q">Q</a></li>
                        <li><a href="index.php?startingWith=R">R</a></li>
                        <li><a href="index.php?startingWith=S">S</a></li>
                        <li><a href="index.php?startingWith=T">T</a></li>
                        <li><a href="index.php?startingWith=U">U</a></li>
                        <li><a href="index.php?startingWith=V">V</a></li>
                        <li><a href="index.php?startingWith=W">W</a></li>
                        <li><a href="index.php?startingWith=X">X</a></li>
                        <li><a href="index.php?startingWith=Y">Y</a></li>
                        <li><a href="index.php?startingWith=Z">Z</a></li>
                    </ul>
                </div>
            </div>
            <?php
                $counter = 1;
                $row_counter = 1;

                foreach($response['data']['results'] as $item){
                    if($counter == 1){
                        echo "<div class='row'>";
                    }
                    echo "<div class='col-md-4'>";
                        echo "<div class='thumbnail'>";
                            echo "<a href='".$item['thumbnail']['path'].".".$item['thumbnail']['extension']."' target='_blank'>";
                            echo "<img src='".$item['thumbnail']['path'].".".$item['thumbnail']['extension']."' style='width:100%; height: 250px;'>";
                            echo "</a>";
                            echo "<div class='caption'>";
                                echo "<p class='alert alert-success'><a href='hero.php?id=".$item['id']."'><b>".$item['name']."</b></p>";
                                echo "<p>".$item['description']."</p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";

                    if($counter == 3 || $row_counter == $record_count){
                        echo "</div>";
                        $counter = 1;
                    }else{
                        $counter++;
                    }

                    $row_counter++;
                }
            ?>
        </div>
    </body>
</html>
