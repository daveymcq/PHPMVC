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
        $_SESSION['VALIDATION_ERRORS'][get_class($this)][] = $this->errors['full_messages'][$attribute];

        return false;
    }

    public function validates_length_of(string $attribute, int $minimum, int $maximum)
    {
        if((strlen($this->$attribute) >= $minimum) && (strlen($this->$attribute) < $maximum)) 
        {
            return true;
        }

        $this->errors['full_messages'][$attribute] = "{$attribute} must be between {$minimum} and {$maximum} characters.";
        $_SESSION['VALIDATION_ERRORS'][get_class($this)][] = $this->errors['full_messages'][$attribute];

        return false;
    }

    public function validates_format_of(string $attribute, string $regex)
    {
        if(preg_match($regex, $this->$attribute)) 
        {
            return true;
        }

        $this->errors['full_messages'][$attribute] = "{$attribute} is invalid.";
        $_SESSION['VALIDATION_ERRORS'][get_class($this)][] = $this->errors['full_messages'][$attribute];

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
        $_SESSION['VALIDATION_ERRORS'][get_class($this)][] = $this->errors['full_messages'][$attribute];

        return false;
    }

    // CommonDatabaseActions

    public function populateFieldsWithDatabase(ActiveRecordModel $object, array $attributes = [], $associations = true)
    {
        $table = $this->table;
        $schema = (empty($attributes)) ? $this->params : $attributes;
        $sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `table_name` = ? AND `TABLE_SCHEMA` = ?";
        $database_columns = $this->query($sql, [$table, APPLICATION_ROOT]);

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
                            $association = ucfirst(strstr($column, '_id', true));

                            if($association)
                            {
                                $foreign_key = singularize($table) . '_id';
                                $associated_table = pluralize(lcfirst($association));
                                $sql = "SELECT * FROM `{$associated_table}` WHERE `{$foreign_key}` = ?";
                                $associated_object_attibutes = static::query($sql, [$object->{$column}]);

                                if(count($associated_object_attibutes) === 1)
                                {
                                    $associated_object_attibutes = $associated_object_attibutes[0];
                                    $associated_object = new $association($associated_object_attibutes, false);
                                    $association = lcfirst($association);
                                    $foreign_key = singularize($table) . '_id';
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
                                        $foreign_key = singularize($table) . '_id';
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
                $this->id = $object->id;
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
                $this->id = $object->id;
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
            if(isset($attributes['id']))
            {
                $object = static::find($attributes['id']);
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

            if(isset($attributes['id']))
            {
                $id = $attributes['id'];
                unset($attributes['errors'], $attributes['id'], $attributes['table'], $attributes['params']);

                $number_of_attributes = count($attributes);

                if($number_of_attributes)
                {
                    $table = strtolower(pluralize(get_class($this)));
                    $column_names = array_keys($attributes);
                    $sql = "UPDATE `{$table}` SET ";
                    $sql_values = '';
                    $sql_where = "`id` = '{$id}'";

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
        $number_of_attributes = count($attributes);

        if(count($attributes))
        {
            unset($attributes['errors'], $attributes['table'], $attributes['params']);

            $table = strtolower(pluralize(get_class($this)));
            $number_of_attributes = count($attributes);
            $sql = 'DELETE FROM `' . $table . '` WHERE ';
            $column_names = array_keys($attributes);

            foreach($column_names as $attribute)
            {
                if($number_of_attributes > 0)
                {
                    $sql .= "`{$attribute}` = ?";

                    if($number_of_attributes > 1)
                    {
                        $sql .= " AND ";
                    }
                }

                $number_of_attributes--;
            }

            $result = static::query($sql, $attributes);

            if($result)
            {
                unset($attributes['id']);
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
            unset($attributes['errors'], $attributes['id'], $attributes['table'], $attributes['params']);

            $number_of_attributes = count($attributes);

            if($number_of_attributes)
            {
                $sql = 'INSERT INTO `' . $table . '`';
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
        $object = static::where(['id' => $id]);
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
