<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class notifyAction extends Notification
{
    use Queueable;

    protected $action;
    protected $pump;
    protected $mode;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($action, $pump, $mode)
    {
        $this->action = $action;
        $this->pump = $pump;
        $this->mode = $mode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $p = $this->pump ? 'On' : 'Off';
        if ($this->pump == "true") {
            $p = "On";
        } else {
            $p = "Off";
        }

        return (new MailMessage)
            ->greeting('Hello!')
            ->line($this->action . ' is switched ' . $p)
            ->line('By ' . Auth::user()->name . " On " . date("l jS \of F Y h:i:s A"))
            ->action('Goto App', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
