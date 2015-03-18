<?php
/**
 * Event coordinator
 *
 * @license LICENSE.TXT
 * @author  Grzegorz Drozd <grzegorz.drozd@gmail.com>
 * @date    2015-03-11
 * @package example-calendar
 */

namespace Cal\Event;

use Cal\Schedule;

/**
 * Class Coordinator
 *
 * @package Cal\Event
 */
class Coordinator {

	/**
	 * @var Schedule
	 */
	protected $schedule;

	/**
	 * Coordinator constructor.
	 *
	 * @param Schedule $schedule
	 */
	public function __construct( Schedule $schedule ) {
		$this->schedule = $schedule;
	}

	/**
	 * Return an array where keys are proposed meeting hours and values are ids of users
	 *
	 * @param array $persons ids
	 * @param int $duration
	 *
	 * @return array
	 */
	public function findAvailableSlots($persons, $duration = 1) {

		// get all available slots for each user that is attending a meeting
		$availableSlots = array();
		foreach($persons as $id) {
			$availableSlots[$id] = $this->getSchedule()->getPerson($id)->getAvailableSlots();
		}

		// if duration of a meeting is longer than one hour then
		// we need to change array of $availableSlots
		// and fill it with only continuous hours that matches
		// desired duration. For example:
		// if we look for a 2 hour window only users that have
		// continuous available slots can attend this meeting.
		// resulting array has this format:
		// keys are calculated continuous slots and vales are users who
		// are available for a meeting in this time
		// 10 11 12 => array(<user_id>, <user_id>)
		if ($duration != 1) {

			$fixedAvailableSlots = array();

			foreach($availableSlots as $personId => $hours) {
				// iterate over user hours up to desired duration from the end
				for($i = 0, $keys = array_keys($hours), $c = count($keys); $i < $c-$duration; $i++) {

					$currentHour = $hours[$keys[$i]];
					$currentPersonHour = array($currentHour);
					for($n = 1; $n < $duration; $n++) {
						$nextHour = $currentHour+$n;
						// next, calculated hour is not in users slots.
						if (!array_search($nextHour, $hours)) {
							break;
						}
						$currentPersonHour[] = $nextHour;
					}

					if (count($currentPersonHour) == $duration) {
						$fixedAvailableSlots[$personId][$currentHour] = join(" ", $currentPersonHour);
					}
				}
			}

			$availableSlots = $fixedAvailableSlots;
		}

		$personToSlotDistribution = array();
		foreach($availableSlots as $personId => $values) {
			foreach($values as $value) {
				$personToSlotDistribution[$value][] = $personId;
			}
		}
		uasort($personToSlotDistribution, function ($a, $b) {
			$a = count($a);
			$b = count($b);

			if ($a == $b) {
				return 0;
			}
			return ($a > $b) ? -1 : 1;
		});

		return $personToSlotDistribution;
	}

	/**
	 * Get schedule
	 *
	 * @return Schedule
	 */
	public function getSchedule() {
		return $this->schedule;
	}

	/**
	 * Set schedule
	 *
	 * @param Schedule $schedule
	 *
	 * @return Coordinator
	 */
	public function setSchedule( $schedule ) {
		$this->schedule = $schedule;

		return $this;
	}
}
