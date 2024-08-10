<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // protected $fillable = ['student_id', 'comment'];
    protected $fillable = ['comment'];

    /**
     * Get the student that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function student(): BelongsTo
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
