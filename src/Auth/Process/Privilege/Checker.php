<?php
/**
 * This class provides privilege check functionality.
 */
declare (strict_types=1);

namespace Maleficarum\Auth\Process\Privilege;

class Checker {
    /* ------------------------------------ Class Property START --------------------------------------- */

    /**
     * Internal storage for current privilege set to run checks against.
     *
     * @var array
     */
    private $privileges = [];

    /* ------------------------------------ Class Property END ----------------------------------------- */

    /* ------------------------------------ Class Methods START ---------------------------------------- */

    /**
     * Run the provided privilege check against the specified set of privileges.
     *
     * @param string $systemName
     * @param string $elementType
     * @param string $elementId
     * @param string $component
     * @param int $flag
     *
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function check(string $systemName = '*', string $elementType = '*', string $elementId = '*', string $component = '*', int $flag = -1): bool {
        // get match flag for entity
        $privilege = $this->getPrivFlag($systemName, $elementType, $elementId, $component);

        // check privilege flags
        if (is_null($privilege)) {
            return false;
        } // no privileges for the specified resource
        if ($flag === -1 && $privilege !== -1) {
            return false;
        } // requested all privileges but only specific privileges exist
        if ($flag < -1) {
            return false;
        } // incorrect flag specified
        if ($privilege === -1) {
            return true;
        } // global privileges flag matched

        return (bool)($flag & $privilege);
    }

    /**
     * Fetch the privilege flag for specified privilege path.
     *
     * @param string $systemName
     * @param string $elementType
     * @param string $elementId
     * @param string $component
     *
     * @return int|null
     */
    private function getPrivFlag(string $systemName, string $elementType, string $elementId, string $component): ?int {
        /** SYSTEM NAME level */

        // handle wildcard on $systemName
        if (array_key_exists('*', $this->getPrivileges())) {
            return $this->getPrivileges()['*'];
        }

        // handle nonexistent $systemName
        if (!array_key_exists($systemName, $this->getPrivileges())) {
            return null;
        }

        /** ELEMENT TYPE level */

        // handle wildcard on $elementType
        if (array_key_exists('*', $this->getPrivileges()[$systemName])) {
            return $this->getPrivileges()[$systemName]['*'];
        }

        // handle nonexistent $elementType
        if (!array_key_exists($elementType, $this->getPrivileges()[$systemName])) {
            return null;
        }

        /** ELEMENT ID level */

        // handle wildcard on $elementId
        if (array_key_exists('*', $this->getPrivileges()[$systemName][$elementType])) {
            return $this->getPrivileges()[$systemName][$elementType]['*'];
        }

        // handle nonexistent $elementId
        if (!array_key_exists($elementId, $this->getPrivileges()[$systemName][$elementType])) {
            return null;
        }

        /** COMPONENT level */

        // handle wildcard on $component
        if (array_key_exists('*', $this->getPrivileges()[$systemName][$elementType][$elementId])) {
            return $this->getPrivileges()[$systemName][$elementType][$elementId]['*'];
        }

        // handle nonexistent $component
        if (!array_key_exists($component, $this->getPrivileges()[$systemName][$elementType][$elementId])) {
            return null;
        }

        return $this->getPrivileges()[$systemName][$elementType][$elementId][$component];
    }

    /* ------------------------------------ Class Methods END ------------------------------------------ */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */

    /**
     * Set current privilege set.
     *
     * @param array $privileges
     *
     * @return \Maleficarum\Auth\Process\Privilege\Checker
     */
    public function setPrivileges(array $privileges = []): \Maleficarum\Auth\Process\Privilege\Checker {
        $this->privileges = $privileges;

        return $this;
    }

    /**
     * Fetch current privilege set.
     *
     * @return array
     */
    public function getPrivileges(): array {
        return $this->privileges;
    }

    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
