<?php
/*

The time() function will get the current date and time a number string based in seconds.
The date() function then formats it to be human friendly.

*/

$now = time(). '<br>';
echo 'Today: ' . date('Y-m-d', $now) . '<br>';
echo 'Today: ' . date('l d M Y', $now) . '<br>';

echo 'Sunrise: ' . date_sunrise(time()) . '<br>';
echo 'Sunset: ' . date_sunset(time()) . '<br>';

echo 'There were ' . cal_days_in_month(CAL_GREGORIAN, 8, 2015) . 'days in August 2015' . '<br>';;

echo 'Day: ' . date("l") . ' ' .  date("d") . '<br>';
echo 'Month: ' . date("M") . ' ' .  date("m") . '<br>';
echo 'Year: ' . date("y") . ' ' .  date("Y") . '<br>';


/*
time();	returns the current time as a unix timestamp
date();	used to format a date / time
mktime(); creates a unix timestamp for a date
strftime() Formats date / time as per locale settings
strtotime() parses english time and creates a unix timestamp

gettimeofday() array containing current time info
getdate() array holding info for date and time from unix timestamp

date_sunrise() tells you sunrise / set time for a locale on that date
date_sunset() tells you sunset time for a locale on that date

date_default_timezone_set() set the default timezone
date_default_timezone_get() get the default timezone

cal_days_in_month()  gets number of calendar days in a month for a specified year
there are also calendar functions for changing date from gregorian, jewish, julian and french calendars


COULD USE THIS TO CREATE A CALENDAR FOR A MONTH
work out what the first day in the month is

*/
?>