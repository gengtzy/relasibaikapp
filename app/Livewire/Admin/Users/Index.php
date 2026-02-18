<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public $showModal = false;
    public $deleteId = null;
    public $deleteCode = ''; // Untuk menyimpan Nama User
    public $isBulkDelete = false;
    public $bulkCount = 0;

    public $selectAll = false;
    public $selectedUsers = [];
    public $filter = '';

    public function mount()
    {
        $this->filter = request()->query('filter');
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUsers = $this->getUsersQuery()
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function resetSelection()
    {
        $this->selectAll = false;
        $this->selectedUsers = [];
    }

    public function createNewUser()
    {
        return $this->redirect('usersnew', navigate: true);
    }

    public function editUser($id)
    {
        return $this->redirect("users/{$id}/edit", navigate: true);
    }

    public function executeDelete()
    {
        if ($this->isBulkDelete) {
            $this->deleteSelected();
        } else {
            $this->delete();
        }
    }

    public function delete()
    {
        if ($this->deleteId) {
            // Proteksi hapus diri sendiri
            if (auth()->id() == $this->deleteId) {
                session()->flash('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
                $this->resetDeleteState();
                return;
            }

            $user = User::find($this->deleteId);
            if ($user) {
                $name = $user->name;
                $user->delete();
                session()->flash('success', "Pengguna '{$name}' berhasil dihapus.");
            }
        }
        $this->resetDeleteState();
    }

    public function deleteSelected()
    {
        if (empty($this->selectedUsers)) return;

        // Filter agar tidak bisa menghapus diri sendiri
        $filteredIds = array_filter($this->selectedUsers, fn ($id) => $id != auth()->id());
        
        if (empty($filteredIds)) {
            session()->flash('error', 'Tidak ada data yang dipilih atau Anda mencoba menghapus akun sendiri.');
            $this->resetDeleteState();
            return;
        }

        $count = count($filteredIds);
        User::whereIn('id', $filteredIds)->delete();
        
        session()->flash('success', "{$count} pengguna berhasil dihapus.");
        $this->resetDeleteState();
    }

    private function resetDeleteState()
    {
        $this->deleteId = null;
        $this->isBulkDelete = false;
        $this->resetSelection();
        $this->dispatch('close-modal');
    }

    protected function getUsersQuery()
    {
        $query = User::query()->latest();

        if ($this->filter === 'no_role') {
            $query->where('role', 'masyarakat')
                  ->whereNull('superiority_role');
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'ilike', '%' . $this->search . '%')
                  ->orWhere('email', 'ilike', '%' . $this->search . '%')
                  ->orWhere('role', 'ilike', '%' . $this->search . '%')
                  ->orWhere('superiority_role', 'ilike', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function render()
    {
        $users = $this->getUsersQuery()->paginate($this->perPage);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ]);
    }
}
