<?php

namespace App\Infrastructure\Eloquent\UserTask;

use Illuminate\Database\Eloquent\Model;

class EloquentUserTaskModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'task_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_tasks';
}
