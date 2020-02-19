<?php
/**
 * This trait adds an "is active" field to the model.
 * You can override field name defining constant ACTIVE in the model.
 *
 * When creating model, add this line in migration file :
 * $table->boolean('is_active')->default(true);
 *
 * Get all active users : User::active()->get()
 * Get all inactive users : User::inactive()->get()
 * Get if user is active : $User->is_active or $User->active (returns boolean)
 */
namespace App\Traits\Eloquent;

use Illuminate\Database\QueryException;

trait Active
{

    /**
     * Adds the field in properties.
     */
    public function initializeActive()
    {
        $this->fillable[] = $this->getActiveColumn();
        $this->casts[$this->getActiveColumn()] = 'boolean';
    }

    /**
     * Get if item is active.
     *
     * @return mixed
     */
    public function getActiveAttribute()
    {
        return $this->{$this->getActiveColumn()};
    }

    /**
     * Scope a query to only include active items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $this->addConditionToQuery($query,1);
    }

    /**
     * Scope a query to only include inactive items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $this->addConditionToQuery($query,0);
    }

    /**
     * Get the name of the "is active" column.
     *
     * @return string
     */
    public function getActiveColumn()
    {
        return defined('static::ACTIVE') ? static::ACTIVE : 'is_active';
    }

    /**
     * Add condition "is active" to query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function addConditionToQuery($query, int $value)
    {
        try {
            return $query->where($this->getTable().'.'.$this->getActiveColumn(), $value);
        }
        catch(QueryException $e) {
            throw new \RuntimeException(__METHOD__.' : column \''.$this->getActiveColumn().'\' does not exists in '.get_called_class());
        }
    }

    /**
     * Set "is active" value and save.
     *
     * @param bool $flag
     */
    public function setActive(bool $flag)
    {
        $this->{$this->getActiveColumn()} = $flag;
        $this->save();
    }

}
