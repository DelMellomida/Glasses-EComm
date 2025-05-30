<?php
// app/View/Components/Notification.php

namespace App\View\Components;

use Illuminate\View\Component;

class Notification extends Component
{
    public $position;
    public $maxNotifications;
    
    public function __construct($position = 'top-right', $maxNotifications = 5)
    {
        $this->position = $position;
        $this->maxNotifications = $maxNotifications;
    }

    public function render()
    {
        return view('components.notification');
    }
    
    public function getPositionClasses()
    {
        return match($this->position) {
            'top-left' => 'top-4 left-4',
            'top-right' => 'top-4 right-4',
            'bottom-left' => 'bottom-4 left-4',
            'bottom-right' => 'bottom-4 right-4',
            'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
            'bottom-center' => 'bottom-4 left-1/2 transform -translate-x-1/2',
            default => 'top-4 right-4'
        };
    }
}