<?php

class MySQLDatabase extends Database
{
    public function MySQLDatabase(String $table, Array $attributes = [])
    {
        $this->table = strtolower($table);
        $this->params = $attributes;
    }

    public static function query(String $sql, Array $conditions = [])
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

    public static function where(Array $conditions)
    {
        $table = strtolower(pluralize(get_called_class()));
        $number_of_conditions = count($conditions);
        $sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `table_name` = ?";
        
        $database_columns = static::query($sql, [$table]);
        $columns = '';

        for($i = 0; $i < count($database_columns); $i++)
        {
            $column = array_values($database_columns[$i])[0];

            if(!in_array($column, ['USER', 'CURRENT_CONNECTIONS', 'TOTAL_CONNECTIONS']))
            {
                $columns .= "`{$column}`";

                if($i < count($database_columns) - 1)
                {
                    $columns .= ', ';
                }
            }
        }

        $sql = "SELECT {$columns} FROM `{$table}`";

        if(count($conditions))
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
            if(count($results) > 1)
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

    public static function find($id)
    {
        $object = static::where(['id' => $id]);
        return (is_array($object)) ? end($object) : $object;
    }

    public static function find_by(String $column, $value)
    {
        return static::where([$column => $value]);
    }

    public static function all()
    {
        return static::where([]);
    }
}
