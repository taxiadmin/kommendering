<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CDates
 *
 * @author peder
 */

class CDates {

    public $datum = array();

    public function __construct() {
        $this->parse_days();
    }

    private function parse_days() {
        $mo = 0;
        $yr = 0;
        $dates = array();
        if (isset($_GET['txi_date'])) {
            list($yr, $mo, $da) = explode('-', $_GET['txi_date']);
            $dates = array('day' => intval($da),
                'month' => intval($mo),
                'year' => intval($yr));
        } else {
            $dates = array('day' => date('d'),
                'month' => date('m'),
                'year' => date('Y'));
        }
        $dates['days_in_month'] = cal_days_in_month(CAL_GREGORIAN, $dates['month'], $dates['year']);
        $dates['year_month'] = $dates['year'] . '-' . sprintf('%02s', $dates['month']);

        $dates['offset'] = date('w', mktime(0, 0, 0, $mo, 1, $yr));
        // we must have a value in range 1..7
        if ($dates['offset'] == 0)
            $dates['offset'] = 7;
        $foo = $dates['year'] . '-' . $dates['month'] . '-1';
        $dates['date_array'] = $this->array_with_dates($foo, $dates['offset']);
        $this->datum = $dates;
        return $dates;
    }

//end parse days

    function array_with_dates($date, $offset) {
        $newdate = array();
        for ($datum = (-1 * $offset ) + 1; $datum < 43 - $offset; $datum++) {
            $find_day = $datum . ' day';
            $newdate1 = strtotime($find_day, strtotime($date));
            $newdate1 = date('Y-m-d', $newdate1);
            list($yr, $mo, $da) = explode('-', $newdate1);
            $newdate[$newdate1] = $dates['offset'] = date('W', mktime(0, 0, 0, $mo, $da, $yr));
            ;
        }

        return $newdate;
    }

    ########################################################################
    #
     # Prints the name of the day. Expects tu have the argument for short or full
    # name and day of the month.
    #
     #########################################################################

    function txi_day_name($short, $day) {

        $day_length = (!$short) ? 'l' : 'D';
        $name_of_day = __(date($day_length, mktime(0, 0, 0, $this->datum['month'], $day, $this->datum['year'])));
        $name_of_the_day = (!strpos($name_of_day, 195) ? substr($name_of_day, 0, 2) : substr($name_of_day, 0, 3));
        echo $name_of_the_day;
    }

//end txi_day_name
    ########################################################################
    #
       # Prints the year
    #
      ########################################################################

    function out_year() {
        _e($this->dates['year']);
    }

//end txi_year
    //########################################################################
    //Prints a link to the previous month
    //########################################################################

    function out_link_prev_month() {
        echo('<a href="?txi_date=' . date('Y-m-d', mktime(0, 0, 0, $this->datum['month'], 0, $this->datum['year'])) . '">&laquo;</a>');
    }

//end
    #######################################################################
    #
      # Prints a link to the next month
    #
      ########################################################################

    function out_link_next_month() {
        echo('<a href="?txi_date=' . date('Y-m-d', mktime(0, 0, 0, $this->datum['month'] + 1, 1, $this->datum['year'])) . '">&raquo;</a>');
    }

//end next_month

    function txi_month_name($short) {
        $day_length = (!$short) ? 'F' : 'M';
        $mont_name = __(date($day_length, mktime(0, 0, 0, $this->datum['month'], $this->datum['day'], $this->dates['year'])));
        echo ucfirst($mont_name);
    }

//end txi_month_name

    function out_txi_date() {
        echo "$this->datum['year']-$this->datum['month']-$this->datum['day']";
    }

//end txi_date
}
