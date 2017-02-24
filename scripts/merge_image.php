<?php


function getProductImageList($sn, &$imageList) {
    global $conn;
    $sql =  sprintf("select distinct files.filepath from files, products, products_files where files.fid = products_files.fid and products_files.pid = products.pid and products.sn = '%s'", $sn);
    $result = mysql_query($sql, $conn);
    if (!$result) {
        echo "Mysql error:" . mysql_error();
        return false;
    }
    while ($row = mysql_fetch_assoc($result)) {
        $imageList[] = '/srv/wwwroot/cheap-lingerie.com/httpdocs/images/' . $row["filepath"];    
    }
    mysql_free_result($result);
    return true;
}

function mergeImage($filename, $imageList, $width, $height) {
    $resultImage = imagecreatetruecolor($width * 3, $height);
    $imageCount = count($imageList);
    $firstImage = imagecreatefromjpeg($imageList[0]);
    $firstImageInfo = getimagesize($imageList[0]);
    imagecopyresampled($resultImage, $firstImage, 0, 0, 0, 0, $width, $height, $firstImageInfo[0], $firstImageInfo[1]);
    for ($i = 1; $i < 3; $i++) {
        if ($i < $imageCount) {
            $sourceImage = imagecreatefromjpeg($imageList[$i]);
            $imageInfo = getimagesize($imageList[$i]);
            imagecopyresampled($resultImage, $sourceImage, $i * $width, 0, 0, 0, $width, $height, $imageInfo[0], $imageInfo[1]);
            imagedestroy($sourceImage);
        } else {
            imagecopyresampled($resultImage, $firstImage, $i * $width, 0, 0, 0, $width, $height, $firstImageInfo[0], $firstImageInfo[1]);
        }
    }
    imagedestroy($firstImage);
    imagejpeg($resultImage, $filename, 100);
}

if ($_SERVER['argc'] < 2) {
    die('Usage:' . $_SERVER['argv'][0] . ' filepath' . PHP_EOL);
}

$file = fopen($_SERVER['argv'][1], 'r') or die('Unable to open file' . $_SERVER['argv'][1]);

$conn = mysql_connect("localhost", "mingdatrade", "trade@mingDA123");

if(!$conn) {
    die('Could not connect: ' . mysql_error());
}

if (!mysql_select_db('cheaplingerie', $conn)) {
   die('Could not connect to database cheaplingerie');
}

while(!feof($file)) {
    $sn = trim(fgets($file));
    if (!empty($sn)) {
        $imageList = array();
        if (getProductImageList($sn, $imageList)) {
            $filename = $sn . '_0.jpg';
            mergeImage($filename, $imageList, 164, 246);
        }
    }
}

mysql_close($conn);
fclose($file);
