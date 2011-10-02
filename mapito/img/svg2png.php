<?php
/*
Copyright (C) 2011  Stefan Huber, Signalwerk GmbH

This file is part of mapito.

mapito is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

mapito is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with mapito.  If not, see <http://www.gnu.org/licenses/>.
*/

$width_in_pixels = 14000;
$mySourcePath = "world.svg";
$myDestinationPath = "world.png";

$im = new Imagick();
$im->readImage($mySourcePath);
$res = $im->getImageResolution();
$x_ratio = $res['x'] / $im->getImageWidth();
$im->removeImage();
$im->setResolution($width_in_pixels * $x_ratio, $width_in_pixels * $x_ratio);
$im->readImage($mySourcePath);
// Now you can do anything with the image, such as convert to a raster image and output it to the browser:
$im->setImageFormat("png");

$fp =fopen($myDestinationPath, 'w');  
@fwrite($fp, $im);  
@fclose($fp);  

// To output the image to the explorer
// header("Content-Type: image/png");
// echo $im;
 
echo "rendering done. saved: ".$myDestinationPath;


?>