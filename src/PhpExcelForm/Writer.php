<?php

namespace PhpExcelWriter;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;


if (!defined('EOL')) {
    define('EOL', PHP_EOL );
}



class Writer{

	 protected $spreadsheet = null;
	 protected $filename = null;


	function load( $filename ){
		if ( file_exists($filename)){
			$this->filename = $filename;
			$this->spreadsheet = IOFactory::load( $this->filename );
		}
	}

	function save( $filename = null, $type = 'Excel2007' ){
		$writer =IOFactory::createWriter($this->spreadsheet, $type);
		if ( $filename == null){
			$writer->save($this->filename);
		}else{
			$writer->save($filename);
		}
	}

	function getSpreadsheet(){
		return $this->spreadsheet;
	}

}