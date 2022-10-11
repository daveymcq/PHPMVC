<?php

class MySQL extends Database implements CommonDatabaseActions, Validation
{
    public function __construct(string $table, array $attributes = [], bool $associations = true)
    {
        $this->table = strtolower($table);
        $this->params = $attributes;
    }

    // Validation

    public function validates_presence_of(string $attribute)
    {
        if(strlen($this->$attribute)) 
        {
            return true;
        }

        $this->errors['full_messages'][$attribute] = "{$attribute} must be present.";
        $_SESSION['VALIDATION_ERRORS'][ucfirst(get_class($this))][] = $this->errors['full_messages'][$attribute];

        return false;
    }

    public function validates_length_of(string $attribute, int $minimum, int $maximum)
    {
        if((strlen($this->$attribute) >= $minimum) && (strlen($this->$attribute) < $maximum)) 
        {
            return true;
        }

        $this->errors['full_messages'][$attribute] = "{$attribute} must be between {$minimum} and {$maximum} characters.";
        $_SESSION['VALIDATION_ERRORS'][ucfirst(get_class($this))][] = $this->errors['full_messages'][$attribute];

        return false;
    }

    public function validates_format_of(string $attribute, string $regex)
    {
        if(preg_match($regex, $this->$attribute)) 
        {
            return true;
        }

        $this->errors['full_messages'][$attribute] = "{$attribute} is invalid.";
        $_SESSION['VALIDATION_ERRORS'][ucfirst(get_class($this))][] = $this->errors['full_messages'][$attribute];

        return false;
    }

    public function validates_uniqueness_of(string $attribute)
    {
        $object = $this->find_by($attribute, $this->$attribute);

        if($object === null) 
        {
            return true;
        }

        $this->errors['full_messages'][$attribute] = "{$attribute} already exists.";
        $_SESSION['VALIDATION_ERRORS'][ucfirst(get_class($this))][] = $this->errors['full_messages'][$attribute];

        return false;
    }

    // CommonDatabaseActions

    public function populateFieldsWithDatabase(ActiveRecordModel $object, array $attributes = [], $associations = true)
    {
        $table = $this->table;
        $schema = (empty($attributes)) ? $this->params : $attributes;
        $sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `table_name` = ? AND `TABLE_SCHEMA` = ?";
        $database_columns = $this->query($sql, [$table, strtolower(DB_NAME)]);

        for($i = 0; $i < count($database_columns); $i++)
        {
            $column = array_values($database_columns[$i])[0];
            $exclusions = [];

            if(!property_exists($object, $column))
            {
                if(!in_array($column, $exclusions))
                {
                    if(isset($schema[$column]))
                    {
                        $object->{$column} = $schema[$column];

                        if($associations)
                        {
                            $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
                            $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];
                            
                            $association = ucfirst(strstr($column, "_{$primary_key}", true));

                            if($association)
                            {
                                $associated_table = pluralize(lcfirst($association));
                                $foreign_key = singularize($table) . "_{$primary_key}";
                                $sql = "SELECT * FROM `{$associated_table}` WHERE `{$foreign_key}` = ?";

                                $associated_object_attibutes = static::query($sql, [$object->{$primary_key}]);

                                if(count($associated_object_attibutes) === 1)
                                {
                                    $associated_object_attibutes = $associated_object_attibutes[0];
                                    $associated_object = new $association($associated_object_attibutes, false);
                                    $association = lcfirst($association);
                
                                    $object->{$association} = $associated_object;

                                    unset($object->{$column});
                                    unset($associated_object->$foreign_key);
                                }

                                else if(count($associated_object_attibutes) > 1)
                                {
                                    foreach($associated_object_attibutes as $associated_object_attibute)
                                    {
                                        $associated_object = new $association($associated_object_attibute, false);
                                        $association = lcfirst($association);

                                        $object->{pluralize($association)}[] = $associated_object;

                                        unset($object->{$column});
                                        unset($associated_object->$foreign_key);
                                    }
                                }
                            }
                        }
                    }   
                }
            }
        }

        if(property_exists($object, 'errors')) 
        {
            unset($object->errors);
        }

        if(property_exists($object, 'params')) 
        {
            unset($object->params);
        }

        if(property_exists($object, 'table')) 
        {
            unset($object->table);
        }

        return $object;
    }

    public static function query(string $sql, array $conditions = [])
    {
        $query = (static::getInstance()->getConnection())->prepare($sql);
        $select_query = (strtoupper(explode(' ', $sql)[0]) === 'SELECT');

        if(count($conditions))
        {
            $results = $query->execute(array_values($conditions));
        }
        
        else
        {
            $results = $query->execute();
        }

        if($select_query)
        {
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        return $results;
    }

    public static function where(array $conditions)
    {
        $table = strtolower(pluralize(get_called_class()));
        $number_of_conditions = count($conditions);

        $sql = "SELECT * FROM `{$table}`";

        if($number_of_conditions)
        {
            $sql .= " WHERE";

            foreach($conditions as $column => $value)
            {
                $sql .= " `{$column}` = ?";

                if($number_of_conditions > 1)
                {
                    $sql .= ' AND';
                }

                $number_of_conditions--;
            }
        }

        $results = static::query($sql, $conditions);

        if($results)
        {
            if(count($results))
            {
                $objects = [];

                for($i = 0; $i < count($results); $i++)
                {
                    $object = new static($results[$i]);
                    $objects[] = $object;
                }

                return $objects;
            }

            else
            {
                $object = new static(end($results));
                return $object;
            }
        }

        return null;
    }

    public function save()
    {
        if(!$this->exists())
        {
            $attributes = get_object_vars($this);
            $object = $this->create($attributes);

            $object = (is_array($object)) ? end($object) : $object;

            if($object) 
            {
                $table = strtolower(pluralize(get_class($this)));
                $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
                $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];
                $this->{$primary_key} = $object->{$primary_key};
            }
            
            return $object;
        }

        else
        {
            $attributes = get_object_vars($this);
            $object = $this->update($attributes);

            $object = (is_array($object)) ? end($object) : $object;

            if($object) 
            {
                $table = strtolower(pluralize(get_class($this)));
                $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
                $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];
                $this->{$primary_key} = $object->{$primary_key};
            }
            
            return $object;
        }
        
        return false;
    }

    public function exists()
    {
        $attributes = get_object_vars($this);

        if(count($attributes))
        {
            $table = strtolower(pluralize(get_class($this)));
            $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
            $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];

            if(isset($attributes[$primary_key]))
            {
                $object = static::find($attributes[$primary_key]);
                return ($object) ? true : false;
            }
        }

        return false;
    }

    public function update(array $new_attributes)
    {
        $object = new (get_called_class())($new_attributes);

        if(method_exists(get_class($object), 'validations'))
        {
            $object->validations();
        }

        if(empty($object->errors))
        {
            $attributes = get_object_vars($this);

            foreach($new_attributes as $attribute => $value)
            {
                if(isset($attributes[$attribute]))
                {
                    $attributes[$attribute] = $value;
                }
            }

            foreach(array_keys($attributes) as $attribute)
            {
                if(is_subclass_of($attributes[$attribute], 'ActiveRecordModel')) unset($attributes[$attribute]);
                if(is_array($attributes[$attribute])) unset($attributes[$attribute]);
            }

            $table = strtolower(pluralize(get_class($this)));
            $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
            $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];

            if(isset($attributes[$primary_key]))
            {
                $id = $attributes[$primary_key];
                unset($attributes['errors'], $attributes[$primary_key], $attributes['primary_key'], $attributes['table'], $attributes['params']);

                $number_of_attributes = count($attributes);

                if($number_of_attributes)
                {
                    $table = strtolower(pluralize(get_class($this)));
                    $column_names = array_keys($attributes);

                    $sql_values = '';
                    $sql = "UPDATE `{$table}` SET ";
                    $sql_where = "`{$primary_key}` = '{$id}'";

                    foreach($column_names as $attribute)
                    {
                        if($number_of_attributes > 0)
                        {
                            $sql_values .= " `{$attribute}` = ?";

                            if($number_of_attributes > 1)
                            {
                                $sql_values .= ', ';
                            }
                        }

                        $number_of_attributes--;
                    }

                    $sql .= "{$sql_values} WHERE {$sql_where}";
                    $result = static::query($sql, $attributes);

                    if($result)
                    {
                        $object = static::where($attributes);
                        return $object;
                    }
                }
            }
        }

        return false;
    }

    public function delete()
    {
        $attributes = get_object_vars($this);

        if(count($attributes))
        {
            unset($attributes['errors'], $attributes['table'], $attributes['params'], $attributes['primary_key']);

            $table = strtolower(pluralize(get_class($this)));
            $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
            $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];

            $sql = "DELETE FROM `{$table}` WHERE `{$primary_key}` = ?";

            $result = static::query($sql, [$attributes[$primary_key]]);

            if($result)
            {
                unset($attributes[$primary_key]);
                return new static($attributes);
            }
        }

        return false;
    }

    public static function create(array $attributes)
    {
        $object = new (get_called_class())($attributes);

        if(method_exists(get_called_class(), 'validations'))
        {
            $object->validations();
        }

        if(empty($object->errors))
        {
            $table = strtolower(pluralize(get_called_class()));
            $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
            $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];
            
            unset($attributes['errors'], $attributes[$primary_key], $attributes['table'], $attributes['params'], $attributes['primary_key']);

            $number_of_attributes = count($attributes);

            if($number_of_attributes)
            {
                $sql = "INSERT INTO `{$table}`";
                $sql_columns = '';
                $sql_values = '';

                $column_names = array_keys($attributes);

                foreach($column_names as $attribute)
                {
                    if($number_of_attributes > 0)
                    {
                        $sql_columns .= "`{$attribute}`";
                        $sql_values .= "?";


                        if($number_of_attributes > 1)
                        {
                            $sql_columns .= ', ';
                            $sql_values .= ', ';
                        }
                    }

                    $number_of_attributes--;
                }

                $sql .= " ({$sql_columns}) VALUES({$sql_values})";
                $result = static::query($sql, $attributes);

                if($result)
                {
                    $object = static::where($attributes);
                    return $object;
                }
            }
        }

        return false;
    }

    public static function find($id)
    {
        $table = strtolower(pluralize(get_called_class()));
        $sql = "SELECT k.column_name FROM information_schema.table_constraints t JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type = 'PRIMARY KEY' AND t.table_schema = ? AND t.table_name = ?";
        $primary_key = array_values(static::query($sql, [DB_NAME, $table])[0])[0];

        $object = static::where([$primary_key => $id]);
        return (is_array($object)) ? $object[0] : $object;
    }

    public static function find_by(string $column, $value)
    {
        return static::where([$column => $value]);
    }

    public static function all()
    {
        return static::where([]);
    }
}
