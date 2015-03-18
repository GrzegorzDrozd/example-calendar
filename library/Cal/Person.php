<?php
/**
 * Representation of a person
 *
 * @license LICENSE.TXT
 * @author  Grzegorz Drozd <grzegorz.drozd@gmail.com>
 * @date    2015-03-11
 * @package example-calendar
 */
namespace Cal;

/**
 * Class Person
 *
 * @package Cal
 */
class Person {

	/**
	 * Person id
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * Person name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Hour of work start
	 *
	 * @var int
	 */
	protected $workStart;

	/**
	 * Hour of work end
	 *
	 * @var int
	 */
	protected $workEnd;

	/**
	 * List of all available slots for that person in this day
	 *
	 * @var array
	 */
	protected $slots;

	/**
	 * List of events that this person attends
	 *
	 * @var Event[]
	 */
	protected $events;

	/**
	 * Person constructor.
	 *
	 * @param int    $id
	 * @param string $name
	 * @param int    $workStart
	 * @param int    $workEnd
	 */
	public function __construct( $id, $name, $workStart, $workEnd ) {
		$this->name      = $name;
		$this->workStart = $workStart;
		$this->workEnd   = $workEnd;
		$this->id        = $id;

		$this->slots = range($this->workStart, $this->workEnd);
	}

	/**
	 * Return name of a person
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set name of a person
	 *
	 * @param string $name
	 *
	 * @return Person
	 */
	public function setName( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Return work start hour
	 *
	 * @return int
	 */
	public function getWorkStart() {
		return $this->workStart;
	}

	/**
	 * Set work start hour
	 *
	 * @param int $workStart
	 *
	 * @return Person
	 */
	public function setWorkStart( $workStart ) {
		$this->workStart = $workStart;

		return $this;
	}

	/**
	 * Return work end hour
	 *
	 * @return int
	 */
	public function getWorkEnd() {
		return $this->workEnd;
	}

	/**
	 * Set work end hour
	 *
	 * @param int $workEnd
	 *
	 * @return Person
	 */
	public function setWorkEnd( $workEnd ) {
		$this->workEnd = $workEnd;

		return $this;
	}

	/**
	 * Return person id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set person id
	 *
	 * @param int $id
	 *
	 * @return Person
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * Attach event to a person. Also remove event time from
	 * persons available slots.
	 *
	 * @param Event $event
	 *
	 * @return Person
	 */
	public function addEvent( Event $event ) {
		$this->events[] = $event;
		for($i = $event->getStart(); $i < $event->getEnd(); $i++) {
			$key = array_search($i, $this->slots);
			unset($this->slots[$key]);
		}

		return $this;
	}

	/**
	 * Return available slots
	 *
	 * @return array
	 */
	public function getAvailableSlots() {
		return $this->slots;
	}

	/**
	 * Set available slots
	 *
	 * @param array $slots
	 *
	 * @return Person
	 */
	public function setAvailableSlots( $slots ) {
		$this->slots = $slots;

		return $this;
	}
}
