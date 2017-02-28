<?php

namespace PhpExcelForm;


use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Form{


	protected $template = null;
	protected $data = null;


	function load( $filename, $spreadsheet = null ){
		if ( file_exists($filename)){
			$this->template = json_decode(file_get_contents($filename));
			
		}
		if ( $spreadsheet ) $this->upload($spreadsheet);

		//$this->data->form[0]->value = "Новый проект";

		//if ( $spreadsheet ) $this->update($spreadsheet);
	}


	protected function upload($spreadsheet){
		if ( $spreadsheet && $this->template ){

			if ( property_exists($this->template, 'sheet' )  ){
				$spreadsheet->setActiveSheetIndex($this->template->sheet);
				$this->data = new \stdClass();
				if ( property_exists($this->template, 'caption' ) )     $this->data->caption = $spreadsheet->getActiveSheet()->getCell($this->template->caption)->getCalculatedValue();
				if ( property_exists($this->template, 'description' ) ) $this->data->description = $spreadsheet->getActiveSheet()->getCell($this->template->description)->getCalculatedValue();

				if ( property_exists($this->template, 'form' ) ){
					foreach( $this->template->form as $key => $input ){
						$this->data->form[$key] = new \stdClass();
						foreach( $input  as $keyinput => $value ){
							if ( $keyinput == "type") {
								$this->data->form[$key]->$keyinput = $value;
							}else{
								$this->data->form[$key]->$keyinput = $spreadsheet->getActiveSheet()->getCell($value)->getCalculatedValue();
							}
						}
					}
				}
				
			}

		}
	}


	protected function update($spreadsheet){
		if ( $spreadsheet && $this->template ){
			if ( property_exists($this->template, 'sheet' )  ){
				$spreadsheet->setActiveSheetIndex($this->template->sheet);
				
				if ( property_exists($this->template, 'form' ) ){
					foreach( $this->template->form as $key => $input ){
						foreach( $input  as $keyinput => $value ){
							if ( $keyinput == "type") {
								$this->data->form[$key]->$keyinput = $value;
							}else{
								$spreadsheet->getActiveSheet()->getCell($value)->setValue( $this->data->form[$key]->$keyinput );
							}
						}
					}
				}
				
			}

		}



	}







}