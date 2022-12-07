<?php

require 'vendor/autoload.php';
header('Access-Control-Allow-Origin: *');

        $inputFileName = './empresas.xlsx';

        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /** Para leer una hoja especifica del Archivo */
        $reader->setLoadSheetsOnly(["Sheet 1", "Hoja2"]);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        $data = $spreadsheet->getActiveSheet()->toArray();


        $colums = array();
        $cols = 0;
        foreach ($data[0] as $value) {
            if ($value != null) {
                $colums[$cols++] = $value;
            }
        }

        $JsonGet = array();
        $resultado = array();

        for ($i = 1; $i < count($data); $i++) {
            $j = 0;
            foreach ($colums as $value) {
                $rowData = $data[$i][$j] != '' ?
                    $data[$i][$j]
                    :
                    "&nbsp";
                $auxiliarJson[$j] = array($value => $rowData);
                $j++;
            }

            if ($auxiliarJson) {
                foreach ($auxiliarJson as $value) {
                    $resultado = array_merge($resultado, $value);
                }
            }
            array_push($JsonGet, $resultado);
        }

        echo json_encode($JsonGet);
