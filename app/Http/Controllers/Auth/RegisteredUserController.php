<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'daftar_sebagai' => ['required', 'in:pelanggan,mitra'],
            'area_layanan' => ['required_if:daftar_sebagai,mitra', 'nullable', 'string', 'max:255'],
            'keahlian' => ['required_if:daftar_sebagai,mitra', 'nullable', 'string', 'max:255'],
            'foto_ktp' => ['nullable', 'image', 'max:2048'],
        ]);

        $isMitra = $request->daftar_sebagai === 'mitra';

        $fotoPath = null;
        if ($isMitra && $request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->daftar_sebagai,
            'area_layanan' => $isMitra ? $request->area_layanan : null,
            'keahlian' => $isMitra ? $request->keahlian : null,
            'status_mitra' => $isMitra ? 'menunggu_verifikasi' : null,
            'foto_ktp' => $fotoPath,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($isMitra) {
            return redirect(route('mitra.menunggu', absolute: false));
        }

        return redirect(route('pesanan.katalog', absolute: false));
    }
}