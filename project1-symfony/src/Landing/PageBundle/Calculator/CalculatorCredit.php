<?php

namespace Landing\PageBundle\Calculator;


class CalculatorCredit
{

    private $sum;               // сумма кредита
    private $sum_month;         // размер ежемесячных выплат
    private $percent;           // процентная ставка
    private $percent_month;     // процент в месяц
    private $time;              // срок кредита
    private $month;             // месяц выдачи кредита
    private $one_month_pay;     // первый месяц взноса
    private $count_month = 12;  // количество месяцев в году
    private $calculation;       // данные для построения таблицы расчета

    /**
     * @param $sum
     * @param $percent
     * @param $time
     * @param $month
     * конструктор
     */
    function __construct($sum, $percent, $time, $month)
    {
        $this->sum = $sum;
        $this->percent = $percent;
        $this->percent_month = $this->percent / $this->count_month;
        $this->time = $time;
        $this->month = $month;
        $this->one_month_pay = strtotime('+1 month', $month);
        $this->sum_month = (
                (((1 + $this->percent_month / 100) ** $this->time) * ($this->percent_month / 100)) /
                (((1 + $this->percent_month / 100) ** $this->time) - 1)) * $this->sum;

        $debd = round($this->sum / $this->time, 2);               // основной долг
        $rest = round($this->sum - $debd, 2);                     // остаток
        $percent_pay = ($this->sum * $this->percent_month) / 100; // проценты
        $contribution = $debd + $percent_pay;                     // взнос

        for ($i = 1; $i <= $this->time; $i++) {

            $this->calculation->result[] = [
                'month' => strtotime('+' . $i . ' month', $month), // месяц
                'debd' => $debd,                                   // основной долг
                'rest' => $rest,                                   // остаток
                'percent_pay' => $percent_pay,                     // проценты
                'contribution' => $contribution,                   // взнос
            ];

            if ($i == $this->time-1){
                $debd = $rest;
            }

            $percent_pay = ($rest * $this->percent_month) / 100; // проценты
            $contribution = $debd + $percent_pay;                // взнос
            $rest = round($rest - $debd, 2);                     // остаток

        }

    }

    /**
     * return $sum
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * return $percent
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * return $time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * return $sum_month
     */
    public function getSumMonth()
    {
        return $this->sum_month;
    }

    /**
     * return $month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * return $one_month_pay
     */
    public function getOneMonthPay()
    {
        return $this->one_month_pay;
    }

    /**
     * return $calculation
     */
    public function getCalculation()
    {
        return $this->calculation;
    }

}