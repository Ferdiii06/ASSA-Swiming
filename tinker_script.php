<?php
$total = App\Models\Student::count();
echo "Total students: " . $total . "\n";

$keep = App\Models\Student::where('name', 'like', '%muh izzam%')->count();
echo "Students to keep (matching 'muh izzam'): " . $keep . "\n";

$deleted = App\Models\Student::where('name', 'not like', '%muh izzam%')->delete();
echo "Deleted " . $deleted . " students.\n";
