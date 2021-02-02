<?php

function doUpload($data = NULL){
	if($data == NULL){
		return FALSE;
	}else{
		if(!is_array($data)){
			return FALSE;
		}else{
			$msg = '';

			$file = (isset($data['file'])) ? $data['file'] : $msg .= '<p>File not found.</p>';
			$path = (isset($data['path'])) ? $data['path'] : $msg .= '<p>Path is not defined.</p>';
			$type = (isset($data['allow_type'])) ? $data['allow_type'] : '';
			$size = (isset($data['allow_size'])) ? $data['allow_size'] : '';

			if($msg != ''){
				return $msg;
			}else{

				$fileOriginalName = $file->getClientOriginalName();
				$fileExtension = $file->guessExtension();
				$fileSize = $file->getSize();
				$fileRealPath = $file->getRealPath();

				$isImage = isImage($fileRealPath);

				if($type != ''){
					$allowedType = explode('|',$type);
					if(! in_array(mime_content_type($fileRealPath), $allowedType) ){
						return [
							'response'=>'error',
							'code'=>406,
							'message'=>'<p>File yang anda upload tidak diizinkan.</p>'
						];

						exit;
					}
				}

				if($size != ''){
					$allowedSize = $size * 1000;
					if($fileSize > $allowedSize){
						return [
							'response'=>'error',
							'code'=>406,
							'message'=>'<p>File yand anda upload melebihi batas maksimal yang diizinkan.</p>'
						];

						exit;
					}
				}
				
				$newFileName = date('Ymd').'_'.md5(uniqid(time().$fileOriginalName, true)) .'.'. $fileExtension;
				$file->move($path, $newFileName);

				return [
					'response'=>'ok',
					'code'=>200,
					'message'=>'<p>File berhasil di upload.</p>',
					'data'=>[
						'originName'=>$fileOriginalName,
						'randomName'=>$newFileName,
						'path'=>URL::to('/').'/'.$path.$newFileName,
						'ext'=>$fileExtension,
						'size'=>$fileSize,
						'isImage'=>$isImage
					]
				];
			}
		}
	}
}

function isImage($file = NULL){
	$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
	$contentType = mime_content_type($file);

	if(! in_array($contentType, $allowedMimeTypes) ){
		return 0;
	}else{
		return 1;
	}
}