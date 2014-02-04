<?php

// This is the template to markup your thumbnails. See readme for possible placeholders.
$tpl = <<<HTML
<a href="[+dr.bigPath+]" class="highslide" onclick="return hs.expand(this, {captionId: 'caption[+dr.id+]'})">
	<img src="[+dr.thumbPath+]" width="[+dr.thumbWidth+]" height="[+dr.thumbHeight+]" /></a>
<div class="highslide-caption" id="caption[+dr.id+]">
[+dr.title+]
</div>
HTML;

// All CSS and JS files and all other code that we need in our <HEAD> tag.
$header  = 	'
<link rel="stylesheet" href="'.DIRECTRESIZE_PATH.'libs/highslide/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="'.DIRECTRESIZE_PATH.'libs/highslide/highslide.packed.js"></script>
<script type="text/javascript" src="'.DIRECTRESIZE_PATH.'lang/russian.highslide.js"></script>
<script type="text/javascript">
	hs.graphicsDir	= "'.DIRECTRESIZE_PATH.'libs/highslide/graphics/";
	hs.outlineType 	= "rounded-white";
</script>

';

// Mode for lightbox links generating. 2 means that links will be genereted for all images with the allowed paths.
$lightbox_mode = 2;
$thumb_default_width = 420;

// Watermarking. Uncomment 3 lines below if you are need it.
$thumb_use_watermark = FALSE;
$thumb_watermark_img = 'assets/images/znak.png';
$thumb_watermark_type = "image";
$thumb_watermark_halign = 'center';
$big_use_watermark = 1;

// Very important parameter - paths to folders, where the images will be proccesed. Use comma as separator. You can use remote paths with http://.
$allow_from="assets/images";

// Method for thumbs generating. 0 means that firstly image is reduced, then it is cropped to fit in the rectangle thumb width х thumb height.
$resize_method = 0;



?>