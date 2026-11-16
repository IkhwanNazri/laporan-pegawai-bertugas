// Senarai semak Bahagian A: [perkara, sub-perkara (array) atau null]
export const senaraiSemak = {
    1: ['Semua pegawai telah meninggalkan pejabat pada jam 6.00 petang.', null],
    2: ['Pegawai-pegawai bekerja lebih masa (selepas jam 6.00 petang)', null],
    3: ['Pintu-pintu bilik yang berkaitan telah ditutup/dikunci:', ['(i) Pintu kecemasan (rintangan api)', '(ii) Pintu bilik pegawai', '(iii) Bilik-bilik lain (stor/ fail dll)']],
    4: ['Suis elektrik di ruang gunasama telah dimatikan:', ['(i) Lampu-lampu gunasama', '(ii) Mesin fotostat/ mesin pejabat']],
    5: ['Workstation (ruang kerja) pegawai:', ['(i) Suis komputer dimatikan', '(ii) Dokumen/ fail terperingkat tidak berada di atas meja']],
    6: ['Bilik mesyuarat/ perbincangan:', ['(i) Semua suis elektrik dimatikan', '(ii) Peralatan makan/ minum dikemaskan selepas mesyuarat']],
    7: ['Bilik pantry:', ['(i) Paip air telah ditutup', '(ii) Suis peralatan elektrik telah dimatikan']],
}

// Format tarikh laporan: 12.11.2026 (Khamis)
export const tarikhLaporan = (tarikh) => {
    if (!tarikh) return '-'
    const d = new Date(tarikh)
    const p = (n) => String(n).padStart(2, '0')
    return `${p(d.getDate())}.${p(d.getMonth() + 1)}.${d.getFullYear()} (${d.toLocaleDateString('ms-MY', { weekday: 'long' })})`
}
