<x-guest-layout>
    <div class="text-center py-6">
        <div class="text-5xl mb-3">⏳</div>
        <h2 class="text-lg font-semibold mb-2">Akun Mitra Sedang Diverifikasi</h2>
        <p class="text-sm text-gray-600 mb-4">
            Terima kasih sudah mendaftar sebagai mitra FreshLiving Cleaning Services. Tim kami akan memeriksa datamu terlebih dahulu.
            Kamu akan bisa mulai menerima pesanan setelah akun disetujui Admin.
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm underline text-gray-600">Logout</button>
        </form>
    </div>
</x-guest-layout>