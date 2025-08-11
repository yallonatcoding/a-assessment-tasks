<?php

namespace App\Infrastructure\Eloquent\Invitation;

use App\Domain\Invitation\Invitation;
use App\Infrastructure\Eloquent\Invitation\EloquentInvitationModel;

/**
 * Mapper class to convert between Invitation domain objects and Eloquent models.
 */
class InvitationMapper
{
    public static function toDomain(EloquentInvitationModel $model): Invitation
    {
        return new Invitation(
            $model->id,
            $model->uuid,
            $model->user_id,
            $model->invitated_user_id,
            $model->is_accepted,
            $model->created_at,
            $model->updated_at
        );
    }

    public static function toPersistence(Invitation $invitation): array
    {
        return [
            'id' => $invitation->id(),
            'uuid' => $invitation->uuid(),
            'user_id' => $invitation->userId(),
            'invitated_user_id' => $invitation->invitatedUserId(),
            'is_accepted' => $invitation->isAccepted(),
            'created_at' => $invitation->createdAt(),
            'updated_at' => $invitation->updatedAt(),
        ];
    }
}