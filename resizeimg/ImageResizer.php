<?php
class ImageResizer {
    private $image;
    private $width;
    private $height;
    private $resizedImage;
    private $extension;

    public function __construct($path) {
        $this->extension = strtolower(strstr($path, '.'));
        $this->image = $this->openImage($path);
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    public function resize($width, $height) {
        $this->resizedImage = imagecreatetruecolor($width, $height);
        if ($this->extension === '.png') {
            imagealphablending($this->resizedImage, false);
            imagesavealpha($this->resizedImage, true);
            $_transparent = imagecolorallocatealpha(
                $this->resizedImage,
                255, 255, 255, 127
            );
            imagefilledrectangle(
                $this->resizedImage,
                0, 0,
                $width, $height,
                $_transparent);
        }
        imagecopyresampled(
            $this->resizedImage,
            $this->image,
            0, 0,
            0, 0,
            $width, $height,
            $this->width, $this->height
        );
    }

    public function save($path) {
        $extension = strtolower(strstr($path, '.'));
        switch ($this->extension) {
        case '.png':
            imagepng($this->resizedImage, $path);
            break;
        default:
            imagejpeg($this->resizedImage, $path);
        }
    }

    private function openImage($path) {
        switch ($this->extension) {
        case '.jpeg':
        case '.jpg':
            $image = imagecreatefromjpeg($path);
            break;
        case '.png':
            $image = imagecreatefrompng($path);
            break;
        default:
            throw new Exception('invalid file path: ' . $path);
        }

        return $image;
    }
}
