<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailDangKyLichTuan implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Đăng ký lịch tuần: '.$this->data->tenphong.' '.date('d/m/Y H:i', strtotime($this->data->time));

        sendMailMailer(['data' => (array) $this->data], 'emails.dangkylichtuan', $subject, [(object) ['email' => 'vanphong.dhdn@ac.udn.vn']], (object) ['name' => 'Điều Hành Tác Nghiệp', 'email' => env('MAIL_USERNAME', 'dieuhanh1@ac.udn.vn')]);
    }
}
