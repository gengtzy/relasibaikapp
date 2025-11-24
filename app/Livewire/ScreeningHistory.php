<?php

namespace App\Livewire;

use App\Models\Screening;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class ScreeningHistory extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $screening = Screening::where('user_id', Auth::id())->find($id);

        if ($screening) {
            // Hapus data (Cascade delete di database akan menghapus result & responses otomatis)
            $screening->delete();
            session()->flash('message', 'Data riwayat berhasil dihapus.');
        }
    }

    public function render()
    {
        $query = Screening::with(['result', 'recommendation'])
            ->where('user_id', Auth::id())
            ->where('status', 'saved'); // PENTING: Hanya tampilkan yang sudah disimpan user

        // Logic Search (Lokasi atau Tanggal)
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('lokasi', 'like', '%' . $this->search . '%')
                  ->orWhereDate('tanggal_pengisian', 'like', '%' . $this->search . '%');
            });
        }

        // Urutkan dari yang terbaru
        $screenings = $query->latest('tanggal_pengisian')->paginate(10);

        return view('livewire.screening-history', [
            'screenings' => $screenings
        ]);
    }
}
