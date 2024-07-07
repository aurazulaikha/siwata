
<head>
    <title>Pemberitahuan Jadwal Sidang TA</title>
</head>
<body>
    <h1>Jadwal Sidang TA</h1>
    <p>Berikut adalah detail jadwal sidang TA yang baru:</p>
    <ul>
        <li>Mahasiswa: {{ $sidang_ta->mahasiswa->nama }}</li>
        <li>Tanggal: {{ $sidang_ta->tanggal }}</li>
        <li>Ruangan: {{ $sidang_ta->ruang->nama_ruangan }}</li>
        <li>Sesi: {{ $sidang_ta->sesi }}</li>
        <li>Pembimbing 1: {{ $sidang_ta->pembimbing1->nama }}</li>
        <li>Pembimbing 2: {{ $sidang_ta->pembimbing2->nama }}</li>
        <li>Ketua: {{ $sidang_ta->ketuaNama->nama }}</li>
        <li>Sekretaris: {{ $sidang_ta->sekretarisNama->nama }}</li>
        <li>Penguji 1: {{ $sidang_ta->penguji1->nama }}</li>
        <li>Penguji 2: {{ $sidang_ta->penguji2->nama }}</li>
    </ul>
</body>

