<?php

/**
 * This class carries ioc initialization functionality used by this component.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Initializer;

class Initializer {
	/**
	 * This will setup all IOC definitions specific to this component.
	 * @return string
	 */
	static public function initialize(array $opts = []) : string {
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
				}
				
				/** Data refresh stage */
				if (isset($dep['Maleficarum\Config']) && isset($dep['Maleficarum\Config']['auth']['refreshing_mode'])) {
					/** Redis */
					if ($dep['Maleficarum\Config']['auth']['refreshing_mode']['type'] === 'Redis') {
						$dep['Maleficarum\Redis']->connect()->select($dep['Maleficarum\Config']['auth']['refreshing_mode']['database']);
						$data = json_decode($dep['Maleficarum\Redis']->get($auth->getId()), true);
						isset($data['token']) and $auth->setSecret($data['token']);
						isset($data['privileges']) and $auth->setPrivs($data['privileges']);
					}
				}
				
				return $auth;
			});
		}

		$auth = \Maleficarum\Ioc\Container::get('Maleficarum\Auth\Container\Auth');
		\Maleficarum\Ioc\Container::registerDependency('Maleficarum\Auth', $auth);

		return __METHOD__;
	}
}