<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

// Se centralizo el envio de notificacion de correo para cuando es registro de nuevo usuario,
// Y para cuando el administrador ha respondido a la peticion de cambio de rol
class ChangeRoleNotification extends Notification
{
    use Queueable;
    private $user;
    private $action;
    /**
     * Create a new notification instance.
     */
    public function __construct(User|null $user = null, $action = null)
    {
        $this->user = $user;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Identificando que tipo de accion se va a realizar para cuando el adminstrador ha respondido a la peticion
        if ($this->action == 'accepted') {
            return (new MailMessage)
                ->line('Verified user role')
                ->line('Your role to be an adminstrator was accepted successfully');
        }

        if ($this->action == 'rejected') {
            return (new MailMessage)
                ->line('Verified user role')
                ->line('Your role to be an adminstrator was rejected. We will contact you soon');
        }

        // Si la accion es null el correo sera enviado al administrador para que lo acepte o rechace
        if ($this->action == null) {
            $url1 = url('/api/v1/changeRole/' . encrypt($this->user->id) . '/rejected');
            $url2 = url('/api/v1/changeRole/' . encrypt($this->user->id) . '/accepted');
            return (new MailMessage)
                ->view('mail.change', ['url1' => $url1, 'url2' => $url2, 'user' => $this->user]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
