<?php

namespace App\Infrastructure\Eloquent\Invitation;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent model for the Invitation entity.
 *
 * @property string $uuid
 * @property int $user_id
 * @property int $invitated_user_id
 * @property bool $is_accepted
 */
class EloquentInvitationModel extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'invitated_user_id',
        'is_accepted',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invitations';
}