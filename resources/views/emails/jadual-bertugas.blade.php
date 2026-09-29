<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jadual Bertugas Baharu</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f3f4f6; padding:30px;">

    <div style="max-width:600px; margin:auto; background:white; padding:30px; border-radius:12px;">

        <h2 style="color:#581c87;">
            Jadual Bertugas Baharu
        </h2>

        <p>
            Satu jadual bertugas baharu telah dibuat oleh pegawai.
        </p>

        <hr>

        <p>
            <strong>Tarikh:</strong>
            {{ $jadual->tarikh }}
        </p>

        <p>
            <strong>Aras:</strong>
            {{ $jadual->aras }}
        </p>

        <p>
            <strong>Bahagian:</strong>
            {{ $jadual->bahagian->nama_bahagian ?? '-' }}
        </p>

        <p>
            <strong>Jenis:</strong>
            {{ $jadual->jenis }}
        </p>

        <p style="margin-top:30px;">
            Sila log masuk ke dalam sistem untuk membuat semakan.
        </p>

    </div>

</body>
</html>
