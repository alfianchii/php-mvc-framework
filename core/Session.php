<?php

namespace app\core;

class Session
{
    // Flash key
    protected const FLASH_KEY = "flash_messages";

    public function __construct()
    {
        // Start the session
        session_start();

        // Take all of flash messages
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // Note: & symbol as reference
        foreach ($flashMessages as $key => &$flashMessage) {
            // Mark to be remove
            $flashMessage["remove"] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    // Set the sessions
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            "remove" => false,
            "value" => $message,
        ];
    }

    // Get the sessions
    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]["value"] ?? false;
    }

    // Destroy the sessions
    public function __destruct()
    {
        // Iterate over the flash messages
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // Note: & symbol as reference
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage["remove"]) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}