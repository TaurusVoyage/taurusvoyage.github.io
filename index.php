<?php
if(!file_exists('links')){
	mkdir('./links',0755);
}

$robotslink = [];

$content = file_get_contents('domains.txt');
$arr = explode(PHP_EOL,$content);

$j = 1;



$site = str_replace('.','_',$arr[0]);
$site = str_replace('https://','',$site);


$file = fopen("./links/{$site}_{$j}.txt",'w');
$robotslink[] = "{$arr[0]}/{$site}_{$j}.txt";
for($i=1;$i < $arr[1];$i++){
	if($i % 50000 == 0){
		$j++;
		$file = fopen("./links/{$site}_{$j}.txt",'w');
		$robotslink[] = "{$arr[0]}/{$site}_{$j}.txt";
	}
	$names = createlink($i);
	$links = "{$arr[0]}/?{$names}\r\n";
	fwrite($file,$links);
}

fclose($file);

$robots = fopen("./links/robots.txt",'w');  
$robots_str = '';
foreach($robotslink as $robot){
    $strr = "Sitemap: {$robot}
";
$robots_str = $robots_str.$strr;
}


$str = "User-agent:*
Allow:/

{$robots_str}";

fwrite($robots,$str);  
fclose($robots);

echo "结束";



function createlink($id){
    $name = md5($id);
    $str = preg_replace('/[^a-z]/','',$name);
    $idcount = strlen($id);
    $i = 10-$idcount;
    $val = "";
    for($j=0;$j<$i;$j++){
        if($str[$j]){
            $val .= $str[$j];
        }else{
            break;
        }
        
    }
    
    return $val.$id;
}




function dump($str){
    print_r($str);
    exit;
}


?>