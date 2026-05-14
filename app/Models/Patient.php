<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'no_rm',
        'kelas_bpjs',
        'diagnosis',
        'tanggal_masuk',
        'tanggal_keluar',
        'dpjp_id',
        'ruangan',
        'status',
        'los_final',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    // === RELASI ===

    public function dpjp()
    {
        return $this->belongsTo(User::class, 'dpjp_id');
    }

    public function inputBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // === ACCESSOR: Hitung LOS secara otomatis ===

    /**
     * LOS dalam hari (aktif: dari tanggal masuk hingga sekarang)
     * (sudah pulang: dari tanggal masuk hingga tanggal keluar)
     */
    public function getLosAttribute(): int
    {
        if ($this->status === 'pulang' && $this->tanggal_keluar) {
            return $this->los_final ?? $this->tanggal_masuk->diffInDays($this->tanggal_keluar);
        }
        return $this->tanggal_masuk->diffInDays(Carbon::today());
    }

    /**
     * Status early warning:
     * - 'aman'    : LOS <= 3 hari (hijau)
     * - 'warning' : LOS 4-5 hari  (kuning)
     * - 'overstay': LOS >= 6 hari (merah)
     */
    public function getWarningStatusAttribute(): string
    {
        $los = $this->los;
        if ($los >= 6) return 'overstay';
        if ($los >= 4) return 'warning';
        return 'aman';
    }

    /**
     * Label warna untuk Tailwind CSS
     */
    public function getWarningColorAttribute(): array
    {
        return match ($this->warning_status) {
            'overstay' => [
                'badge' => 'bg-red-100 text-red-800 border border-red-300',
                'row'   => 'bg-red-50',
                'dot'   => 'bg-red-500',
                'label' => 'Overstay',
                'icon'  => '🔴',
            ],
            'warning' => [
                'badge' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                'row'   => 'bg-yellow-50',
                'dot'   => 'bg-yellow-500',
                'label' => 'Mendekati Batas',
                'icon'  => '🟡',
            ],
            default => [
                'badge' => 'bg-green-100 text-green-800 border border-green-300',
                'row'   => 'bg-green-50',
                'dot'   => 'bg-green-500',
                'label' => 'Normal',
                'icon'  => '🟢',
            ],
        };
    }

    // === SCOPES ===

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePulang($query)
    {
        return $query->where('status', 'pulang');
    }
}
