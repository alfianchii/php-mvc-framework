<?php

namespace app\core;

use app\core\db\DbModel;

abstract class UserModel extends DbModel
{
    // For take the User's firstname and lastname
    abstract public function getDisplayName(): string;
}