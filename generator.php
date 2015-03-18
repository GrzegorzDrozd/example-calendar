<?php
/**
 * Generate example schedule to work on
 *
 *
 * @license LICENSE.TXT
 * @author  Grzegorz Drozd <grzegorz.drozd@gmail.com>
 * @date    2015-03-11
 * @package web_dev_calendar
 */


require_once 'library/Cal/Event.php';
require_once 'library/Cal/Person.php';
require_once 'library/Cal/Schedule.php';
require_once 'library/Cal/Gui/Console.php';


use Cal\Event;
use Cal\Gui\Console;
use Cal\Person;
use Cal\Schedule;

$schedule = new Schedule();

// generate calendar
for($i = 0; $i < 5; $i++) {
	$workStart = rand(8,9);
	$workEnd = $workStart+8+rand(0,1);
	$person = new Person($i, "Person $i", $workStart, $workEnd );
	$schedule->addPerson($person);

	$numberOfMeetings = rand(3,4);
	for($n = 0, $prevMeetingStart = $workStart+rand(0,2); $n < $numberOfMeetings; $n++) {
		$eventDuration = rand(1,2);

		// don't overflow beyond working hours
		if($prevMeetingStart+$eventDuration > $workEnd) {
			continue;
		}

		$event = new Event('Event '.$n, $prevMeetingStart, $prevMeetingStart+$eventDuration);
		$event->addAttendee($person);
		$prevMeetingStart = $prevMeetingStart+$eventDuration+rand(0,3);

		$schedule->addEvent($event);
	}
}

$gui = new Console($schedule);
$gui->display();

file_put_contents('calendar.dat', serialize($schedule));
