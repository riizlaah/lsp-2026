<x-dashb>
    <h1>Halo, <?= getAuthData()["fullName"] ?? "Admin" ?>!</h1>
    <p>Apa yang akan kamu lakukan sekarang?</p>
    <ul>
        <li><span>Ingin membuat <a href="/manage-articles/create">artikel baru?</a></span></li>
        <li><span>Atau <a href="/manage-announcements/create">pengumuman baru?</a></span></li>
        <li><span>Mungkin ada <a href="/manage-achievements/create">prestasi baru?</a></span></li>
        <li><span>Atau yang <a href="/dashboard/other">lainnya?</a></span></li>
    </ul>
</x-dashb>