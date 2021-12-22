<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Jobs\ProcessEmail;
//use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\File;


class EmailJobDispatchTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_email_job_dispatch()
    {
        Bus::fake();
        $user = User::factory()->create(); //Create a user for Api auth
        $testData  = json_decode(File::get(public_path('test.json')))->emails[0];
        ProcessEmail::dispatch($user, $testData);
        Bus::assertDispatched(ProcessEmail::class, function ($job) use ($user, $testData) {
            return $job->mailData->subject === $testData->subject;
        });
    }
}
