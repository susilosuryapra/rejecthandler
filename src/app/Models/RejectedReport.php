<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Support\Str;

class RejectedReport extends Model
{
    use HasFactory, LogsActivity;

    protected static $recordEvents = [];

    protected $fillable = [
        'uuid',
        'tanggal',
        'jenis_barang',
        'nomor_produksi',
        'nomor_batch',
        'jumlah_barang',
        'jenis_cacat',
        'keputusan_handling',
        'catatan',
        'created_by_user_id',
        'checked_by_qc',
        'checked_by_prod',
        'checked_by_ppic',
        'checked_by_merch',
        'checked_by_stor',
        'checked_by_acc',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'jenis_cacat' => 'array',
        'keputusan_handling' => 'array',
        'checked_by_qc' => 'boolean',
        'checked_by_prod' => 'boolean',
        'checked_by_ppic' => 'boolean',
        'checked_by_merch' => 'boolean',
        'checked_by_stor' => 'boolean',
        'checked_by_acc' => 'boolean',
    ];

    // Auto generate UUID saat report dibuat
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    // Relasi ke user yang membuat report
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['jenis_barang', 'nomor_produksi', 'nomor_batch', 'checked_by_qc', 'checked_by_prod', 'checked_by_ppic', 'checked_by_merch', 'checked_by_stor', 'checked_by_acc'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Membuat report barang reject',
                'updated' => 'Mengupdate report barang reject',
                'deleted' => 'Menghapus report barang reject',
            });
    }
}
