<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\VotingList;

class DashboardController extends Controller
{
   function index(){

      $polls = Poll::whereNull('deleted_at')->get();
      $totalVotes = VotingList::count();
      return view('home', compact('polls','totalVotes'));

   }
   public function showVotes()
   {
      // Voting list se sabhi votes fetch karen (user aur poll info sath)
      $votes = VotingList::with('user', 'poll')->get();

      return view('votes_list', compact('votes'));
   }
}
