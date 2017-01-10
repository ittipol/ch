<?php

namespace App\library;

use App\library\token;

class File
{
	private $file;
	private $fileName;
	private $fileType;
	private $maxFileSizes = array(
		'image' => 3145728,
		'pdf' => 1048576
	);
  private $acceptedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg', 'application/pdf'];
  private $temporaryPath = 'temporary/';

	public function __construct($file) {
	  $this->file = $file;
	  $this->generateFileName();

	  foreach (array('image','pdf') as $type) {
	   	if(!empty(strstr($this->file->getMimeType(), $type))) {
	   		$this->fileType = $type;
	   	}
	  }
	}

	private function generateFileName() {
	  $this->fileName = time().Token::generateNumber(15).$this->file->getSize().'.'.$this->file->getClientOriginalExtension();
	}

	public function getFileName() {
		return $this->fileName;
	}

	public function getOriginalFileName() {
		return $this->file->getClientOriginalName();
	}

	public function getFileType() {
		return $this->fileType;
	}

	public function checkFileType() {
		return in_array($this->file->getMimeType(), $this->acceptedFileTypes);
	}

	public function checkFileSize() {
		if($this->file->getSize() <= $this->maxFileSizes[$this->fileType]){
			return true;
		}
		return false;
	}

	public function temporaryFile() {
	  $this->file->move(storage_path($this->temporaryPath), $this->fileName);
	}

	public function getFilePath() {
		// return storage_path($this->temporaryPath).'/'.$filename;
	}

	// public function getMimeType() {
	//     // $mimetype = false;
	//     // if(function_exists('finfo_fopen')) {
	//     //     // open with FileInfo
	//     // } elseif(function_exists('getimagesize')) {
	//     //     // getimagesize($this->file);
	//     // } elseif(function_exists('exif_imagetype')) {
	//     //    // exif_imagetype($this->file)
	//     // } elseif(function_exists('mime_content_type')) {
	//     //    $mimetype = mime_content_type($filename);
	//     // }
	//     // return $mimetype;
	// }
}