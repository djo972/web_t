<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelDb extends Model{

    /**
     * Retrieves a value from the data array if set, or null otherwise.
     *
     * @param string $key
     * @return mixed|null
     */
    protected function _get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Set value for the given key
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setData($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

}