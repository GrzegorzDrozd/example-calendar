<?php
/**
 * List available meeting time slots.
 *
 * @license LICENSE.TXT
 * @author  Grzegorz Drozd <grzegorz.drozd@gmail.com>
 * @date    2015-03-11
 * @package web_dev_calendar
 */

namespace Cal;

use Cal\Event\Coordinator;
use Cal\Gui\Console;

if (!file_exists('calendar.dat')) {
	die('For repetitive please use generator.php first.');
}

require_once 'library/Cal/Event.php';
require_once 'library/Cal/Person.php';
require_once 'library/Cal/Schedule.php';
require_once 'library/Cal/Gui/Console.php';
require_once 'library/Cal/Event/Coordinator.php';

$schedule = unserialize( file_get_contents( 'calendar.dat' ) );
$gui = new Console($schedule);
$gui->display();


$coordinator = new Coordinator($schedule);

$events = $coordinator->findAvailableSlots(array(0,1,2), 2);
var_dump($events);

