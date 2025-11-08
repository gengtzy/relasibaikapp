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
    public $selectAll = false;
    public $selectedUsers = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUsers = User::pluck('id')->map(fn ($id) => (string) $id);
        } else {
            $this->selectedUsers = [];
        }
    }

    public function createNewUser()
    {
        return $this->redirect('usersnew', navigate: true);
    }

    public function editUser($id)
    {
        return $this->redirect("users/{$id}/edit", navigate: true);
    }

    public function deleteUser($id)
    {
        // Tambahkan proteksi agar tidak bisa menghapus diri sendiri
        if (auth()->id() == $id) {
            session()->flash('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
            return;
        }

        User::find($id)->delete();
        session()->flash('success', 'Pengguna berhasil dihapus.');
        $this->reset('selectAll', 'selectedUsers');
    }

    public function deleteSelected()
    {
        // Filter agar tidak bisa menghapus diri sendiri
        $filteredIds = array_filter($this->selectedUsers, fn ($id) => $id != auth()->id());
        
        User::whereIn('id', $filteredIds)->delete();
        session()->flash('success', 'Pengguna yang dipilih berhasil dihapus.');
        $this->reset('selectAll', 'selectedUsers');
    }


    public function render()
    {
        $users = User::query()
            ->where(function ($query) {
                // Request #3: Fungsi Search
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('role', 'like', '%' . $this->search . '%')
                    ->orWhere('superiority_role', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ]);
    }
}
