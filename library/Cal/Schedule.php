<?php
/**
 * Schedule class.
 *
 * @license LICENSE.TXT
 * @author  Grzegorz Drozd <grzegorz.drozd@gmail.com>
 * @date    2015-03-11
 * @package example-calendar
 */

namespace Cal;

/**
 * Class Schedule
 *
 * @package Cal
 */
class Schedule {

	/**
	 * @var \Cal\Person[]
	 */
	protected $persons;

	/**
	 * @var \Cal\Event[]
	 */
	protected $events;

	/**
	 * Min work start hour calculated at runtime
	 *
	 * @var int
	 */
	protected $minStartWorkHour = 12;

	/**
	 * Max work end hour calculated at runtime
	 *
	 * @var int
	 */
	protected $maxEndWorkHour = 12;

	/**
	 * Add person to a schedule
	 *
	 * @param Person $person
	 *
	 * @return Schedule
	 */
	public function addPerson( Person $person ) {
		$this->persons[$person->getId()]        = $person;
		$this->minStartWorkHour = min( $this->minStartWorkHour, $person->getWorkStart() );
		$this->maxEndWorkHour   = max( $this->maxEndWorkHour, $person->getWorkEnd() );

		return $this;
	}

	/**
	 * Return events for specific person by person id
	 *
	 * @param int $id person id
	 *
	 * @return Event[]
	 */
	public function getEventsForPerson( $id ) {
		$ret = array();

		/** @var \Cal\Person $person */
		foreach ( $this->events as $event ) {
			foreach ( $event->getAttendees() as $person ) {
				if ( $person->getId() == $id ) {
					$ret[] = $event;
				}
			}
		}

		return $ret;
	}

	/**
	 * Add event to this schedule
	 *
	 * @param $event
	 */
	public function addEvent( $event ) {
		$this->events[] = $event;
	}

	/**
	 * Get all events
	 *
	 * @return Event[]
	 */
	public function getEvents() {
		return $this->events;
	}

	/**
	 * @param $id
	 *
	 * @return Person
	 */
	public function getPerson( $id ) {
		return $this->persons[$id];
	}

	/**
	 * Return all persons
	 *
	 * @return Person[]
	 */
	public function getPersons() {
		return $this->persons;
	}

	/**
	 * Set persons
	 *
	 * @param Person[] $persons
	 *
	 * @return Schedule
	 */
	public function setPersons( $persons ) {
		$this->persons = $persons;
	}

	/**
	 * Return min start working hour for this schedule
	 *
	 * @return int
	 */
	public function getMinStartWorkHour() {
		return $this->minStartWorkHour;
	}

	/**
	 * Set min start working hour for this schedule
	 *
	 * @param int $minStartWorkHour
	 *
	 * @return Schedule
	 */
	public function setMinStartWorkHour( $minStartWorkHour ) {
		$this->minStartWorkHour = $minStartWorkHour;
	}

	/**
	 * Return max end working hour for this schedule
	 *
	 * @return int
	 */
	public function getMaxEndWorkHour() {
		return $this->maxEndWorkHour;
	}

	/**
	 * Set max end working hour for this schedule
	 *
	 * @param int $maxEndWorkHour
	 *
	 * @return Schedule
	 */
	public function setMaxEndWorkHour( $maxEndWorkHour ) {
		$this->maxEndWorkHour = $maxEndWorkHour;
	}
}
