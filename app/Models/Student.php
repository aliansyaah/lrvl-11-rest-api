<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name'];

    /**
     * Get the profile associated with the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);

        /* 
         * Jika foreign key di tabel profiles adalah "stu_id", bukan "student_id" 
         * Dan primary key di tabel student adalah "id_student"
        */
        // return $this->hasOne(Profile::class, 'stu_id');
        // return $this->hasOne(Profile::class, 'stu_id', 'id_student);
    }
}
