<?php
include("DateHandler.php");
include("CsvHandler.php");
/**
 * Created by PhpStorm.
 * User: SimonM
 */
class SalaryDateUtil
{
    /**
     * @param null $fileName
     * @param null $year
     * This is the main function to execute , will generate the report
     */
    public function generate($fileName=null, $year=null) {
        /* date instantiation error suppressed */
        @$dh = new DateHandler($year);
        @$csvh = new CsvHandler((is_null($fileName) ? "PaymentsReport_".(is_null($year) ? date("Y") : $year) : $fileName).$year);

        $filePointer = $csvh->createFile();
        if (!$filePointer) {
            echo "Failed to create file in ". $csvh->getFilePath() . " dir,\n Exiting";
            exit;
        }
        print_r("the File has been successfully generated in ". $csvh->getFilePath().$csvh->getFullFileName()."\n");

        fputcsv($filePointer, $csvh->getCSVHeader());

        $bonusDates = $dh->getAMonthBonusPayDay();
        $paymentDates = $dh->getAMonthsPayDaysArray();

        for ($i=1; $i<13; $i++) {
            $array = array(
                @DateTime::createFromFormat("!m", $i)->format('F'),
                $paymentDates[$i][1].", ".$paymentDates[$i][0],
                $bonusDates[$i][1].", ".$bonusDates[$i][0],
            );
            fputcsv($filePointer, $array);
        }
    }

}