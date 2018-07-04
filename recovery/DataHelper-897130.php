<?php

use App\Http\Controllers\General\DetectImageController;

static $detectImageInit = false;
// ---------------------------------------------------------------------
// generate route url
// generate name url and name controller
// ---------------------------------------------------------------------

function dataLinks($total, $count){

	$getArgs = request()->query();

	$total = isset($total) ? $total : null;
	$count = isset($count) ? $count : 25;
	$page = isset($getArgs['page']) ? $getArgs['page'] : 1;
	$url = '?em';

	if($total > $count){
		$pages = ceil($total / $count);

		foreach($getArgs as $key => $value){

			if($key != 'page' && !is_array($value))
				$url .= "&$key=$value";

			if($key != 'page' && is_array($value))
				foreach($value as $optionKey => $optionValue)
					$url .= "&$key".'[]'."=$optionValue";

		}

		if(($pages - $page) > 5){
			$rightPages = $page + 4;
			$leftPages = ($page <= 5) ? 1 : $page - 4;
		}else{
			$rightPages = $pages;
			$leftPages = ($page <= 5) ? 1 : $page - 4;
		}

		return view(
			'general.layouts.content.paginate_content',
			compact('page', 'url', 'rightPages', 'leftPages')
		);
	}

	return null;
}

// ---------------------------------------------------------------------
// save profile image for fallback
// method save content image
// ---------------------------------------------------------------------

function saveProfileImage($image_path, $image_url, $image_all){

	$image_name = substr(
		$image_url,
		strrpos($image_url, '/') + 1
	);

	if(!array_search($image_name, $image_all)){

		$detectImg = imageDetect(
			$image_url,
			$image_name,
			$image_path
		);

		if($detectImg)
			return true;

		return file_put_contents(
			$image_path.$image_name,
			@file_get_contents($image_url)
		);
	}

	return false;

}

// ---------------------------------------------------------------------
// delete profiles images for fallback
// method delete content image with diff
// ---------------------------------------------------------------------

function dropProfileImages($image_path, $images_url = null, $image_all){

	foreach($images_url as $imgUrl)
		$image_name[] = substr(
			$imgUrl,
			strrpos($imgUrl, '/') + 1
		);


	foreach($image_all as $imgProfile)
		if(!in_array($imgProfile, $image_name))
			@unlink($image_path.$imgProfile);

}

// ---------------------------------------------------------------------
// cache images
// method return content image
// ---------------------------------------------------------------------

function imageCache($pictures, $path = 'images', $time){

	if(is_array($pictures)){

		foreach($pictures as $picture){

			$imgProfile = substr(
				$picture,
				strrpos($picture, '/') + 1
			);

			if(!cache($imgProfile)){

				$image_content = @file_get_contents(
					public_path().
					$path.
					$imgProfile
				);

				if(empty($image_content))
					$image_content = @file_get_contents(
						$picture
					);

				if(env('CACHE', false))
					cache()->add(
						$imgProfile,
						$image_content,
						$time
					);

				if(cache($imgProfile))
					$tmp['pictures_cache'][] = cache($imgProfile);
				else
					$tmp['pictures_cache'][] = $image_content;

			}else{

				if(cache($imgProfile))
					$tmp['pictures_cache'][] = cache($imgProfile);

			}

		}

		return @$tmp['pictures_cache'];

	}else{

		$imgName = "http://cams.images-dnxlive.com/snapshots/".
					$pictures.
					'_webcam_260x195.jpg';

		$pictureCacheName = $pictures.'_cache';


		if(!cache($pictureCacheName)){

			$image_content = @file_get_contents(
				public_path().
				$path.
				$pictures.
				'_webcam_260x195.jpg'
			);

			if(empty($image_content))
				$image_content = @file_get_contents(
					$imgName
				);

			if(env('CACHE', false))
				cache()->add(
					$pictureCacheName,
					$image_content,
					$time
				);

			if(cache($pictureCacheName))
				$tmp['pictures_cache'] = cache($pictureCacheName);
			else
				$tmp['pictures_cache'] = $image_content;

		}else{

			$tmp['pictures_cache'] = cache($pictureCacheName);

		}

		return $tmp['pictures_cache'];

	}

	return null;

}

function imageDetect($image, $name, $path, $blur = 50){

	global $detectImageInit;

	if(!$detectImageInit){

		DetectImageController::init();
		DetectImageController::setDetectType();
		$detectImageInit = true;

	}

	DetectImageController::setImage($image);
	$response = DetectImageController::getResponse();

	$response = $response->safeSearchAnnotation;

	$checkLikey = (
		$response->adult != "VERY_LIKELY" and
		$response->adult != "LIKELY"
	);

	if($checkLikey) return false;

	$image = imagecreatefromjpeg($image);

	foreach(range(0, $blur) as $i){

		imagefilter($image, IMG_FILTER_PIXELATE, 6, 1);

	}

	return imagejpeg($image, $path.$name);

	imagedestroy($image);

}
