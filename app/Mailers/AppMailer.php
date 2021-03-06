<?php

namespace App\Mailers;

use App\Ticket;
use Illuminate\Contracts\Mail\Mailer;

/**
 * Class AppMailer
 * @package App\Mailers
 */
class AppMailer
{
    protected $mailer;
    protected $fromAddress = 'support@supportticket.dev';
    protected $fromName = 'Support Ticket';
    protected $to;
    protected $cc;
    protected $subject;
    protected $view;
    protected $data = [];

    /**
     * AppMailer constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param $user
     * @param Ticket $ticket
     */
    public function sendTicketInformation($user, Ticket $ticket)
    {
        $this->to = $user->email;
        $this->cc = $ticket->cc_email;
        $this->subject = "[Ticket ID: $ticket->ticket_id] $ticket->title";
        $this->view = 'emails.ticket_info';
        $this->data = compact('user', 'ticket');

        return $this->deliver();
    }

    /**
     * @param $ticketOwner
     * @param $user
     * @param Ticket $ticket
     * @param $comment
     */
    public function sendTicketComments($ticketOwner, $user, Ticket $ticket, $comment)
    {
        $this->to = $ticketOwner->email;
        $this->cc = $ticket->cc_email;
        $this->subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";
        $this->view = 'emails.ticket_comments';
        $this->data = compact('ticketOwner', 'user', 'ticket', 'comment');

        return $this->deliver();
    }

    /**
     * @param $ticketOwner
     * @param Ticket $ticket
     */
    public function sendTicketStatusNotification($ticketOwner, Ticket $ticket)
    {
        $this->to = $ticketOwner->email;
        $this->cc = $ticket->cc_email;
        $this->subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";
        $this->view = 'emails.ticket_status';
        $this->data = compact('ticketOwner', 'ticket');

        return $this->deliver();
    }

    public function deliver()
    {
        if($this->cc) {
            $this->mailer->send($this->view, $this->data, function ($message) {
                $message->from($this->fromAddress, $this->fromName)
                    ->to($this->to)
                    ->cc($this->cc)
                    ->subject($this->subject);
            });
        } else {
            $this->mailer->send($this->view, $this->data, function ($message) {
                $message->from($this->fromAddress, $this->fromName)
                    ->to($this->to)
                    ->subject($this->subject);
            });
        }

    }
}