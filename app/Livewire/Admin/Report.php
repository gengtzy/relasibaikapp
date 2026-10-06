<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Report extends Component
{
    // State Kartu A (Rekap)
    public $recapStart;
    public $recapEnd;
    public $recapStatus = 'all';

    // State Kartu B (User)
    public $userSearch = '';
    public $selectedUserId = null;
    public $selectedUserName = null; 
    public $usersList = [];

    // State Kartu C (Statistik)
    public $statsYear;

    // State Kartu D (Payment Baru)
    public $paymentStart;
    public $paymentEnd;

    public function mount()
    {
        // Default Tanggal: Awal bulan ini sampai hari ini
        $this->recapStart = now()->startOfMonth()->format('Y-m-d');
        $this->recapEnd   = now()->format('Y-m-d');
        
        $this->paymentStart = now()->startOfMonth()->format('Y-m-d');
        $this->paymentEnd   = now()->format('Y-m-d');
        
        $this->statsYear  = date('Y');
    }

    // Live Search User (Dropdown)
    public function updatedUserSearch()
    {
        if (strlen($this->userSearch) > 2) {
            $this->usersList = User::where('role', 'masyarakat')
                ->where('name', 'like', '%' . $this->userSearch . '%')
                ->take(5)
                ->get();
        } else {
            $this->usersList = [];
        }
    }

    public function selectUser($id, $name)
    {
        $this->selectedUserId = $id;
        $this->selectedUserName = $name;
        $this->userSearch = ''; // Reset search
        $this->usersList = [];  // Tutup dropdown
    }
    
    public function printRecap()
    {
        $this->validate([
            'recapStart' => 'required|date',
            'recapEnd'   => 'required|date|after_or_equal:recapStart',
        ]);

        $url = route('report.print', [
            'type' => 'recap',
            'start' => $this->recapStart,
            'end' => $this->recapEnd,
            'status' => $this->recapStatus
        ]);

        $this->dispatch('open-new-tab', url: $url);
    }

    public function printUser()
    {
        $this->validate([
            'selectedUserId' => 'required'
        ], ['selectedUserId.required' => 'Silakan cari dan pilih pengguna terlebih dahulu.']);

        $url = route('report.print', [
            'type' => 'user',
            'user_id' => $this->selectedUserId
        ]);

        $this->dispatch('open-new-tab', url: $url);
    }

    public function printStats()
    {
        $url = route('report.print', [
            'type' => 'stats',
            'year' => $this->statsYear
        ]);

        $this->dispatch('open-new-tab', url: $url);
    }

    // FUNGSI BARU: Cetak Payment
    public function printPayment()
    {
        $this->validate([
            'paymentStart' => 'required|date',
            'paymentEnd'   => 'required|date|after_or_equal:paymentStart',
        ]);

        $url = route('report.print', [
            'type' => 'payment',
            'start' => $this->paymentStart,
            'end' => $this->paymentEnd
        ]);

        $this->dispatch('open-new-tab', url: $url);
    }

    public function render()
    {
        return view('livewire.admin.report');
    }
}