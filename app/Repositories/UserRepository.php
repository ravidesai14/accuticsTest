<?php

namespace App\Repositories;

class UserRepository
{
    public function getUser()
    {
        $userData =collect([
            ['id' => 1,'name' => 'Ravi', 'email' => 'ravidesai71@yahoo.com'],
            ['id' => 2,'name' => 'Desai', 'email' => 'desai@yahoo.com'],
            ['id' => 3,'name' => 'John', 'email' => 'john@yahoo.com'],
            ['id' => 4,'name' => 'Anders', 'email' => 'anders@yahoo.com'],
            ['id' => 5,'name' => 'Krish', 'email' => 'krish@yahoo.com'],
        ]);

        $user = $userData->where('name','Ravi');

        return $user;
    }
}