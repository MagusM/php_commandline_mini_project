<?php

/**
 * Created by PhpStorm.
 * User: SimonM
 */
class DateHandler
{
    /**
     * @var array | 0->day as a number, 1-> day name
     */
    private $lastBasePayDay;
    /**
     * @var array | 0->day as a number, 1-> day name
     */
    private $lastBonusPayDay;
    /**
     * @var int | year
     */
    private $year;

    function __construct($year=null) {
        is_null($year) ? $this->year = date("Y") : $this->year = $year;
        $this->lastBasePayDay = $this->getAMonthsPayDaysArray();
        $this->lastBonusPayDay = $this->getAMonthBonusPayDay();
    }

    /**
     * @return array | 0->day as a number, 1-> day name
     */
    public function getAMonthsPayDaysArray() {
        $arrayToReturn = array();
        for ($i=1; $i<13; $i++) {
            $arrayToReturn[$i] = $this->getPayDayArray($i);
        }
        return $arrayToReturn;
    }

    /**
     * @param $month | int
     * @param null $day | int
     * @return array | 0->day as a number, 1-> day name
     */
    public function getPayDayArray($month, $day=null) {
        is_null($day) ? $dayNum = cal_days_in_month(CAL_GREGORIAN, $month, $this->year) : $dayNum = $day;
        @$dayName = date('D', strtotime($this->year."-".$month."-".$dayNum));
        switch ($dayName) {
            case "Sat":
                $dayNum -= 2;

                break;
            case "Fri":
                $dayNum -= 1;
                break;
        }
        @$dayName = date('D', strtotime($this->year."-".$month."-".$dayNum));
        return array($dayNum, $dayName);
    }

    /**
     * @return array | 0->day as a number, 1-> day name
     */
    public function getAMonthBonusPayDay() {
        $arrayToReturn = array();
        for ($i=1; $i<13; $i++) {
            $arrayToReturn[$i] = $this->getPayDayArray($i, 15);
        }
        return $arrayToReturn;
    }

    /**
     * @return int|null|year
     */
    public function getYear() {
        return $this->year;
    }

}