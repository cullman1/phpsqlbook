<?php

ini_set( 'allow_url_fopen', 'false' );

function load_jpeg( $imgname ) {
	/* Attempt to open */
	$im = @imagecreatefromjpeg($imgname);
	/* See if it failed */
	if( !$im ){
		/* Create a black image */
		$im  = imagecreatetruecolor(150, 30);
		$bgc = imagecolorallocate($im, 255, 255, 255);
		$tc  = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
		/* Output an error message */
		imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
	}
	return $im;
}


function get_img_visual_center( $img ){
	$width = imagesx( $img );
	$height = imagesy( $img );
	$blocksize = 15;
	$nrof_winners = 15;
	$blocksx = floor( $width / $blocksize );
	$blocksy = floor( $height / $blocksize );
	$results = array();
	for( $bx=0; $bx<$blocksx; $bx++ ){
		//$line = array();
		$results[$bx] = array();
		for( $by=0; $by<$blocksy; $by++ ){
			$v = analyse_block( $img, $bx, $by, $blocksize );
			$results[$bx][$by] = $v;
			//$col = imagecolorallocate( $img, intval( $v * 255 * 5 ), 0, 0 );
			//imagefilledrectangle( $img, $bx*$blocksize, $by*$blocksize, $bx*$blocksize+$blocksize-2, $by*$blocksize+$blocksize-2, $col );
		}
	}
	$winners = get_top_blocks( $results, $nrof_winners );
	$xs = 0;
	$ys = 0;
	foreach( $winners as $w ){
		//$col = imagecolorallocate( $img, 255, 255, 255 );
		//imagerectangle ( $img, $w['x']*$blocksize, $w['y']*$blocksize, $w['x']*$blocksize+$blocksize, $w['y']*$blocksize+$blocksize , $col );
		//imagefilledrectangle( $img, $w['x']*$blocksize, $w['y']*$blocksize, $w['x']*$blocksize+$blocksize-2, $w['y']*$blocksize+$blocksize-2, $col );
		$xs += $w['x'];
		$ys += $w['y'];
	}
	// calculate and return the average x and y values from the top blocks
	$coords = array(
		'x' => round( ($xs*$blocksize) / $nrof_winners + $blocksize/2 ),
		'y' => round( ($ys*$blocksize) / $nrof_winners + $blocksize/2 )
	);
	return $coords;
}


function analyse_block( $img, $bx, $by, $blockSize ){
	$startx = $bx * $blockSize;
	$starty = $by * $blockSize;
	$variance = 0;
	$max_variance = $blockSize * 3 * 256 * 4;

	for( $run=0; $run<4; $run++ ){
		$prev_pixel = null;
		for( $i=0; $i<$blockSize; $i++ ){
			switch( $run ){
				case 0:
					$pixel = imagecolorat( $img, intval( $startx + $i ), floor( $starty + $blockSize/2 ) );
					break;
				case 1:
					$pixel = imagecolorat( $img, floor( $startx + $blockSize/2 ), intval( $starty + $i ) );
					break;
				case 2:
					$pixel = imagecolorat( $img, intval( $startx + $i ), intval( $starty + $i ) );
					break;
				case 3:
					$pixel = imagecolorat( $img, intval( $startx + $i ), intval( ($starty+$blockSize) - $i ) );
					break;
			}
			$r = ($pixel >> 16) & 0xFF;
			$g = ($pixel >> 8) & 0xFF;
			$b = $pixel & 0xFF;
			if( $prev_pixel != null ){
				$variance += abs( $r - $prev_pixel['r'] ) + abs( $g - $prev_pixel['g'] ) + abs( $b - $prev_pixel['b'] );
			}
			$prev_pixel = array( 'r' => $r, 'g' => $g, 'b' => $b );
		}
	}

	// return
	return $variance / $max_variance;
}


function get_top_blocks( $results, $nr ){
	$all = array();
	foreach( $results as $x=>$line ){
		foreach( $line as $y=>$v ){
			$a = array(
				'x' => $x,
				'y' => $y,
				'v' => $v
			);
			$all[] = $a;
		}
	}
	usort( $all, 'sort_blocks' );
	$winners = array_splice( $all, 0, $nr );
	return $winners;
}


function sort_blocks( $a, $b ){
	if( $a['v'] == $b['v'] ){
		return 0;
	}
	return ( $a['v'] < $b['v'] ) ? 1 : -1;
}


// start the output
header('Content-Type: image/png');

// load the image
$img_url = $_GET['img'];
$img = load_jpeg('../uploads/'. $img_url );

// gather the vars we need
$target_width = intval( $_GET['w'] );
$target_height = intval( $_GET['h'] );
$width = imagesx( $img );
$height = imagesy( $img );

// start a timer to clock how fast this is
$starttime = microtime();

// get the visual center of the image
$center = get_img_visual_center( $img );

// add some headers for debugging
header( 'X-Processing-Time: ' . ( microtime() - $starttime ) );
header( 'X-Crop-Center: x=' . $center['x'] . ',y=' . $center['y'] );

// crop the the correct aspect ratio, no scaling yet
$crop = array();

if( ( $target_width/$target_height ) > ( $width/$height ) ){
	// crop is "more landscape" than original, so we're cropping the y axis
	$crop['width'] = $width;
	$crop['height'] = $width * ( $target_height / $target_width );
	$crop['x'] = 0;
	$crop['y'] = round( $center['y'] - ($crop['height']/2) );
} else {
	// crop id "more portrait", so crop x axis
	$crop['height'] = $height;
	$crop['width'] = $height * ( $target_width / $target_height );
	$crop['x'] = round( $center['x'] - ($crop['width']/2) );
	$crop['y'] = 0;
}

// check crop coord against image dimensions
if( $crop['x'] < 0 ){
	$crop['x'] = 0;
}
if( $crop['y'] < 0 ){
	$crop['y'] = 0;
}
if( $crop['x'] > $width - $crop['width'] ){
	$crop['x'] = $width - $crop['width'];
}
if( $crop['y'] > $height - $crop['height'] ){
	$crop['y'] = $height - $crop['height'];
}

if( isset($_GET['demo']) && ($_GET['demo']== 'true' )){
	// demo mode, draw the crop area onto the image
	$col = imagecolorallocate( $img, 255, 255, 255 );
	imagerectangle ( $img , $crop['x'] , $crop['y'] , $crop['x']+$crop['width'] , $crop['y']+$crop['height'] , $col );
	imagerectangle ( $img , $crop['x']+1 , $crop['y']+1 , $crop['x']+$crop['width']-1 , $crop['y']+$crop['height']-1 , $col );
} else {
	// no demo, do the actual cropping and scaling
	$img = imagecrop ( $img, $crop );
	if( $target_width < $crop['width'] ){
		$img = imagescale( $img, $target_width, $target_height );
	}
}



imagepng( $img );

imagedestroy( $img );

?>