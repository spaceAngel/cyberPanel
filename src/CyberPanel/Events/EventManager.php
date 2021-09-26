<?php

namespace CyberPanel\Events;

class EventManager {

	private static self $instance;

	private array $listeners = [];


	private function __construct() {
	}

	public static function getInstance(): self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function registerListener(string $class): void {
		$listener = new $class;
		if ($listener instanceof ListenerInterface) {
			if (!array_key_exists($listener->listenOn(), $this->listeners)) {
				$this->listeners[$listener->listenOn()] = [];
			}
			$this->listeners[$listener->listenOn()][] = $listener;
		}
	}

	public function event(Event $event): void {
		$this->propagateEventToListeners(get_class($event), $event);
		$eventReflection = new \ReflectionClass(get_class($event));
		while ($eventReflection = $eventReflection->getParentClass()) {
			$this->propagateEventToListeners($eventReflection->name, $event);
		}
	}

	protected function propagateEventToListeners($eventClass, $event): void {
		if (array_key_exists($eventClass, $this->listeners)) {
			foreach ($this->listeners[$eventClass] as $listener) {
				$listener->onEvent($event);
			}
		}
	}

	protected function addEventListenerMapping(string $event, string $listener): void {
		if (!array_key_exists($event, $this->eventHandlersMap)) {
			$this->eventHandlersMap[$event] = [];
		}
		$this->eventHandlersMap[$event][] = $listener;
	}

}

