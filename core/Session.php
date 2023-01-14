<?php

namespace app\core;

class Session
{
    // Flash key
    protected const FLASH_KEY = "flash_messages";

    // Constructor (when the class was instaced, run this constructor)
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

        // Set the flash into session
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    // Set the flash session
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            "remove" => false,
            "value" => $message,
        ];
    }

    // Get the flash session
    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]["value"] ?? false;
    }

    // Set the session
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Get the session
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    // Remove the session
    public function remove($key)
    {
        unset($_SESSION[$key]);
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

        // Set the flash into session
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}