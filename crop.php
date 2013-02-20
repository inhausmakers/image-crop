<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Initialize the size of the output image
        $boundary = 150;
        $dst_w = $_POST['width'];
        $dst_h = $_POST['height'];

        if ($dst_w > $dst_h)
        {
            $dst_h = $dst_h * $boundary / $dst_w;
            $dst_w = $boundary;
        }
        else
        {
            $dst_w = $dst_w * $boundary / $dst_h;
            $dst_h = $boundary;
        }

        // Initialize the quality of the output image
        $quality = 80;

        // Set the source image path
        $src_path = 'resources/images/example.jpg';

        // Create a new image from the source image path
        $src_image = imagecreatefromjpeg($src_path);

        // Create the output image as a true color image at the specified size
        $dst_image = imagecreatetruecolor($dst_w, $dst_h);

        // Copy and resize part of the source image with resampling to the
        // output image
        imagecopyresampled($dst_image, $src_image, 0, 0, $_POST['x'],
                           $_POST['y'], $dst_w, $dst_h, $_POST['width'],
                           $_POST['height']);

        // Destroy the source image
        imagedestroy($src_image);

        // Send a raw HTTP header
        header('Content-type: image/jpeg');

        // Output the image to browser
        imagejpeg($dst_image, null, $quality);

        // Destroy the output image
        imagedestroy($dst_image);

        // Terminate the current script
        exit();
    }
?>