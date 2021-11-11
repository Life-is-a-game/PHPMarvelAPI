<?php
    $date = date_create();
    $privateKey = '6edf0cf3d74833b26a84b21acb2b3932428836c6';
    $publicKey = '0167460e90b6db53d568f0bdcb5a04aa';
    $ts = $date->format("M/D/Y");
    $hashVal = md5($ts.$privateKey.$publicKey, false);

    if(isset($_GET['id'])){
        $url = 'http://gateway.marvel.com/v1/public/characters/'.$_GET['id'].'?ts='.$ts.'&apikey='.$publicKey.'&hash='.$hashVal;
        $response = @file_get_contents($url);
        $response = @json_decode($response, true);
        $record_count = $response['data']['count'];
    }
    else{
        header("Location: index.php");
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Marvel API Testing</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, inital-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrap.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1 class="alert alert-info">Marvel API Testing <button type="button" class="btn btn-primary" style="float: right;" onclick="history.back()">Previous</button></h1>
            <p><?php echo $response['attributionHTML']; ?></p>
            <p><span class="label label-success">Server Status:</span> <?php echo $response['status']; ?></p>
            <p><span class="label label-success">Results Found:</span> <?php echo $record_count; ?></p>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="thumbnail">
                       <a href="<?php echo $response['data']['results'][0]['thumbnail']['path'].'.'.$response['data']['results'][0]['thumbnail']['extension'];?>" target="_blank">
                           <img src="<?php echo $response['data']['results'][0]['thumbnail']['path'].'.'.$response['data']['results'][0]['thumbnail']['extension'];?>" alt="Lights" style="width: 100%;">
                       </a> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="thumbnail">
                        <div class="caption">
                            <p class="bg-success" style="text-align: center;"><b>Hero Credentials</b></p>
                            <p><span class="label label-primary">Marvel Hero ID:</span> <?php echo $response['data']['results'][0]['id']; ?></p>
                            <p><span class="label label-primary">Hero Name:</span> <?php echo $response['data']['results'][0]['name']; ?></p>
                            <p><span class="label label-primary">Hero Description:</span> <?php if($response['data']['results'][0]['description'] == ''){
                                echo "N/A";
                            }
                            else{
                                echo $response['data']['results'][0]['description'];
                            } ?></p>
                            <p><span class="label label-primary">Comic Entries:</span> <?php echo $response['data']['results'][0]['comics']['available']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="alert alert-info">Comic Listings<button type="button" class="btn btn-primary" style="float: right;" onclick="history.back()">Previous</button></h3>
            <?php
            $counter = 1;
            $row_counter = 1;
            $comic_count = $response['data']['results'][0]['comics']['available'];
            if($comic_count > 20){
                $comic_count = 20;
            }
            foreach($response['data']['results'][0]['comics']['items'] as $item){
                if($counter == 1){
                    echo "<div class='row'>";
                }
                echo "<div class='col-md-2'>";
                    echo "<div class='thumbnail'>";
                        echo "<div class='caption'>";
                        echo "<a href='comic.php?URL=".$item['resourceURI']."'>";
                        echo "<p> <span class='glyphicon glyphicon-asterisk'></span>".$item['name']."</p>";
                        echo "</a>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";

                if($counter == 6 || $row_counter == $comic_count){
                    echo "</div>";
                    $counter = 1;
                }
                else{
                    $counter++;
                }
                $row_counter++;
            }
            ?>
        </div>
    </body>
</html>