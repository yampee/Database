<?php

/*
 * Yampee Components
 * Open source web development components for PHP 5.
 *
 * @package Yampee Components
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @link http://titouangalopin.com
 */

/**
 * Represents a database record.
 */
class Yampee_Db_Record
{
	public function __call($name, $arguments)
	{
		if (substr($name, 0, 3) == 'get') {
			$property = $this->toUnderscores(substr($name, 3));

			if (property_exists($this, $property)) {
				return $this->$property;
			} else {
				throw new InvalidArgumentException(sprintf(
					'No field found called: %s', $property
				));
			}
		} elseif (substr($name, 0, 2) == 'is') {
			$property = $this->toUnderscores(substr($name, 2));

			if (property_exists($this, $property)) {
				return (boolean) $this->$property;
			} else {
				throw new InvalidArgumentException(sprintf(
					'No field found called: %s', $property
				));
			}
		} elseif (substr($name, 0, 3) == 'set') {
			$property = $this->toUnderscores(substr($name, 3));
			$this->$property = $arguments[0];

			return $this;
		}

		throw new BadMethodCallException(sprintf(
			'Call to undefined method Yampee_Db_Record::%s()', $name
		));
	}

	public function toArray()
	{
		return get_object_vars($this);
	}

	private function toUnderscores($str)
	{
		$str[0] = strtolower($str[0]);
		$func = create_function('$c', 'return "_" . strtolower($c[1]);');
		return preg_replace_callback('/([A-Z])/', $func, $str);
	}
}