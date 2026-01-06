<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public bool $hideLogo;
    public bool $wide;

    public function __construct(bool $hideLogo = false, bool $wide = false)
    {
        $this->hideLogo = $hideLogo;
        $this->wide = $wide;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
