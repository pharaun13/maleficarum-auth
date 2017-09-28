<?php
/**
 * This class carries ioc initialization functionality used by this component.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Initializer;

class Initializer {
    /**
     * This will setup all IOC definitions specific to this component.
     *
     * @param array $opts
     *
     * @return string
     */
    static public function initialize(array $opts = []): string {
        // load default builder if skip not requested
        $builders = $opts['builders'] ?? [];
        is_array($builders) or $builders = [];

        if (!isset($builders['auth']['skip'])) {
            \Maleficarum\Ioc\Container::register('Maleficarum\Auth\Container\Auth', function ($dep) {
                $auth = new \Maleficarum\Auth\Container\Auth(\Maleficarum\Ioc\Container::get('Maleficarum\Auth\Process\Privilege\Checker'));

                /** Incoming data stage */
                if (isset($dep['Maleficarum\Config']) && isset($dep['Maleficarum\Config']['auth']['incoming_mode'])) {
                    /** HMAC */
                    if ($dep['Maleficarum\Config']['auth']['incoming_mode']['type'] === 'HMAC') {
                        $auth->setId($dep['Maleficarum\Request']->getHeader($dep['Maleficarum\Config']['auth']['incoming_mode']['name']));
                    }

                    /** SESSION */
                    if ($dep['Maleficarum\Config']['auth']['incoming_mode']['type'] === 'Session') {
                        $session = \Maleficarum\Ioc\Container::get($dep['Maleficarum\Config']['session']['type']);
                        if (!$session instanceof \Maleficarum\Auth\Process\Session\Session) {
                            throw new \LogicException('Invalid session type specified.');
                        }

                        $authId = $session->get($dep['Maleficarum\Config']['auth']['incoming_mode']['name']);
                        isset($authId) ? $auth->setId($authId) : $auth->setId('');
                    }
                }

                /** Data refresh stage */
                if (isset($dep['Maleficarum\Config']) && isset($dep['Maleficarum\Config']['auth']['refreshing_mode'])) {
                    $provider = \Maleficarum\Ioc\Container::get($dep['Maleficarum\Config']['auth']['refreshing_mode']['type']);
                    if (!$provider instanceof \Maleficarum\Auth\Process\Provider\Provider) {
                        throw new \LogicException('Invalid auth provider type specified.');
                    }

                    $provider->refresh($auth->getId());
                    $auth
                        ->setSecret($provider->getSecret())
                        ->setData($provider->getData())
                        ->setPrivileges($provider->getPrivileges());
                }

                return $auth;
            });
        }

        $auth = \Maleficarum\Ioc\Container::get('Maleficarum\Auth\Container\Auth');
        \Maleficarum\Ioc\Container::registerDependency('Maleficarum\Auth', $auth);

        return __METHOD__;
    }
}
