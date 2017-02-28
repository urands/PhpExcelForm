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
			if (preg_match_all("/#[A-Z]{1,2}\d{1,5}/", $value, $match)) {
				return $match;//substr($value,1);
			}
		}
		return false;
	}


	function postcell($value){
		if ( is_string($value)){
			if (preg_match_all("/^[A-Z]{1,2}\d{1,5}$/", $value, $match)) {
				return $value;//substr($value,1);
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

		$content = $this->precompilecontent($content,$spreadsheet);

		//\FB::log($content);

		return json_decode($content);
	}

	protected function precompilecontent($content, $spreadsheet){
		if ( preg_match_all("/\/\*(.*?)\*\//", $content, $match)){
			//$match[0] = array_reverse($match[0]);
			//$match[1] = array_reverse($match[1]);
			foreach ( $match[0] as $key => $value) {

				$precompile = trim($match[1][$key]);
				$startpos = strpos($content, $value);
				if ( strtolower(substr($precompile, 0, 3)) == "for" ){
					$cell = $this->cell($precompile);
					if ( $cell !== false ){
						$precompile = $this->updatestring($cell,$precompile,$spreadsheet);
						$content = str_replace(trim($match[1][$key]), $precompile, $content);
						\FB::info($precompile);
						\FB::info($value);
					}
				}
			}
		}
		$content = $this->renderpart_adv($content);
		\FB::log($content);
		return $content;
	}

	protected function precompilecontentfor($content, $spreadsheet){



	}

	public static function addr($col, $row){ return chr( ord('A')+$col).$row; }



	protected function renderpart_adv($compilepart ){
		$eval = "";
		if ( preg_match_all("/\/\*(.*?)\*\//", $compilepart, $match)){
			foreach ($match[0] as $key => $value){
				$stpos = strpos($compilepart, $value);
								
				$eval.= 'echo  "'.str_replace("\"","\\\"", substr($compilepart,0,$stpos)).'";'.PHP_EOL;

				$compilepart = substr($compilepart, $stpos+strlen($value));

				//\FB::error($compilepart);
				if ( trim($match[1][$key]) == 'endfor'){
					$eval.="}".PHP_EOL;
				}else if  (strtolower(substr(trim($match[1][$key]), 0, 3)) == "for") {
					$eval.=$match[1][$key]."{".PHP_EOL;
				}else{
					$eval.=$match[1][$key].PHP_EOL;;
				}
			}

			$eval.= 'echo  "'.str_replace("\"","\\\"", $compilepart).'";'.PHP_EOL;

		}else{
			$eval.= 'echo  "'.str_replace("\"","\\\"", $compilepart ).'";';
		}
		//$eval.= "}";
		//\FB::log($eval);
		ob_start();
		eval($eval);
		return ob_get_clean();
	}






	protected function renderpart($compilepart, $compile_start, $compile_end = null){
		$eval = $compile_start."{".PHP_EOL;
		if ( preg_match_all("/\/\*(.*?)\*\//", $compilepart, $match)){
			foreach ($match[0] as $key => $value){
				$stpos = strpos($compilepart, $value);
				$eval.= 'echo  "'.str_replace("\"","\\\"", substr($compilepart,0,$stpos)).'";'.PHP_EOL;
				$compilepart = substr($compilepart, $stpos+strlen($value));
				if ( trim($match[1][$key]) == 'endfor'){
					$eval.="}".PHP_EOL;
				}else if  (strtolower(substr(trim($match[1][$key]), 0, 3)) == "for") {
					$eval.=$match[1][$key]."{".PHP_EOL;
				}else{
					$eval.=$match[1][$key].PHP_EOL;;
				}
			}
			$eval.= 'echo  "'.str_replace("\"","\\\"", $compilepart).'";'.PHP_EOL;

		}else{
			$eval.= 'echo  "'.str_replace("\"","\\\"", $compilepart ).'";';
		}
		$eval.= "}";
		\FB::log($eval);
		ob_start();
		eval($eval);
		return ob_get_clean();
	}

	


	protected function getcompilepart($contentpart, $endkeyword){
		if ( preg_match_all("/\/\*(.*?)\*\//", $contentpart, $match)){

			if (isset($match[0]) ){
				$level = 0;
				$getpos = 0;
				foreach ($match[0] as $key => $value){
					if ( strtolower(substr(trim($match[1][$key]), 0, 3)) == "for" ){
						 $level++;
					 	
					}
					if ( (trim($match[1][$key]) == $endkeyword) && ($level <= 0) ){
						$shift = substr($contentpart,$getpos+1);
						$realpos = strpos($shift, $match[0][$key] );
						return substr($contentpart,0,$getpos+$realpos+1);
					}else{
						if (trim($match[1][$key]) == $endkeyword) {
							$level--;
							$getpos = strpos($contentpart, $match[0][$key] );
						}
					}
				}
			}

		}
		return null;
	}

	protected function removeendpart($content,$offset, $endkeyword){
		$contentpart = substr($content, $offset);
		if ( preg_match_all("/\/\*(.*?)\*\//", $contentpart, $match)){

			if (isset($match[0]) ){
				foreach ($match[0] as $key => $value){
				if ( trim($match[1][$key]) == $endkeyword ){
					$getpos = strpos($content, $match[0][$key] );
					$content = substr($content, 0, $getpos).substr($content, $getpos+strlen($value));
					return $content;
				}
				}
			}

		}
		return null;
	}


	/*
	* Commit changes
	*/
	public function commit($request,  $spreadsheet){
		foreach ($request as $key => $value) {
			$cell = $this->postcell($key);
			if ( $cell!== false ){
				$spreadsheet->getActiveSheet()->getCell($cell)->setValue($value);
			}
		}
		
	}



	/*
	*   Update function from spreadsheet
	*/
	protected function updatestring($match, $string, $spreadsheet){
		if ( is_array($match)){
			if ( is_array($match[0])){
			foreach ($match[0] as $key => $value) {
				$cell = substr($value,1);
				$replace = $spreadsheet->getActiveSheet()->getCell($cell)->getCalculatedValue();
				$string = str_replace($value, $replace, $string);
				//\FB::info($match);
			}
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