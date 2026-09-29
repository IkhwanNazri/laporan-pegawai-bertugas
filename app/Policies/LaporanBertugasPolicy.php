<?php

namespace App\Policies;

use App\Models\Jadual;
use App\Models\LaporanBertugas;
use App\Models\User;

class LaporanBertugasPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, LaporanBertugas $laporanBertugas): bool
    {
        $jadual = $laporanBertugas->jadual;

        return $jadual->user_id === $user->id
            || $jadual->pegawai_ganti_id === $user->id;
    }

    public function create(User $user, Jadual $jadual): bool
    {
        return $user->role === 'pegawai_bertugas'
            && (
                $jadual->user_id === $user->id
                || $jadual->pegawai_ganti_id === $user->id
            );
    }

    public function update(User $user, LaporanBertugas $laporanBertugas): bool
    {
        $jadual = $laporanBertugas->jadual;

        return $jadual->user_id === $user->id
            || $jadual->pegawai_ganti_id === $user->id;
    }

    public function delete(User $user, LaporanBertugas $laporanBertugas): bool
    {
        return false;
    }

    public function restore(User $user, LaporanBertugas $laporanBertugas): bool
    {
        return false;
    }

    public function forceDelete(User $user, LaporanBertugas $laporanBertugas): bool
    {
        return false;
    }
}
