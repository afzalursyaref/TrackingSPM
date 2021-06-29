<div class="error-page">
    <h2 class="headline text-warning"> 404</h2>

    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Data tidak ditemukan.</h3>

        <p>
            Kami tidak dapat menemukan halaman yang Anda cari.
            Sementara itu, anda dapat <a href="/">Kembali ke Halaman utama</a> atau melakukan pencarian dengan kode baru.
        </p>

        <form class="search-form" action="{{ route('search') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="searchVal" class="form-control" placeholder="Cari JP - . . . .">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
  