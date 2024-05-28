<?php

use App\Jobs\RunFetchPornstarDataCommandJob;
use Illuminate\Support\Facades\Schedule;
//use Illuminate\Support\Facades\Artisan;

Schedule::job(new RunFetchPornstarDataCommandJob())->hourly();

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote');

