<?php

namespace Core\Traits;


trait Singleton
{
	/** @var self */
	protected static $_instance;


	private function __construct() {
	}


	/**
	 * @return self
	 */
	public static function getInstance() {
		if (self::$_instance === NULL) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}


	private function __clone() {
	}


	private function __wakeup() {
	}
}