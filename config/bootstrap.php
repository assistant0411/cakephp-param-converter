<?php

use Cake\Core\Configure;
use Cake\Event\EventManager;
use ParamConverter\DispatchListener;

Configure::load('ParamConverter.param_converter');

EventManager::instance()->on(new DispatchListener());