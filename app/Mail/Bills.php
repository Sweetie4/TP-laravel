<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Bills extends Mailable
{
    use Queueable, SerializesModels;

    protected $month;
    protected $user;
    protected $tenant;
    protected $box;
    protected $payment;
    /**
     * Create a new message instance.
     */
    public function __construct($month, $user, $tenant, $box, $payment)
    {
        $this->month = $month;
        $this->user = $user;
        $this->tenant = $tenant;
        $this->box = $box;
        $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if (!$this->user || !$this->user->email) {
            Log::error('Utilisateur ou email non défini', [$this->user]);
            throw new \Exception("L'adresse e-mail de l'utilisateur est invalide.");
        } else {
            $senderEmail = (string) $this->user->email;
            Log::info('senderEmail before Address', [$senderEmail, gettype($senderEmail)]);
            Log::info('User name before Address', [$this->user->name, gettype($this->user->name)]);
            return new Envelope(
                from: new Address($senderEmail, $this->user->name),
                subject: "Votre loyer du mois de $this->month"
            );
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.bill',
            with: [
                'tenant' => $this->tenant,
                'month' => $this->month,
                'box' => $this->box,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $filePath = explode('/',$this->payment->file_path)[2];
        if (!Storage::disk('public')->exists($filePath)) {
            Log::error("Le fichier joint est introuvable : $filePath");
            return [];
        }

        return [
            Attachment::fromStorageDisk('public',$filePath)
        ];
    }
}
