<?php
  $date         = $_GET['date'];
  $location     = $_GET['location'];
  $startTime    = $_GET['startTime'];
  $endTime      = $_GET['endTime'];
  $title        = $_GET['title'];
  $description  = $_GET['description'];

  $ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "example.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
LOCATION:".$location."
DTSTART:".$date."T".$startTime."00Z
DTEND:".$date."T".$endTime."00Z
SUMMARY:".$title."
DESCRIPTION:".$description."
END:VEVENT
END:VCALENDAR";

  header('Content-type: text/calendar; charset=utf-8');
  header('Content-Disposition: inline; filename=' . $title . '.ics');
  echo $ical;
  exit;
?>