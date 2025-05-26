<?php

namespace App\Mail;

use App\Models\Material;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MaterialDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $material;

    public function __construct(Material $material)
    {
        $this->material = $material;
    }

    public function build()
    {
        return $this->subject('Material Deleted')
            ->view('emails.material_deleted');
    }
}
