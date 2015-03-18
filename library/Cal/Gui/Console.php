<?php
/**
 * Console gui to display schedule.
 *
 * @license LICENSE.TXT
 * @author  Grzegorz Drozd <grzegorz.drozd@gmail.com>
 * @date    2015-03-11
 * @package web_dev_calendar
 */

namespace Cal\Gui;

use Cal\Schedule;

/**
 * Class Console
 *
 * @package Cal\Gui
 */
class Console {

	/**
	 * Schedule to display
	 *
	 * @var Schedule
	 */
	protected $schedule;

	/**
	 * Buffer time to add before and after min and max working hour start|end
	 *
	 * @var int
	 */
	protected $buffer = 1;

	/**
	 * Line length for console gui
	 *
	 * @var int
	 */
	protected $lineLength = 100;


	/**
	 * Console constructor.
	 *
	 * @param Schedule $schedule
	 */
	public function __construct( Schedule $schedule ) {
		$this->setSchedule($schedule);
	}


	/**
	 * Display calendar in console gui
	 */
	public function display() {

		print $this->getHeader();

		/** @var \Cal\Event $event */
		foreach ( $this->getSchedule()->getPersons() as $person ) {
			print str_pad(
				sprintf( '%s [id:%d] (%d-%d)',
					$person->getName(),
					$person->getId(),
					$person->getWorkStart(),
					$person->getWorkEnd()
				),
				30,
				' ' );
			$add = $this->buffer + $person->getWorkStart() - $this->getSchedule()->getMinStartWorkHour();
			print str_repeat( '     ', $add );
			print '|----' . str_repeat( '-----', $person->getWorkEnd() - $person->getWorkStart() - 1 ) . '----|' . "\n";
			print str_repeat( ' ', 30 );

			// cursor is at beginning of minStartWorkHour-$buffer
			$cursor = ( $this->getSchedule()->getMinStartWorkHour() ) - ( $this->buffer );
			/** @var \Cal\Event[] $events */
			$events = $this->getSchedule()->getEventsForPerson( $person->getId() );
			foreach ( $events as $i => $event ) {
				print str_repeat( ' ', ( $event->getStart() - $cursor ) * 5 );

				// move cursor to the next meeting beginning
				print str_repeat( $i, ( $event->getEnd() - $event->getStart() ) * 5 );
				$cursor = $event->getEnd();

			}
			print "\n";

			print str_repeat( '-', $this->lineLength ) . "\n";
		}
	}

	/**
	 * Return header for console gui
	 *
	 * @return string
	 */
	protected function getHeader() {

		// number of buffer hours to add before and after min/max working hour. For display
		$header    = array();
		$header[0] = str_repeat( ' ', 30 );

		// display hours above calendar
		// loop from min working (minus buffer) to max working (plus buffer)
		for ( $i = $this->getSchedule()->getMinStartWorkHour() - $this->buffer; $i <= $this->getSchedule()->getMaxEndWorkHour() + $this->buffer; $i ++ ) {
			$header[0] .= str_pad( $i, 4, ' ', STR_PAD_BOTH ) . '|';
		}

		// represent every hour as 4 blocks of 15 minutes separated with |
		$header[1] = str_repeat( '-', 30 ) . str_repeat( '####|', $this->getSchedule()->getMaxEndWorkHour() - $this->getSchedule()->getMinStartWorkHour() + 3 );

		// line length ( to display separators)
		$this->lineLength = strlen( $header[1] );

		// display header.
		return join( "\n", $header ) . "\n";
	}

	/**
	 * Get Schedule object
	 *
	 * @return Schedule
	 */
	public function getSchedule() {
		return $this->schedule;
	}

	/**
	 * Set schedule object
	 *
	 * @param Schedule $schedule
	 *
	 * @return Console
	 */
	public function setSchedule( $schedule ) {
		$this->schedule = $schedule;
	}
}
