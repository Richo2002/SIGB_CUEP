<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $token = Password::createToken($notifiable);

        $url =  url(route('password.reset', [
            'token' => $token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $name = $this->user->lastname." ".$this->user->firstname;

        return (new MailMessage)
                    ->subject('Réinitialisation de mot de passe')
                    ->cc('adaniel@gouv.bj')
                    ->greeting('Cher(e) ' . $name . ',')
                    ->line('Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
                    ->line('Veuillez cliquer sur le bouton ci-dessous pour réinitialiser votre mot de passe :')
                    ->action('Réinitialiser', $url)
                    ->line("Si vous avez des questions ou rencontrez des problèmes, n'hésitez pas à nous contacter à l'adresse mesrs.cuepinfos@gouv.bj")
                    ->line("Nous vous remercions d'avoir rejoint notre application !")
                    ->salutation('Cordialement, ' . config('app.name'));
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
