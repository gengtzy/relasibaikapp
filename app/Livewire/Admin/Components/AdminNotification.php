<?php

namespace App\Livewire\Admin\Components;

use App\Models\User;
use Livewire\Component;

class AdminNotification extends Component
{
    public function render()
    {
        $query = User::query()
            ->where('role', 'masyarakat')
            ->where(function($q) {
                $q->whereNull('superiority_role')
                  ->orWhere('superiority_role', '')
                  ->orWhere('superiority_role', '-');
            });

        $pendingUsers = $query->latest()->take(5)->get();
        
        $count = $query->count();

        return view('livewire.admin.components.admin-notification', [
            'pendingUsers' => $pendingUsers,
            'count' => $count
        ]);
    }
}
