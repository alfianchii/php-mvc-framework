<?php

namespace app\core;

abstract class DbModel extends Model
{
    // Take the table's name
    abstract public function tableName(): string;

    // Take the attributes
    abstract public function attributes(): array;

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

    // PDO syntaxes
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function rules(): array
    {
        return [];
    }
}