<?php
/**
 * Event representation
 *
 * @license LICENSE.TXT
 * @author  Grzegorz Drozd <grzegorz.drozd@gmail.com>
 * @date    2015-03-11
 * @package example-calendar
 */
namespace Cal;

/**
 * Class Event
 *
 * @package Cal
 */
class Event {

	/**
	 * Event name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Event start hour
	 *
	 * @var int
	 */
	protected $start;

	/**
	 * Event end hour
	 *
	 * @var int
	 */
	protected $end;

	/**
	 * Event attendees
	 *
	 * @var Person[]
	 */
	protected $attendees;

	/**
	 * Event constructor.
	 *
	 * @param string    $name
	 * @param int       $start
	 * @param int       $end
	 */
	public function __construct( $name, $start, $end ) {
		$this->name  = $name;
		$this->start = $start;
		$this->end   = $end;
	}

	/**
	 * Add attendee to the meeting
	 *
	 * @param Person $person
	 */
	public function addAttendee( Person $person ) {
		$this->attendees[] = $person;
		$person->addEvent($this);
	}

	/**
	 * Return event name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set event name
	 *
	 * @param string $name
	 *
	 * @return Event
	 */
	public function setName( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get start hour of this event
	 *
	 * @return int
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Set start hour of this event
	 *
	 * @param int $start
	 *
	 * @return Event
	 */
	public function setStart( $start ) {
		$this->start = $start;

		return $this;
	}

	/**
	 * Return end hour of this event
	 *
	 * @return int
	 */
	public function getEnd() {
		return $this->end;
	}

	/**
	 * Set end hour of this event
	 *
	 * @param int $end
	 *
	 * @return Event
	 */
	public function setEnd( $end ) {
		$this->end = $end;

		return $this;
	}

	/**
	 * Get list of attendees
	 *
	 * @return Person[]
	 */
	public function getAttendees() {
		return $this->attendees;
	}

	/**
	 * Set list of attendees
	 *
	 * @param mixed $attendees
	 *
	 * @return Event
	 */
	public function setAttendees( $attendees ) {
		$this->attendees = $attendees;

		return $this;
	}

}
