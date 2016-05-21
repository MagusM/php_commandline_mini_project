<?php

/**
 * Created by PhpStorm.
 * User: SimonM
 */
class CsvHandler
{
    private $fileName;
    private $filePointer;
    private $path;

    function __construct($fileName) {
        $this->fileName = $fileName;
        $this->path = $this->getTempPath();
    }

    /**
     * @return string | file name
     */
    public function getFullFileName() {
        return $this->fileName.".csv";
    }

    /*
     * @return string | the path to saved file
     */
    private function getTempPath() {
        return getcwd()."/PaymentTask/";
    }

    /**
     * @return string | path to saved file
     */
    public function getFilePath() {
        return $this->path;
    }

    /**
     * @return resource | pointer of created file
     */
    public function createFile() {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
        $this->filePointer = fopen($this->getFilePath().$this->getFullFileName(), "a+");
        return $this->filePointer;
    }

    /**
     * @return array | CSV header
     */
    public function getCSVHeader() {
        return array(
            'Month Name',
            'Salary Payment Date',
            'Bonus Payment Date'
        );
    }

}
