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
class JsonTemplate
{

	/**
	* 
	*/
	function render($jsonobj = null){
		if ( is_array($jsonobj) ){
			$html = '';
			foreach ($jsonobj as $key => $item) {
				$html.=$this->renderelem($item).PHP_EOL;
			}
			return $html;
		}else {
			return $jsonobj;
		}

	}

	/**
	* 
	*/
	function renderelem($item){
		
		if (is_object($item) ){
			if ( property_exists($item, "elem")) {
				$key = $item->elem;
			}else{
				return '';
			}
			$elem = "<$key";
			foreach ($item as $attr => $value) {
				if ( $attr!="content" && $attr!="elem" ){
					if (!is_object($value)) $elem.=" $attr=\"$value\"";
				}
			}
			if ( property_exists($item, "content")){
				if ( is_array($item->content)){
					$elem.=">".$this->render($item->content)."</$key>";
				}else{
					$elem.=">".$item->content."</$key>";
				}
			}else{
				$elem.=" />";
			}
		}else{
			if ( is_null($item) ){
				$elem="";
			}else{
				$elem="<p>$item</p>";
			}
		}
		return $elem;
	}

}





