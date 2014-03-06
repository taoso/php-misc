<?php
$imageRoot = '/tmp';

$pathInfo = $imageRoot . $_SERVER['PATH_INFO'];
$extension = strstr($pathInfo, '.');
$extension = $extension ? substr($extension, 1) : null;

$width = (int)trim($_REQUEST['w']);
$height = (int)trim($_REQUEST['h']);

if ($width > 0 && $height > 0) {
    $resizedImagePath = sprintf(
        "%s-%dx%d.%s",
        strstr($pathInfo, '.', true),
        $width, $height, $extension
    );

    if (file_exists($resizedImagePath)) {
        header('Content-Type: image/' . $extension);
        echo file_get_contents($resizedImagePath);
    } else {
        require 'ImageResizer.php';
        try {
            $resizer = new ImageResizer($pathInfo);
            $resizer->resize($width, $height);
            $resizer->save($resizedImagePath);
            header('Content-Type: image/' . $extension);
            echo file_get_contents($resizedImagePath);
        } catch (Exception $e) {
            header('HTTP/1.1 404 Not Found');
        }
    }
} else {
    if (file_exists($pathInfo)) {
        header('Content-Type: image/' . $extension);
        echo file_get_contents($pathInfo);
    } else {
        header('HTTP/1.1 404 Not Found');
    }
}
