<?php
/**
 * This is a container object that carries current auth data and provides access points to enact logic on that data.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Container;

class Auth {
    /* ------------------------------------ Class Property START --------------------------------------- */

    /**
     * Internal storage for current accessor privileges.
     *
     * @var array
     */
    private $privileges = [];

    /**
     * Internal storage for accessor specific data.
     *
     * @var array
     */
    private $data = [];

    /**
     * Internal storage for current auth ID.
     *
     * @var string
     */
    private $id = null;

    /**
     * Internal storage for current auth secret.
     *
     * @var string
     */
    private $secret = null;

    /**
     * Internal storage for a privilege checker process object.
     *
     * @var \Maleficarum\Auth\Process\Privilege\Checker
     */
    private $checker = null;

    /* ------------------------------------ Class Property END ----------------------------------------- */

    /* ------------------------------------ Magic methods START ---------------------------------------- */

    /**
     * Initialize a new instance of the auth container.
     *
     * @param \Maleficarum\Auth\Process\Privilege\Checker $checker
     */
    public function __construct(\Maleficarum\Auth\Process\Privilege\Checker $checker) {
        $this->setChecker($checker);
    }

    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ Class Methods START ---------------------------------------- */

    /**
     * Check current privilege set against the specified privilege query.
     *
     * @param string $system
     * @param string $type
     * @param string $id
     * @param string $component
     * @param int $flag
     *
     * @return bool
     */
    public function isAuthorized(string $system = '*', string $type = '*', string $id = '*', string $component = '*', int $flag = -1): bool {
        return $this->getChecker()
            ->setPrivileges($this->getPrivileges())
            ->check($system, $type, $id, $component, $flag);
    }

    /* ------------------------------------ Class Methods END ------------------------------------------ */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */

    /**
     * @return array
     */
    public function getPrivileges(): array {
        return $this->privileges;
    }

    /**
     * @param array $privileges
     *
     * @return \Maleficarum\Auth\Container\Auth
     */
    public function setPrivileges(array $privileges): \Maleficarum\Auth\Container\Auth {
        $this->privileges = $privileges;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return \Maleficarum\Auth\Container\Auth
     */
    public function setData(array $data): \Maleficarum\Auth\Container\Auth {
        $this->data = $data;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return \Maleficarum\Auth\Container\Auth
     */
    public function setId(string $id): \Maleficarum\Auth\Container\Auth {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSecret(): ?string {
        return $this->secret;
    }

    /**
     * @param string $secret
     *
     * @return \Maleficarum\Auth\Container\Auth
     */
    public function setSecret(string $secret): \Maleficarum\Auth\Container\Auth {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @return \Maleficarum\Auth\Process\Privilege\Checker
     */
    public function getChecker(): \Maleficarum\Auth\Process\Privilege\Checker {
        return $this->checker;
    }

    /**
     * @param \Maleficarum\Auth\Process\Privilege\Checker $checker
     *
     * @return \Maleficarum\Auth\Container\Auth
     */
    public function setChecker(\Maleficarum\Auth\Process\Privilege\Checker $checker): \Maleficarum\Auth\Container\Auth {
        $this->checker = $checker;

        return $this;
    }

    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
