<?php

namespace App\Repositories;

class TaskRepository
{
    //here also we can create a base repository which takes table name or model name and then we can use that variable directly over the whole repo rather than calling model again and again 
    public function allForUser($user)
    {
        return $user->tasks()->latest()->get();
    }

    public function createForUser($user, $data)
    {
        return $user->tasks()->create($data);
    }
}
