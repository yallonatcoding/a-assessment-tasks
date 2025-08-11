<?php

namespace App\Infrastructure\Eloquent\Invitation;

use App\Domain\Invitation\Invitation;
use App\Domain\Invitation\InvitationRepositoryInterface;
use App\Infrastructure\Eloquent\Invitation\EloquentInvitationModel;
use App\Infrastructure\Eloquent\Invitation\InvitationMapper;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent implementation of the InvitationRepositoryInterface.
 */
class EloquentInvitationRepository implements InvitationRepositoryInterface
{
    public function findByUser(int $userId): array | \Exception
    {
        $models = [];

        try {
            $models = EloquentInvitationModel::where('user_id', $userId)->get();
        } catch (QueryException $e) {
            throw new \Exception("Failed to retrieve invitations for user ID {$userId}: " . $e->getMessage());
        }

        return $models
            ->map(fn ($model) => InvitationMapper::toDomain($model))
            ->toArray();
    }

    public function find(int $id): Invitation | \Exception
    {
        $model = null;

        try {
            $model = EloquentInvitationModel::findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new \Exception("Invitation with ID {$id} not found");
        }

        return InvitationMapper::toDomain($model);
    }

    public function create(Invitation $invitation): Invitation | \Exception
    {
        try {
            $model = EloquentInvitationModel::create(InvitationMapper::toPersistence($invitation));
        } catch (QueryException $e) {
            throw new \Exception("Failed to create invitation: " . $e->getMessage());
        }

        return InvitationMapper::toDomain($model);
    }

    public function update(Invitation $invitation): Invitation | \Exception
    {
        $updatedInvitation = null;

        try {
            $updatedInvitation = DB::transaction(function () use ($invitation) {
                $model = EloquentInvitationModel::findOrFail($invitation->id());
                $persisted = $model->getOriginal('updated_at');
                $passed = $invitation->updatedAt()->format('Y-m-d H:i:s');

                if ($persisted !== $passed) {
                    throw new \Exception("Invitation was modified by someone else");
                }

                $model->update(InvitationMapper::toPersistence($invitation));

                return InvitationMapper::toDomain($model);
            });
        } catch (ModelNotFoundException) {
            throw new \Exception("Invitation with ID {$invitation->id()} not found");
        } catch (QueryException $e) {
            throw new \Exception("Failed to update invitation: " . $e->getMessage());
        }

        return $updatedInvitation;
    }

    public function delete(int $id): bool | \Exception
    {
        try {

            return DB::transaction(function () use ($id) {
                $deleted = EloquentInvitationModel::destroy($id) > 0;

                if (!$deleted) {
                    throw new \Exception("Invitation with ID {$id} not found");
                }

                return $deleted;
            });
            
        } catch (ModelNotFoundException) {
            throw new \Exception("Invitation with ID {$id} not found");
        } catch (QueryException $e) {
            throw new \Exception("Failed to delete invitation: " . $e->getMessage());
        }
    }
}