<?php

namespace app\core;

abstract class UserModel extends DbModel
{
    // For take the User's firstname and lastname
    abstract public function getDisplayName(): string;
}