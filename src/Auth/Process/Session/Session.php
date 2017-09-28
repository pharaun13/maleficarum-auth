<?php
/**
 * This interface defines the API for auth data provider objects.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Process\Session;

interface Session {
    /**
     * Get a value from the session
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
