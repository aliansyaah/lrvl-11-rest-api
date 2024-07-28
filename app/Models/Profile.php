<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'email', 'phone'];

    /**
     * Get the student that owns the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);

        /* 
         * Jika primary key di tabel student adalah "id_student", bukan "id" (default) 
         * Dan foreign key dari tabel student adalah "stu_id"
        */
        // return $this->belongsTo(Student::class, 'stu_id', 'id_student');
    }
}
