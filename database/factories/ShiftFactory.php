<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Department;
use App\Models\ShiftEmployee;
use Faker\Generator as Faker;

$factory->define(Shift::class, function (Faker $faker) {
        
    $department = factory(Department::class)->create();
    $dateBegin = $faker->dateTimeBetween($department->opened, 'now')->format("Y-m-d");
    
    return [
        'department_id' =>  $department->id,
        'date_begin'    =>  $dateBegin,
        'date_end'      =>  Carbon::createFromFormat('Y-m-d', $dateBegin)->addWeeks(2)->toDateString()
    ];
});

$factory->state(Shift::class, 'employees', [])
        ->afterCreatingState(Shift::class, 'employees', function($shift, Faker $faker) {            
            factory(ShiftEmployee::class, 1)->create(['shift_id' => $shift->id]);
        });
