<?php

namespace CyberPanel\Voice\Listeners;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Events\Hardware\CpuTemperatureEvent;
use CyberPanel\Events\Event;
use CyberPanel\Configuration\Configuration;
use CyberPanel\Voice\Speaker;

abstract class GenericValueChangeInTimeListener implements ListenerInterface {

	protected const EVENT_NORMAL = 1;
	protected const EVENT_INCREASE = 2;
	protected const EVENT_OVERLIMIT = 3;

	protected const LIMIT_WARN_AFTER = 5;
	protected const LIMIT_REMINDER = 60;

	protected int $lastValue = 0;
	protected int $lastIncreasedValue = 0;

	protected array $stack = [];
	protected bool $wasWarned = FALSE;

	public function onEvent(Event $event) : void {
		array_unshift(
			$this->stack,
			$this->resolveAction($event->getValue())
		);
		$this->resolveMessage($event);
		$this->lastValue = $event->getValue();
	}

	protected function resolveAction(int $value) : int {
		if ($value < $this->getLimitValue()) {
			return self::EVENT_NORMAL;
		} else {
			if ($value > $this->lastIncreasedValue) {
				return self::EVENT_INCREASE;
			} else {
				return self::EVENT_OVERLIMIT;
			}
		}
	}

	protected function resolveMessage(Event $event) : void {
		$indexNormal = array_search(self::EVENT_NORMAL, $this->stack);
		$indexIncrease = array_search(self::EVENT_INCREASE, $this->stack);
		$indexOverlimit = array_search(self::EVENT_OVERLIMIT, $this->stack);
		if (
			$indexNormal == 0
			&& (!empty($indexIncrease) && $indexIncrease > self::LIMIT_WARN_AFTER)
			&& (!empty($indexOverlimit) && $indexOverlimit > self::LIMIT_WARN_AFTER)
		) {
			$this->handleReturnToNormal();
		} elseif (
			($indexIncrease + self::LIMIT_WARN_AFTER) < $indexNormal
			|| ($indexOverlimit + self::LIMIT_WARN_AFTER) < $indexNormal
		) {
			if ($indexIncrease < $indexOverlimit || !$this->wasWarned) {
				Speaker::getInstance()->say(
					sprintf($this->getMessageValueIsIncreased(), $event->getValue())
				);
				$this->wasWarned = TRUE;
				$this->lastIncreasedValue = $event->getValue();
			} elseif ($indexIncrease % self::LIMIT_REMINDER == 0) {
				$this->lastIncreasedValue = $event->getValue();
				Speaker::getInstance()->say(
					sprintf($this->getMessageValueIsStillOverlimit(), $event->getValue())
				);
			}
		}
	}

	protected function handleReturnToNormal() : void {
		$this->stack = [];
		$this->lastIncreasedValue = 0;
		if ($this->wasWarned) {
			Speaker::getInstance()->say($this->getMessageValueBackToNormal(), TRUE);
		}
		$this->wasWarned = FALSE;
	}

	abstract protected function getLimitValue() : int;
	abstract protected function getMessageValueBackToNormal() : string;
	abstract protected function getMessageValueIsIncreased() : string;
	abstract protected function getMessageValueIsStillOverlimit() : string;

}
