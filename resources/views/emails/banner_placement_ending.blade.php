<!DOCTYPE html>
<html>
<body>
    <h2>Penayangan Banner Akan Berakhir</h2>
    <p>Halo {{ $placement->brand->user->name }},</p>
    <p>Penayangan berbayar untuk banner <strong>{{ $placement->banner->title }}</strong> akan berakhir pada <strong>{{ $placement->end_date->translatedFormat('d M Y') }}</strong>.</p>
    <p>Jika Anda ingin memperpanjang, silakan kunjungi halaman banner di dashboard dan pilih "Perpanjang Penayangan".</p>
    <p>Terima kasih,<br>Tim ScanFit</p>
</body>
</html>
