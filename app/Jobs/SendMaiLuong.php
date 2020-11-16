<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMaiLuong implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $luong;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($luong) {
        $this->luong = $luong;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $data = $this->luong;
        if (isset($data['email_send']) && $data['email_send']) {
            $emailUser = $data['email_send'];
            sendMailLuongPhuCap(['data' => $data], 'emails.gui_mail_luong', $data['title'], $emailUser, (object) ['name' => 'Điều Hành Tác Nghiệp', 'email' => getenv('MAIL_USERNAME')]);
        }
    }
}
