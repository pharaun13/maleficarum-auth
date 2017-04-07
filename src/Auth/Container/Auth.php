<?php

/**
 * This is container object that carries current auth data and provides access points to enact logic on that data.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Container;

class Auth {
	
	/* ------------------------------------ Class Property START --------------------------------------- */

	/**
	 * Internal storage for current accessor privileges.
	 * @var array
	 */
	private $privs = [];

	/**
	 * Internal storage for accessor specific data.
	 * @var array
	 */
	private $data = [];
	
	/**
	 * Internal storage for current auth ID.
	 * @var string
	 */
	private $id = null;

	/**
	 * Internal storage for current auth secret.
	 * @var string
	 */
	private $secret = null;

	/**
	 * Internal storage for a privilege checker process object.
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
	 * @param int    $flag
	 * @return bool
	 */
	public function isAuthorized(string $system = '*', string $type = '*', string $id = '*', string $component = '*', int $flag = -1) {
		return $this->getChecker()
			->setPrivileges($this->getPrivs())
			->check($system, $type, $id, $component, $flag);
	}
	
	/* ------------------------------------ Class Methods END ------------------------------------------ */

	/* ------------------------------------ Setters & Getters START ------------------------------------ */
	
	/**
	 * @return array
	 */
	public function getPrivs() {
		return $this->privs;
	}

	/**
	 * @param array $privs
	 */
	public function setPrivs(array $privs) {
		$this->privs = $privs;
	}

	/**
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}
	
	/**
	 * @param array $data
	 */
	public function setData(array $data) {
		$this->data = $data;
	}
	
	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param string $id
	 */
	public function setId(string $id) {
		$this->id = $id;
	}
	
	/**
	 * @return string
	 */
	public function getSecret() {
		return $this->secret;
	}
	
	/**
	 * @param string $secret
	 */
	public function setSecret(string $secret) {
		$this->secret = $secret;
	}

	/**
	 * @return \Maleficarum\Auth\Process\Privilege\Checker
	 */
	public function getChecker() {
		return $this->checker;
	}
	
	/**
	 * @param \Maleficarum\Auth\Process\Privilege\Checker $checker
	 */
	public function setChecker(\Maleficarum\Auth\Process\Privilege\Checker $checker) {
		$this->checker = $checker;
	}
	
	/* ------------------------------------ Setters & Getters END -------------------------------------- */
	
}