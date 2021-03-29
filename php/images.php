<?php

function newDimensions ($cur_x, $cur_y, $max_x = null, $max_y = null, $image = null) { // http://www.geekality.net/2011/05/01/php-how-to-proportionally-resize-an-uploaded-image/
	if (!$cur_x && !$cur_y && $image) {
		$dimensions	= getimagesize($image);
		$cur_x		= $dimensions[0];
		$cur_y		= $dimensions[1];
	}

	$scale = min(($max_x / $cur_x), ($max_y / $cur_y));# Calculate the scaling we need to do to fit the image inside our frame

	$new_width  = ceil($scale * $cur_x);# Calculate the new dimensions
	$new_height = ceil($scale * $cur_y);

	return array($new_width, $new_height);
}

function resizeImage ($image, $max_x, $max_y, $fullpath) {
	$dimensions	= newDimensions(null, null, $max_x, $max_y, $image);
	$imagetype	= strtolower(image_type_to_mime_type(exif_imagetype($image)));

	switch ($imagetype) {
	  case 'image/jpeg' :
		$orig	= imagecreatefromjpeg($image);
	  break;
	  case 'image/png' :
		$orig	= imagecreatefrompng($image);
	  break;
	  case 'image/gif' :
		$orig	= imagecreatefromgif($image);
	  break;
	}

	$origSize	= getimagesize($image);
	#$output		= imagecreatetruecolor($dimensions[0], $dimensions[1]);
#	$output		= imagecreate($dimensions[0], $dimensions[1]);
	$output		= imagecreatetruecolor($dimensions[0], $dimensions[1]);
    imagecolortransparent($output, imagecolorallocate($output, 255, 255, 255, 0));
#	$bg 		= imagecolorallocate($output, 255, 255, 255, 127);

	if (!imagecopyresampled($output, $orig, 0, 0, 0, 0, $dimensions[0]+1, $dimensions[1]+1, $origSize[0], $origSize[1]) || !imagepng($output, "{$fullpath}.png", 0)) {
		return false;
	} else {
		@imagedestroy($orig);
		@imagedestroy($output);

		return true;
	}

}