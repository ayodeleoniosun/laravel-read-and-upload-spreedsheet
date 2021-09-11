<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendImportReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $tries = 1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $report = [];
        $report['has_successfuls'] = false;
        $report['has_failures'] = false;

        if (count($this->data['successful']) > 0) {
            $report['successful'] = implode(", ", $this->data['successful']);
            $report['has_successfuls'] = true;
        }

        if (count($this->data['failed']) > 0) {
            $report['failed'] = implode(", ", $this->data['failed']);
            $report['has_failures'] = true;
        }

        $subject = 'Contract Import Report';
        $report['subject'] = $subject;

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'suetco');
        });

        return $this->from('hello@contract.com', 'Color Elephant')
            ->subject(config('app.env').' '.$subject)
            ->view('email.import_report', ['report' => $report]);
    }
}
