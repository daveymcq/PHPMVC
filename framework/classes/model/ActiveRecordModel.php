<?php

class ActiveRecordModel extends MySQLDatabase
{
    protected $errors = [];
    protected $params = [];

    public function __construct(Array $attributes = [])
    {
        parent::__construct(APPLICATION_ROOT, $attributes);
        $this->params = $attributes;
        $this->table = strtolower(pluralize(get_class($this)));
        $this->populateFieldsWithDatabase($this, $attributes);
    }

    public function save()
    {
        if(empty($errors))
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

    public function update(Array $new_attributes)
    {
        $attributes = get_object_vars($this);

        foreach ($new_attributes as $attribute => $value)
        {
            if(isset($attributes[$attribute]))
            {
                $attributes[$attribute] = $value;
            }
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

    public static function create(Array $attributes)
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

        return false;
    }
}
