<?php

interface Validation 
{
    public function validates_presence_of(string $attribute);
    public function validates_uniqueness_of(string $attribute);
    public function validates_format_of(string $attribute, string $regex);
    public function validates_length_of(string $attribute, int $minimum, int $maximum);
}
