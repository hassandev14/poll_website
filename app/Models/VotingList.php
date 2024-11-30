<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class VotingList extends Model
{
    use HasFactory;
    protected $table = 'voting_list';
    protected $fillable = ['poll_id', 'poll_option_id', 'voter_id','vote_count'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voter_id');  // 'voter_id' foreign key hai
    }
    // Define relationship with Poll model
    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    // Define relationship with Option model (if you have one)
    public function pollOption(): BelongsTo
    {
        return $this->belongsTo(pollOption::class, 'id');
    }
}
