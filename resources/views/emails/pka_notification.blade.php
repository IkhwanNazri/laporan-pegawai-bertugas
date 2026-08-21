@component('mail::message')
@php
    $temaWarna = [
        'baharu'    => ['bg' => '#3B82F6', 'badge' => '#DBEAFE', 'text' => '#1E40AF', 'label' => 'LAPORAN BAHARU'],
        'kemaskini' => ['bg' => '#F59E0B', 'badge' => '#FEF3C7', 'text' => '#92400E', 'label' => 'KEMAS KINI ULASAN'],
        'selesai'   => ['bg' => '#10B981', 'badge' => '#D1FAE5', 'text' => '#065F46', 'label' => 'LAPORAN SELESAI'],
        'peringatan'=> ['bg' => '#EF4444', 'badge' => '#FEE2E2', 'text' => '#991B1B', 'label' => 'PERINGATAN TUGAS'],
    ];

    $warna = $temaWarna[$kategori ?? 'baharu'] ?? $temaWarna['baharu'];
@endphp

<div style="text-align: center; margin-bottom: 20px;">
    <span style="background-color: {{ $warna['badge'] }}; color: {{ $warna['text'] }}; padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">
        {{ $warna['label'] }}
    </span>
</div>

# {{ $tajuk ?? 'Pemberitahuan Sistem' }}

Salam Sejahtera **{{ $namaUser ?? 'Pegawai' }}**,

Berikut adalah maklumat notifikasi daripada Sistem Laporan:

@component('mail::panel')
<table style="width: 100%; border-collapse: collapse; font-size: 13px;">
    <tr>
        <td style="padding: 4px 0; color: #6B7280; width: 120px;"><strong>Kod Laporan:</strong></td>
        <td style="padding: 4px 0; color: #111827; font-weight: bold;">{{ $kodLaporan ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding: 4px 0; color: #6B7280;"><strong>Masa/Tarikh:</strong></td>
        <td style="padding: 4px 0; color: #111827;">{{ now()->format('d/m/Y h:i A') }}</td>
    </tr>
</table>
@endcomponent

<p style="font-size: 14px; color: #374151; line-height: 1.6;">
    {{ $mesej ?? '' }}
</p>

@if(isset($url) && $url !== '#')
@component('mail::button', ['url' => $url, 'color' => 'purple'])
Semak Dalam Sistem
@endcomponent
@endif

---
<p style="font-size: 11px; color: #9CA3AF; text-align: center;">
    Ini adalah e-mel automatik daripada sistem. Sila jangan balas e-mel ini.
</p>
@endcomponent
