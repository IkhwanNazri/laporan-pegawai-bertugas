<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PkaSystemNotification extends Notification
{
    use Queueable;

    protected $tajuk;
    protected $mesej;
    protected $url;
    protected $kodLaporan;
    protected $namaUser;
    protected $kategori; // 'baharu', 'kemaskini', 'selesai', 'peringatan'

    public function __construct($tajuk, $mesej, $url = '#', $kodLaporan = '-', $namaUser = '-', $kategori = 'baharu')
    {
        $this->tajuk = $tajuk;
        $this->mesej = $mesej;
        $this->url = $url;
        $this->kodLaporan = $kodLaporan;
        $this->namaUser = $namaUser;
        $this->kategori = strtolower($kategori);
    }

    // Hantar melalui Database dan Mail (E-mel)
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    // Format Notifikasi E-mel
   public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[' . strtoupper($this->kategori) . '] ' . $this->tajuk)
            ->markdown('emails.pka_notification', [  // <-- Fail Blade khas E-mel
                'tajuk'      => $this->tajuk,
                'mesej'      => $this->mesej,
                'kodLaporan' => $this->kodLaporan,
                'url'        => $this->url,
            ]);
    }
    // Format Notifikasi Pangkalan Data
  public function toDatabase($notifiable)
    {
        return [
            'tajuk'      => $this->tajuk,
            'mesej'      => $this->mesej,
            'url'        => $this->url,
            'kategori'   => $this->kategori,
        ];
    }
}
