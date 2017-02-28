<?php
/**
 * JsonTemplate for PHPExcelForm classes.
 *
 * Copyright (c) 2017+ PHPExcelForm
 *
 * @category	JsonTemplate
 * @author 		Iurii Bell <ds@inbox.ru>
 * @license 	MIT
 * @copyright 	Copyright (c) 2017+ PhpExcelForm 
 */

namespace PhpExcelForm;

/**
* 
*/
class Schema
{

	public $template = null;
	public $data = null;


	function load( $filename, $spreadsheet = null ){
		if ( file_exists($filename)){
			$this->data = $this->precompile($filename, $spreadsheet);
			//$this->data = //(array) clone (object)$this->template;
		}
		if ( $spreadsheet ) $this->update($this->data, $spreadsheet);

		//$this->data->form[0]->value = "Новый проект";

		//if ( $spreadsheet ) $this->update($spreadsheet);
		return true;
	}





	function cell($value){
		if ( is_string($value)){
			if (preg_match("/#[A-Z]{1,2}\d{1,5}/", $value, $match)) {
				return $match;//substr($value,1);
			}
		}
		return false;
	}


	/*
	*   Preprocessor function from spreadsheet
	*	Make dynamic JSON  
	*/
	protected function precompile($filename, $spreadsheet){
		$content =  file_get_contents($filename);

		return json_decode($content);
	}



	/*
	*   Update function from spreadsheet
	*/
	protected function updatestring($match, $string, $spreadsheet){
		if ( is_array($match)){
			foreach ($match as $key => $value) {
				$cell = substr($value,1);
				$replace = $spreadsheet->getActiveSheet()->getCell($cell)->getCalculatedValue();
				$string = str_replace($value, $replace, $string);
				//\FB::info($match);
			}
		}
		return $string;
	}
	protected function update(&$jsonobj, $spreadsheet){
		if ( is_array($jsonobj)){
			foreach ($jsonobj as $key => &$value) {
				$this->updateelem($value,$spreadsheet);
			}
		}
	}

	protected function updateelem(&$jsonobj, $spreadsheet){
		if ( is_object($jsonobj)){
			foreach ($jsonobj as $key => &$value) {
				if ( $key == 'content') $this->update($value, $spreadsheet);
				$cell = $this->cell($value);
				if ($cell !== false){
					$value = $this->updatestring($cell, $value,$spreadsheet);
				}
			}

		}

	}




}