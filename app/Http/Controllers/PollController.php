<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\VotingList;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polls = Poll::where('deleted_at', NULL)->withCount('votingList')->paginate(10); //Only show active polls
        return view('polls', compact('polls'));
    }

    public function vote(Request $request, $pollId)
    {
        $optionId = $request->input('vote');
        $poll = Poll::findOrFail($pollId);
        $option = PollOption::findOrFail($optionId);

        $userId = session('id');  // Assuming you're using session for user ID

        // Check if the user has already voted for this poll
        $existingVote = VotingList::where('poll_id', $pollId)
                                    ->where('voter_id', $userId)
                                    ->first();

        if ($existingVote) {
            return response()->json(['error' => 'You have already voted for this poll.'], 400);
        }

        // Create a new vote entry
        VotingList::create([
            'poll_id' => $pollId,
            'poll_option_id' => $optionId,
            'voter_id' => $userId,
        ]);

        // Calculate the total votes for the selected option
        $voteCount = VotingList::where('poll_id', $pollId)
                                ->where('poll_option_id', $optionId)
                                ->count();

        // Return the updated vote count as a response
        return response()->json([
            'new_vote_count' => $voteCount,
            'redirect' => route('/polls')  // Add the redirect URL here
        ]);
    }

    // Show poll By Id
    public function showPollsForVoting()
    {
        $user = auth()->user(); // Get the logged-in user

        $polls = Poll::where('deleted_at', NULL)->withCount('votingList')->paginate(10); //Only show active polls
        return view('vote_cast', compact('polls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_poll',['title'=>'Add Poll']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Poll create karna
        $poll = Poll::create(['title' => $request->title]);

        // Poll options create karna
        foreach ($request->options as $index => $option) {
            $imagePath = null;
            if ($request->hasFile("images.$index")) {
                $imagePath = $request->file("images.$index")->store('poll_images', 'public');
            }

            $poll->options()->create([
                'option_name' => $option,
                'image' => $imagePath,
            ]);
        }

        return redirect()->route('polls');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch poll by ID, including related options, and ensure it is not soft deleted
        $poll = Poll::where('id', $id)->whereNull('deleted_at')->with('options')->first();

        // Check if poll exists
        if (!$poll) {
            return redirect()->route('polls')->with('error', 'Poll not found or has been deleted.');
        }

        // Return the 'update_poll' view with the poll data
        return view('update_poll', ['title' => 'Edit Poll', 'poll' => $poll]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'options' => 'required|array|min:1',
            'options.*' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image validation
        ]);
    
        // Retrieve the poll by ID or fail if not found
        $poll = Poll::findOrFail($id);
    
        // Update Poll Title
        $poll->title = $request->input('title');
        $poll->save(); // Save the poll title (new or updated)
    
        // Handle Poll Options
        $options = $request->input('options');
        $images = $request->file('images');
    
        // Update or create poll options
        foreach ($options as $index => $option) {
            // Check if this option exists, otherwise create a new one
            $pollOption = isset($poll->options[$index]) ? $poll->options[$index] : new PollOption();
            
            // Update option details
            $pollOption->poll_id = $poll->id;
            $pollOption->option_name = $option;
    
            // Handle Image Upload (if any)
            if (isset($images[$index])) {
                // Delete old image if exists
                if ($pollOption->image) {
                    Storage::delete($pollOption->image);
                }
    
                // Store the new image
                $imagePath = $images[$index]->store('poll_options', 'public');
                $pollOption->image = $imagePath;
            }
    
            // Save or update the poll option
            $pollOption->save();
        }
    
        // Delete any extra options that were removed from the form
        if (count($options) < count($poll->options)) {
        // Convert the Eloquent collection to an array and get the options to delete
            $optionsToDelete = array_slice($poll->options->toArray(), count($options));

            foreach ($optionsToDelete as $optionToDelete) {
                // Find the option model instance by ID to ensure we can delete it correctly
                $optionToDeleteModel = PollOption::find($optionToDelete['id']);
                
                // Delete the associated image if exists
                if ($optionToDeleteModel && $optionToDeleteModel->image) {
                    Storage::delete($optionToDeleteModel->image);
                }

                // Delete the option
                $optionToDeleteModel->delete();
            }
        }
        // Redirect or return with success message
        return redirect()->route('/polls')->with('success', 'Poll updated successfully!');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $poll = Poll::findOrFail($id);
        $poll->delete();  // Soft delete the record
    
        return redirect()->back()->with('success', 'Poll deleted successfully!');
    }
}
