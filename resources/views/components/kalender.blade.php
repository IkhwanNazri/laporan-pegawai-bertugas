 <div class="mt-8 bg-white  p-6 rounded-3xl shadow-sm border border-purple-200/60">
                <div class="flex items-center gap-3 mb-6">

                    <div>
                        <h2 class="text-xl font-bold text-purple-800 dark:text-white">Kalendar Bertugas</h2>
                        <p class="text-xs text-purple-500">Lihat jadual pegawai secara bulanan</p>
                    </div>
                </div>


                <div id="calendar" class="w-full text-sm"></div>
            </div>


            @php
                $jadualEvents = \App\Models\Jadual::with(['pegawai', 'bahagian'])->get()->map(function($jadual) {
                    // Warna berbeza untuk Harian (Biru) dan Mingguan (Hijau)
                    $warna = strtolower($jadual->jenis ?? '') == 'mingguan' ? '#10b981' : '#3b82f6';

                    return [
                        'title' => ($jadual->pegawai->name ?? 'Tiada Pegawai') . ' (' . ($jadual->bahagian->kod_bahagian ?? '-') . ')',
                        'start' => $jadual->tarikh,
                        'color' => $warna,
                        'description' => 'Aras: ' . $jadual->aras . ' | No Tel: ' . ($jadual->no_telefon ?? '-'),
                    ];
                });
            @endphp


            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,listWeek'
                        },
                        events: @json($jadualEvents),
                        height: 600,
                        eventClick: function(info) {
                            // Popup info bila klik pada nama di kalendar
                            alert(
                                'Pegawai Bertugas: ' + info.event.title + '\n' +
                                'Tarikh: ' + info.event.start.toLocaleDateString() + '\n' +
                                'Maklumat Tambahan: ' + info.event.extendedProps.description
                            );
                        }
                    });

                    calendar.render();
                });
            </script>

        </div>
