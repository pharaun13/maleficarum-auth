<?php
/**
 * This interface defines the API for auth data provider objects.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Process\Provider;

interface Provider {
    /**
     * Fetch auth data based on specified id.
     *
     * @param string $id
     *
     * @return \Maleficarum\Auth\Process\Provider\Provider
     */
    public function refresh(string $id): \Maleficarum\Auth\Process\Provider\Provider;

    /**
     * Fetch refreshed secret.
     *
     * @return string
     */
    public function getSecret(): string;

    /**
     * Fetch refreshed accessor data.
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Fetch refreshed accessor privileges.
     *
     * @return array
     */
    public function getPrivileges(): array;
}
