<?php

namespace App\Mail;

use App\Models\BannerPlacement;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BannerPlacementEndingMail extends Mailable
{
    use Queueable, SerializesModels;

    public BannerPlacement $placement;

    public function __construct(BannerPlacement $placement)
    {
        $this->placement = $placement;
    }

    public function build()
    {
        return $this->subject('Penayangan Banner Akan Berakhir')
            ->view('emails.banner_placement_ending');
    }
}
