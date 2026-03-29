<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1NF + 2NF + 3NF + 4NF: Separate all lookup/multi-valued attributes

        // Lookup: genders (eliminates repeating gender strings)
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
        });

        // Lookup: statuses (eliminates repeating status strings)
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->unique();
        });

        // Programs entity (2NF: program is its own entity, not a string attribute)
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('department')->nullable();
            $table->timestamps();
        });

        // Courses entity (4NF: courses are independent of programs)
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Students core entity (3NF: no transitive dependencies)
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 30)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('gender_id')->constrained('genders');
            $table->foreignId('program_id')->constrained('programs');
            $table->foreignId('status_id')->constrained('statuses');
            $table->string('email')->unique();
            $table->string('phone', 30)->nullable();
            $table->date('enrollment_date');
            $table->timestamps();
        });

        // 4NF: student_courses junction — resolves multi-valued dependency
        // A student can enroll in many courses; a course can have many students
        // These are independent multi-valued facts → separate table required by 4NF
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('grade', 5)->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'course_id']);
        });

        // Seed lookup tables
        DB::table('genders')->insert([
            ['name' => 'Male'],
            ['name' => 'Female'],
            ['name' => 'Other'],
        ]);

        DB::table('statuses')->insert([
            ['name' => 'Active'],
            ['name' => 'Inactive'],
            ['name' => 'Graduated'],
            ['name' => 'On Leave'],
        ]);

        DB::table('programs')->insert([
            ['code' => 'BSCS',  'name' => 'BS Computer Science',       'department' => 'College of Computing'],
            ['code' => 'BSIT',  'name' => 'BS Information Technology', 'department' => 'College of Computing'],
            ['code' => 'BSEE',  'name' => 'BS Electrical Engineering',  'department' => 'College of Engineering'],
            ['code' => 'BSBA',  'name' => 'BS Business Administration', 'department' => 'College of Business'],
            ['code' => 'BSED',  'name' => 'BS Education',               'department' => 'College of Education'],
        ]);

        DB::table('courses')->insert([
            ['code' => 'CS101',  'name' => 'Introduction to Programming',  'description' => 'Fundamentals of programming'],
            ['code' => 'CS201',  'name' => 'Data Structures',              'description' => 'Arrays, lists, trees, graphs'],
            ['code' => 'CS301',  'name' => 'Database Management Systems',  'description' => 'Relational databases and SQL'],
            ['code' => 'CS401',  'name' => 'Software Engineering',         'description' => 'SDLC and design patterns'],
            ['code' => 'MATH101','name' => 'Calculus I',                   'description' => 'Differential calculus'],
            ['code' => 'MATH201','name' => 'Discrete Mathematics',         'description' => 'Logic, sets, combinatorics'],
            ['code' => 'IT101',  'name' => 'Networking Fundamentals',      'description' => 'OSI model and protocols'],
            ['code' => 'IT201',  'name' => 'Web Development',              'description' => 'HTML, CSS, JavaScript'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('student_courses');
        Schema::dropIfExists('students');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('genders');
    }
};
