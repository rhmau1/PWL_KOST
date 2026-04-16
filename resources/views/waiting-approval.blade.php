<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Verifikasi - PWL KOST</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg border border-gray-200 text-center">
        <!-- SVG Icon -->
        <svg class="w-16 h-16 mx-auto mb-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Pendaftaran Berhasil!</h2>
        
        <p class="text-gray-600 mb-6 leading-relaxed">
            Terima kasih telah mendaftar. Bukti pembayaran dan data Anda sedang dalam status <strong>pending</strong> dan menunggu verifikasi admin.
        </p>

        <p class="text-sm text-gray-500 mb-8">
            Silakan cek kembali beberapa saat lagi. Jika terdapat kendala, hubungi pengelola kost.
        </p>

        <form method="POST" action="{{ route('logout.pending') }}">
            @csrf
            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-4 rounded-lg shadow transition-colors">
                Kembali ke Login Penghuni
            </button>
        </form>
    </div>
</body>
</html>
