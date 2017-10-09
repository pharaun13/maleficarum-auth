<?php
/**
 * This interface defines the API for auth data provider objects.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Process\Storage;

interface Storage {
    /**
     * Get a value from the storage
     *
     * @param $name
     *
     * @return mixed
     */
    public function get(string $name);

    /**
     * Set new value in the session.
     *
     * @param string $name
     * @param        $value
     *
     */
    public function set(string $name, $value);
}
