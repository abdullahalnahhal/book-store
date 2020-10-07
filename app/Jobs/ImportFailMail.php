<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ImportFailMail implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        Mail::to('xxxx@xx.xx')->text('Failed')->send();
    }
}