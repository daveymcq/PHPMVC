<?php

class MySQLDatabase extends Database
{
    public function __construct(String $table, Array $attributes = [])
    {
        $this->table = strtolower($table);
        $this->params = $attributes;
    }

    public static function query(String $sql, Array $params = [])
    {
        $query = (static::getInstance()->getConnection())->prepare($sql);

        if(count($params))
            $result = $query->execute(array_values($params));
        else
            $result = $query->execute();

        if(strtoupper(explode(' ', $sql)[0]) == 'SELECT')
        {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        return ($result) ? true : false;
    }

    public static function where(Array $conditions)
    {
        $table = pluralize(2, get_called_class());
        $number_of_conditions = count($conditions);
        $sql = "SELECT `*` FROM `{$table}`";

        if(count($conditions))
        {
            $sql .= " WHERE";
            
            foreach($conditions as $column => $value)
            {
                $sql .= " `{$column}` = '{$value}'";

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

    public function all()
    {
        return static::where([]);
    }
}
