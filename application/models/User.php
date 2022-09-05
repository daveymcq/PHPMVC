<?php

class User extends Model
{
    public function validations()
    {
        validates_presence_of($this, 'email');
        validates_presence_of($this, 'first_name');
        validates_presence_of($this, 'last_name');
        validates_presence_of($this, 'phone_number');

        validates_uniqueness_of($this, 'email');

        validates_format_of($this, 'email', '/[\d\w\-\.]{2,}@[\d\w\-]{2,}.[\w]{1,}/');

        validates_length_of($this, 'first_name', 2, 20);
        validates_length_of($this, 'last_name', 2, 30);
    }   
}
