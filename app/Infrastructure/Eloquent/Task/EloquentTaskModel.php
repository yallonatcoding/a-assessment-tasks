<?php

namespace App\Infrastructure\Eloquent\Task;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent model for the Task entity.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $isCompleted
 */
class EloquentTaskModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'isCompleted',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';
}
