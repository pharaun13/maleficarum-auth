<?php
/**
 * This trait allows for auth container usage inside classes that use it.
 */
declare (strict_types=1);

namespace Maleficarum\Auth;

trait Dependant {
    /* ------------------------------------ Class Property START --------------------------------------- */

    /**
     * Internal storage for the auth container object.
     *
     * @var \Maleficarum\Auth\Container\Auth
     */
    protected $auth = null;

    /* ------------------------------------ Class Property END ----------------------------------------- */

    /* ------------------------------------ Class Methods START ---------------------------------------- */

    /**
     * Get the currently assigned auth container object.
     *
     * @return \Maleficarum\Auth\Container\Auth|null
     */
    public function getAuth(): ?\Maleficarum\Auth\Container\Auth {
        return $this->auth;
    }

    /**
     * Inject a new auth container object.
     *
     * @param \Maleficarum\Auth\Container\Auth $auth
     *
     * @return \Maleficarum\Auth\Dependant
     */
    public function setAuth(\Maleficarum\Auth\Container\Auth $auth) {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Unassign the current auth container object.
     *
     * @return \Maleficarum\Auth\Container\Auth
     */
    public function detachAuth() {
        $this->auth = null;

        return $this;
    }

    /* ------------------------------------ Class Methods END ------------------------------------------ */
}
