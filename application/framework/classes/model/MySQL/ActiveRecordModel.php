<?php

abstract class ActiveRecordModel extends MySQL 
{    
    public function __construct(array $attributes = [], bool $associations = true)
    {
        parent::__construct(APPLICATION_ROOT, $attributes);
        $this->table = strtolower(pluralize(get_class($this)));
        $this->populateFieldsWithDatabase($this, $attributes, $associations);
    }
}
