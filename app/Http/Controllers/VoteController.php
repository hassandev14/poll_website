<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\VotingList;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote($id, Request $request)
    {

        // Find the item being voted for
        $item = Data::find($id);

        // If item not found, return an error
        if (!$item) {
            return response()->json(['error' => 'Item not found.'], 404);
        }

        // Increment the vote count by 1
        $item->votes += 1;
        $item->save();

        // Return the updated vote count to the frontend
        return response()->json([
            'votes' => $item->votes,
        ]);
    }
}
