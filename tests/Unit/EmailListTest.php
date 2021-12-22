<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
//use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailListTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_email_list()
    {
        $user = User::factory()->create();
        $data  = json_decode(File::get(public_path('test.json')));
        $this->actingAs($user)->postJson('/api/send',[
            'emails' => $data->emails
        ])->assertStatus(200);

        $response = $this->actingAs($user)->postJson('/api/list');

        $response->assertStatus(200);

        $sentEmails = json_decode($response->getContent())->emails;

        foreach ($sentEmails as $index => $sentEmail){
            $check = $data->emails[$index];
            $this->assertEquals($check->subject, $sentEmail->subject);
            $this->assertEquals($check->body, $sentEmail->body);
            //dd($sentEmail);
            foreach ($sentEmail->attachments as $index => $attachment){
                $this->assertEquals($check->base64_attachments[$index]->name, $attachment->name);
            }
        }

    }
}
