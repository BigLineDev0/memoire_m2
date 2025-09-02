<?php
namespace App\Notifications;

use App\Models\Equipement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MaintenanceAlertNotification extends Notification
{
    use Queueable;

    protected $equipement;

    public function __construct(Equipement $equipement)
    {
        $this->equipement = $equipement;
    }

    public function via($notifiable)
    {
        return ['database']; // stocké en BDD
    }

    public function toDatabase($notifiable)
    {
        return [
            'equipement_id' => $this->equipement->id,
            'message' => "L'équipement '{$this->equipement->nom}' a été alerté pour une maintenance.",
        ];
    }
}
