<?php 

namespace PhpExcelForm\PhpExcelFormTests;


use PhpExcelForm\Writer;
use PhpExcelForm\Form;



class SampleTest
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @dataProvider providerSample
     *
     * @param mixed $sample
     */
    public function testSample($sample)
    {
        // Suppress output to console

 /*       $writer = new Writer();

        $form = new Form();


             

        $writer->load($sample.'.xlsx');

        $form->load($sample.'.json', $writer->getSpreadsheet() );   
        

        \FB::log($form);


        $writer->save($sample.'_output.xlsx');  

        \FB::log('testSmple ok');

        //\PhpOffice\PhpSpreadsheet\IOFactory::load($sample);
/*
        $helper = new Sample();


        $spreadsheet->getProperties()
        ->setCreator('Maarten Balliauw')
        ->setLastModifiedBy('Maarten Balliauw')
        ->setTitle('PhpSpreadsheet Test Document')
        ->setSubject('PhpSpreadsheet Test Document')
        ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
        ->setKeywords('office PhpSpreadsheet php')
        ->setCategory('Test result file');


        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Hello')
        ->setCellValue('B2', 'world!')
        ->setCellValue('C1', 'Hello')
        ->setCellValue('D2', 'world!');

        \FB::log($sample);
*/
        // Save



        //$helper->write($spreadsheet, $sample.'_output.xlsx', ['Excel2007' => 'xlsx', 'Excel5' => 'xls', 'HTML' => 'html']);

        //$spreadsheet->SetActiveSheet(0);


         //$writer =IOFactory::createWriter($spreadsheet, 'Excel2007');

        //$writer->save($sample.'_output.xlsx');

        


        return $sample;
    }


}