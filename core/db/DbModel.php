<?php

namespace app\core\db;

use app\core\{Application, Model};

abstract class DbModel extends Model
{
    // Take the table's name of a model
    abstract public static function tableName(): string;

    // Take the attributes of a model
    abstract public function attributes(): array;

    // Take the primary key of a model
    abstract public static function primaryKey(): string;

    // Insert attributes to the tableName
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                    VALUES (" . implode(",", $params) . ")");

        // Bind value
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    // Search one data of a table
    public static function findOne($where) // [email => alfianchii@example.com, firstname => alfianchii]
    {
        // Because the tableName() was abstract, therefore use static keyword
        $tableName = static::tableName();
        $attributes = array_keys($where);

        // SELECT * FROM $tableName WHERE email = :email AND firstname = :firstname
        $sql = implode("AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        // Binding the values
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        // Execute the SQL syntax
        $statement->execute();

        // Return instance of, for example, the user class
        return $statement->fetchObject(static::class);
    }

    // PDO syntaxes
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    // Default rules
    public function rules(): array
    {
        return [];
    }
}