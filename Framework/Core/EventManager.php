<?php

/**
 * Event Manager
 * @namespace System\Core
 * @package system.core.eventmanager
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

class EventManager
{

    /**
     * Binding events container
     * @var array
     */
    protected $_events = array(
        'app_start' => array(
            'System\\Event\\AppStart'
        ),
        'app_end' => array(
            'System\\Event\\AppClose'
        )
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        $events = DI::factory()->get('config')->get('event');
        $this->_events = array_merge_recursive($events, $this->_events);
    }

    /**
     * Bind events
     * @param string $name tag name
     * @param string /array $event event name
     */
    public function attach($name, $event)
    {
        if (is_string($event)) {
            $this->_events[$name][] = $event;
        } else if (is_array($event)) {
            if (empty($this->_events[$name])) $this->_events[$name] = array();
            $this->_events[$name] = array_merge($event, $this->_events[$name]);
        }
    }

    /**
     * Unbind events
     * @param string $name tag name
     * @param string /array $event event name
     */
    public function detach($name, $event)
    {
        if (isset($this->_events[$name])) {
            if (is_string($event)) {
                $index = array_search($event, $this->_events[$name]);
                if ($index !== false) unset($this->_events[$name][$index]);
            } elseif (is_array($event)) {
                foreach ($event as $e) {
                    $index = array_search($e, $this->_events[$name]);
                    if ($index !== false) unset($this->_events[$name][$index]);
                }
            }
        }
    }

    /**
     * Call binding events with given tag name
     * @param string $name tag name
     * @param array $args pass arguments
     */
    public function notify($name, $args = array())
    {
        if (isset($this->_events[$name])) {
            foreach ($this->_events[$name] as $event) {
                if (class_exists($event)) {
                    $obj = new $event;
                    $obj->run($args);
                }
            }
        }
        Profiler::trace($name);
    }

}

