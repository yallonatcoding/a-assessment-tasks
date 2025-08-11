<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Invitation\InvitationRepositoryInterface;
use App\Domain\Invitation\Invitation;

/**
 * Class InvitationController
 *
 * Handles invitation-related requests.
 */
class InvitationController extends Controller
{
    private $invitations;

    public function __construct(
        InvitationRepositoryInterface $invitations
    ) {
        $this->invitations = $invitations;
    }

    public function index()
    {
        return inertia('Tasks/Index');
    }

	public function showAllByUser(Request $request)
	{
		$invitations = [];

		try {
            $invitations = $this->invitations->findByUser($request->user()->id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching invitations: ' . $e->getMessage(),
                'success' => false,
            ], 400);
        }

        return response()->json([
            'data' => $invitations,
            'message' => 'Invitations fetched successfully',
            'success' => true,
        ]);
	}
}