<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    // app/Models/Task.php

    protected $fillable = ['title', 'description', 'status', 'feedback', 'deadline', 'user_id', 'tag_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    public function scopePending($query)
    {
        return $query->where('status', 'To Do');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'In Progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }
}
