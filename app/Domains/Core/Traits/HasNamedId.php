<?php

namespace App\Domains\Core\Traits;

use App\Domains\Core\Utilities\IdUtility;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

trait HasNamedId
{
	public function initializeHasNamedId()
	{
		$this->usesUniqueIds = true;
	}

	public function uniqueIds()
	{
		return [$this->getKeyName()];
	}

	public function newUniqueId()
	{
		return IdUtility::generateNamedId($this->namedIdPrefix);
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\Relation<*, *, *>  $query
	 * @param mixed $value
	 * @param string|null $field
	 * @return \Illuminate\Contracts\Database\Eloquent\Builder
	 *
	 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function resolveRouteBindingQuery($query, $value, $field = null)
	{
		if (
			$field &&
			in_array($field, $this->uniqueIds()) &&
			!Str::isUlid($value)
		) {
			throw (new ModelNotFoundException())->setModel(
				get_class($this),
				$value
			);
		}

		if (
			!$field &&
			in_array($this->getRouteKeyName(), $this->uniqueIds()) &&
			!Str::isUlid($value)
		) {
			throw (new ModelNotFoundException())->setModel(
				get_class($this),
				$value
			);
		}

		return parent::resolveRouteBindingQuery($query, $value, $field);
	}

	public function getKeyType()
	{
		if (in_array($this->getKeyName(), $this->uniqueIds())) {
			return "string";
		}

		return $this->keyType;
	}

	public function getIncrementing()
	{
		if (in_array($this->getKeyName(), $this->uniqueIds())) {
			return false;
		}

		return $this->incrementing;
	}
}
