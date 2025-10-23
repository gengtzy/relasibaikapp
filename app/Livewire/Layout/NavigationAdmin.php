<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class NavigationAdmin extends Component
{
    public function logout(Logout $logout)
    {
        $logout();
        // Redirect bisa dilakukan di sini atau dari action
        return $this->redirect('/', navigate: true); 
    }
    public function render()
    {
        return view('livewire.layout.navigation-admin');
    }
}
