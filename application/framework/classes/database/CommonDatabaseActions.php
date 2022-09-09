<?php

interface CommonDatabaseActions
{
    public function save();
    public function delete();
    public function exists();
    public static function all();
    public static function find($id);
    public function update(array $new_attributes);
    public static function create(array $attributes);
    public static function find_by(string $column, $value);
    public static function query(string $sql, array $conditions = []);
    public function populateFieldsWithDatabase(ActiveRecordModel $object, array $attributes = []);
}
