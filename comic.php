<?php
    $date = date_create();
    $privateKey = '6edf0cf3d74833b26a84b21acb2b3932428836c6';
    $publicKey = '0167460e90b6db53d568f0bdcb5a04aa';
    $ts = $date->format("M/D/Y");
    $hashVal = md5($ts.$privateKey.$publicKey, false);

    if(isset($_GET['URL'])){
        $url = $_GET['URL'].'?ts='.$ts.'&apikey='.$publicKey.'&hash='.$hashVal;
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
                            <p class="bg-success" style="text-align: center;"><b>Comic Credentials</b></p>
                            <p><span class="label label-primary">Marvel Comic ID:</span> <?php echo $response['data']['results'][0]['id']; ?></p>
                            <p><span class="label label-primary">Title:</span> <?php echo $response['data']['results'][0]['title']; ?></p>
                            <p><span class="label label-primary">Description:</span> <?php if($response['data']['results'][0]['description'] == ''){
                                echo "N/A";
                            }
                            else{
                                echo $response['data']['results'][0]['description'];
                            } ?></p>
                            <p><span class="label label-primary">ISBN Number:</span> <?php if($response['data']['results'][0]['isbn'] == ''){
                                echo "N/A";
                            }
                            else{
                                echo $response['data']['results'][0]['isbn'];
                            } ?></p>
                            <p><span class="label label-primary">Page Count:</span> <?php if($response['data']['results'][0]['pageCount'] == ''){
                                echo "N/A";
                            }
                            else{
                                echo $response['data']['results'][0]['pageCount'];
                            } ?></p>
                            <p><span class="label label-primary">Avg Price USD:</span> <?php if($response['data']['results'][0]['prices'][0]['price'] == 0){
                                echo "N/A";
                            }
                            else{
                                echo "$".$response['data']['results'][0]['prices'][0]['price'];
                            } ?></p>
                            <p><span class="label label-primary">Creators:</span> <?php if($response['data']['results'][0]['creators']['available'] == 0){
                                echo "N/A";
                            }
                            else{
                                echo "<ul class='list-group'>";
                                foreach($response['data']['results'][0]['creators']['items'] as $item){
                                    echo "<li class='list-group-item'>".$item['name']." as ".$item['role']."</li>";
                                }
                                echo "</ul>";
                            } ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>