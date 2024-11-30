<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;  // Import this


class Poll extends Model
{
    use HasFactory;
    use SoftDeletes;  // Add this trait
    // Define the table name
    protected $fillable = ['title'];

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }
    public function votingList(): HasMany  
    {
        return $this->hasMany(VotingList::class, 'poll_id');
    }
}
