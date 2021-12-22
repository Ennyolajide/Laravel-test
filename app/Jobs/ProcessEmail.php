<?php

namespace App\Jobs;

use App\Models\Email;
use http\Env\Request;
use App\Mail\SendEmail;
use App\Models\EmailAttachment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Http\Controllers\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sender;
    public $mailData;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sender,$mailData)
    {
        $this->sender = $sender;
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            Mail::to($this->mailData->email_address)
                ->send(new SendEmail($this->sender, $this->mailData));
            $attachments = $this->mailData->base64_attachments;
            $emailModel = $this->saveSentEmails($this->sender, $this->mailData);
            $emailModel ? $this->processBase64Attachments($attachments,$emailModel->id) : false;
            return true;
        } catch (\Exception $e) {
            Log::info('Cannot Dispatch ProcessEmail Job');
        }
        return false;
    }

    protected function saveSentEmails($sender, $mailData){
        try{
            return Email::create([
                'body' => $mailData->body,
                'subject' => $mailData->subject,
                'user_id' => $sender->id,
                'email' => $mailData->email_address
            ]);
        } catch (\Exception $e) {
            Log::info('Can not seve email');
            return false;
        }

    }

    protected function processBase64Attachments($attachments,$emailId){
        foreach((array)$attachments as $attachment){
            try{
                EmailAttachment::create([
                    'email_id' => $emailId,
                    'name' => $attachment['name'],
                    'attachment' => $attachment['image']
                ]);
            } catch (\Exception $e) {
                Log::info('Can not attachment to email ('.$emailId.')');
            }
        }
    }
}
