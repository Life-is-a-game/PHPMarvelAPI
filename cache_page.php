<?php
$cache_index = dirname(__FILE__)."/api-cache.json";
if(file_exists($cache_index)){
    if(!file_get_contents($cache_index)){
        $cacheCheckRegister = file_get_contents($cache_index);
        $cacheCheckRegister = @json_decode($cacheCheckRegister, true);
        $check = false;

        foreach($cacheCheckRegister[0]['Data'] as $item){
            if($item['URLvalue'] == $url){
                $check = true;
                $expires = time() - 2 * 60 * 60;
                $json_file = dirname(__FILE__)."/cache/".$item['IndexValue'].".json";

                if(filemtime($json_file) < $expires || file_get_contents($json_file) == ''){
                    $response = @file_get_contents($url);
                    file_put_contents($json_file, $response);
                    $response = @json_decode($response, true);

                    break;
                }
                else{
                    $response = file_get_contents($json_file);
                    $response = @json_decode($response, true);

                    break;
                }
            }
        }

        if($check == false){
            $index_count = $cacheCheckRegister[0]['IndexCount'];
            $index_count++;
            $cacheCheckRegister[0]['IndexCount'] = $index_count;
            $newRow = array(
                'IndexValue' => 'A'.$index_count,
                'URLvalue' => $url
            );
            $cacheCheckRegister[0]['Data'][] = $newRow;
            file_put_contents($cache_index, json_encode($cacheCheckRegister));

            $my_file = "cache/A".$index_count.".json";
            $handle = fopen($my_file, "w") or die('Cannot open file: '.$my_file);
            fclose($handle);

            $cache_file = dirname(__FILE__)>"/cache/A".$index_count.".json";
            $response = @file_get_contents($url);
            file_put_contents($cache_file, $response);
            $response = json_decode($response. true);
        }
    }
    else{
        $URLcollection[] = array(
            'IndexCount' => '1',
            'Data' => array(
                array(
                    'IndexValue' => 'A1',
                    'URLvalue' => $url
                )
            )
        );

        file_put_contents($cache_index, json_encode($URLcollection));
        $my_file = "cache/A1.json";
        $handle = fopen($my_file, "w") or die("Cannot open file: ".$my_file);
        fclose($handle);

        $cache_file = dirname(__FILE__)."/cache/A1.json";
        $response = @file_get_contents($url);
        file_put_contents($cache_file, $response);
        $response = @json_decode($response, true);
    }
}
else{
    $my_file = "api-cache.json";
    $handle = fopen($my_file, "w") or die("Cannot open file: ".$my_file);
    fclose($handle);
    header("Refresh:0.1");
}
?>