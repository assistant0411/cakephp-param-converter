<?php

use Cake\Event\EventManager;
use ParamConverter\DispatchListener;

EventManager::instance()->on(new DispatchListener());