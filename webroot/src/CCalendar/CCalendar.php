<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CCalendar
 *
 * @author peder
 */
class CCalendar {

    public $datum = array();
    private $calendar_data = [];
    public $the_calendar = [];

    public function __construct() {
        checkLogin();
        $this->dates = $this->parse_days();
        $this->create_calendar();
        $this->update_calendar();
        $this->fetch_calendar();
        $this->pass_link();
//      $this->get_drivers( true );
//      $this->fetch_calendar() ;
    }

// end construct

    public function parse_days() {
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
        $dates['date_array_calendar'] = $this->array_with_dates($foo, $dates['offset']);
        $this->datum = $dates;
        return $dates;
    }

//end parse days

    public function array_with_dates($date, $offset) {
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

    public function day_name($short, $day = null, $date = null) {

        $day_length = (!$short) ? 'l' : 'D';
        if (empty($date)) {
            $day = date($day_length, mktime(0, 0, 0, $this->datum['month'], $day, $this->datum['year']));
        } else {
            $year = substr($date, 2, 2);
            $day = substr($date, 8, 2);
            $month = substr($date, 5, 2);
            $day = date($day_length, mktime(0, 0, 0, $month, $day, $year));
        }
        $day = (!strpos($day, 195) ? substr($day, 0, 2) : substr($day, 0, 3));
        switch ($day) {
            case "Mo";
                $day = "M&aring;";
                break;
            case 'Tu';
                $day = "Ti";
                break;
            case "We";
                $day = "On";
                break;
            case "Th";
                $day = "To";
                break;
            case "Fr";
                $day = "Fr";
                break;
            case "Sa";
                $day = "L&ouml;";
                break;
            case "Su";
                $day = "S&ouml;";
                break;
        }
        $day = $day;
        return $day;
    }

//end txi_day_name
    ########################################################################
    #
       # Prints the year
    #
      ########################################################################

    public function out_year() {
        return $this->dates['year'];
    }

//end txi_year
    //########################################################################
    //Prints a link to the previous month
    //########################################################################

    public function out_link_prev_month() {
        return ('<a href="?txi_date=' . date('Y-m-d', mktime(0, 0, 0, $this->datum['month'], 0, $this->datum['year'])) . '">&laquo;</a>');
    }

//end
    #######################################################################
    #
      # Prints a link to the next month
    #
      ########################################################################

    public function out_link_next_month() {
        return '<a href="?txi_date=' . date('Y-m-d', mktime(0, 0, 0, $this->datum['month'] + 1, 1, $this->datum['year'])) . '">&raquo;</a>';
    }

//end next_month

    public function txi_month_name($short) {
        $day_length = (!$short) ? 'F' : 'M';
        $mont_name = date($day_length, mktime(0, 0, 0, $this->datum['month'], $this->datum['day'], $this->dates['year']));
        return ucfirst($mont_name);
    }

//end txi_month_name

    public function out_txi_date() {
        return "$this->datum['year']-$this->datum['month']-$this->datum['day']";
    }

//end txi_date

    private function fetch_calendar() {
        global $db;

        $sql = "SELECT cab, pass, start_date AS date, driver AS driver, id , start_time, end_time
              FROM cab_pass
              WHERE start_date LIKE ?
              AND type = 1
              ORDER BY pass, cab, start_date;";

        $row = $db->query_DB($sql, array($this->datum['year_month'] . "-%"), FALSE);
        $calendar_data = [];
        if ($row) {
            do {
                $calendar_data[$row->date][$row->cab][$row->pass]['driver'] = $row->driver;
                $calendar_data[$row->date][$row->cab][$row->pass]['id'] = $row->id;
                $calendar_data[$row->date][$row->cab][$row->pass]['start_time'] = $row->start_time;
                $calendar_data[$row->date][$row->cab][$row->pass]['end_time'] = $row->end_time;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        $this->calendar_data = $calendar_data;
    }

    private function pass_link() {
        global $user;
        $users = $user->users();
        $day_in_month = 1; //räknare för att skapa dagnummera
        foreach ($this->calendar_data as $datum => $cab) {
            $day_name = $this->day_name(true, FALSE, $datum);
            $sunday = '';
            if($day_name == 'S&ouml;'){
            $sunday =  'sunday' ;
            $day_css = 'cal-date-name-field_sun';
            }elseif ($day_name == 'M&aring;'){
            $day_css =  'cal-date-name-field_mon';
            }else{
            $day_css =  '';
            }
            $pass_row = "<div class='cal-form-row {$sunday}'>\n<div class='cal-date-name-field {$day_css}'>\n{$day_name}\n</div>\n<div class='cal-date-name-field {$day_css}'>\n{$day_in_month}\n</div>\n";
            $cab_row = "<div class='cal-form-row cal_sub_heading'>\n<div class='cal-date-name-field'>\n</div>\n<div class='cal-date-name-field'>\n</div>\n";
            $pass_name_row = "<div class='cal-form-row cal_sub_heading'>\n<div class='cal-date-name-field'>\n</div>\n<div class='cal-date-name-field'>\n</div>\n";
            foreach ($cab as $cabdata => $pass) {
                $cab_row .= "<div class='bil-rubrik'>\n{$cabdata}\n</div>";
                $pass_name_row .= "<div class='pass-rubrik'>\nDag\n</div>\n<div class='pass-rubrik'>\nNatt\n</div>\n";
//                $the_calendar[$pass][]= ( $pass == 0) ? "<div class='bil-day'>" : "<div class='bil-night'>";
                foreach ($pass as $passdata) {
                    $pass_row .= $this->skapa_kalenderpost($passdata, $datum, $users);
                }
            }
            $this->the_calendar['pass'][] = $pass_row . "</div><!--efter row-->\n";
            $day_in_month = $day_in_month + 1;
        }
        $this->the_calendar['cab'] = !empty($cab_row) ? $cab_row . "</div><!--efter row-->\n" : '';
        $this->the_calendar['pass_name'] = !empty($pass_name_row) ? $pass_name_row . "</div><!--efter row-->\n" : '';
    }

    private function redigera_post($datum, $driver) {
        global $user;
        // skapavariabel med datum förare kan ändra datum från
        static $driver_change = DRIVER_CHANGE; // Antal dagar för möjlighet till redigering. Konstant sätts i config.php
        $retur = ''; //
        //Först gör vi det möjligt att redigera sin post om datumet är det antal dagar framåt som satts i config
        if ($datum > date('Y-m-d', strtotime("+{$driver_change} days")))
        {
            echo $user->user_role();
            $retur = ($driver === $user->id() || empty($driver && $user->user_role() < 11)) ? ' redigera' : '';
        }
        elseif ($datum >= date('Y-m-d'))
        {
        //sedan ger vi möjlighet att sätta in sig på en fridag.
            $retur = ($driver === $user->id() && empty($driver)) ? ' redigera' : '';
        }
        //sist ... Admin får alltid korrigera
        $retur = ($user->user_role() == 1) ? ' redigera' : $retur;

        return $retur;
    }

    private function skapa_kalenderpost($passdata, $datum, $users) {
        $redigera = $this->redigera_post($datum, $passdata['driver']);
        if (empty($passdata['driver']) && empty($redigera)) {
            $driver = "";
        } elseif (empty($passdata['driver'])) {
            $driver = '-----';
        } else {
            $driver = $users[$passdata['driver']]['display_name'];
        }
        $free_day = ( empty($passdata['driver']) && !empty($redigera)) ? ' free-day' : '';
        $link = "<div id='{$passdata['id']}' class='calendarpost pass {$redigera} {$free_day} {$datum}' data-tooltip='tip1'  calendar-id='{$passdata['id']}' ";
        $link .= "pass-time='{$passdata['start_time']}-{$passdata['end_time']}' calendar-type='{$passdata['id']}'>\n";
        $link .= $driver . "\n";
        $link .= "</div><!-- efter pass -->\n";
        return $link;
    }

    public function calendar_data() {
        return $this->calendar_data;
    }

    private function update_calendar() {
        if (isset($_POST['update'])) {
            global $db;
            $sql = "UPDATE cab_pass SET driver=? WHERE id=?;";
            foreach ($_POST['driver'] as $id => $value) {
                $succed = $db->DB_execute($sql, array($value, $_POST['post_id'][$id]), FALSE);
            }
        }
    }

//end update_calendar
    function create_calendar() {
        if (isset($_POST['create'])) {
            global $db;
            global $dates;
            $datum_array = $dates->datum;
            $cab_class = new CCab;
            $cabs = $cab_class->cabs();
            $sql = "INSERT INTO cab_pass (cab, pass, start_date, end_date, start_time, end_time, type) VALUES (?, ?, ?, ?, ?, ?,?);";

            foreach ($cabs as $node) {

                $cab = $node->cab;
                $pass_tider = unserialize($node->pass_time);
                for ($pass = 0; $pass < 2; $pass++) {
                    $pass_tid = 'pass' . $pass . '_';
                    for ($datum = 1; $datum <= $datum_array['days_in_month']; $datum++) {
                        $start_date = $datum_array['year_month'] . '-' . sprintf('%02s', $datum);
                        $day_in_week = jddayofweek(cal_to_jd(CAL_GREGORIAN, intval($datum_array['month']), intval($datum), intval($datum_array['year'])), 0);
                        if ($pass_tider[$day_in_week][$pass_tid . 'start'] < $pass_tider[$day_in_week][$pass_tid . 'stop']) {
                            $end_date = $start_date;
                        } else {
                            $end_date = date('Y-m-d', strtotime('1 day', strtotime($start_date)));
                        } #end if
                        $start_time = $pass_tider[$day_in_week][$pass_tid . 'start'] . ':00';
                        $end_time = $pass_tider[$day_in_week][$pass_tid . 'stop'] . ':00';
                        $row = array($cab, $pass, $start_date, $end_date, $start_time, $end_time, '1');
                        $succed = $db->DB_execute($sql, $row, false);
                        if ($succed && $pass == 2) {
                        }
                    } # end for day counter
                } # end for pass counter
            } # end foreach
        } # end ifset POST['create']
    } # end create calendar
}
