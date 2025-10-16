<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Request;

class AuthController extends Controller
{
    protected array $credentials;

    public function __construct(Request $request, Database $database)
    {
        parent::__construct($request, $database);
        $this->credentials = (array) config('auth.credentials', []);
    }

    public function login(): mixed
    {
        if (session()->get('auth')) {
            return redirect('/backend/');
        }

        return view('auth/login', [
            'title' => 'Masuk',
            'formAction' => '/auth/process',
            'errors' => [],
            'credentials' => [
                'email' => session()->old('email', ''),
            ],
        ], 'layouts.auth');
    }

    public function process(): mixed
    {
        $input = [
            'email' => strtolower(trim((string) $this->request->input('email', ''))),
            'password' => (string) $this->request->input('password', ''),
        ];

        session()->setOldInput(['email' => $input['email']]);

        $errors = $this->validate($input);

        if (!empty($errors)) {
            session()->flash('error', implode(' ', $errors));
            return redirect('/auth/login');
        }

        session()->forget('auth');
        session()->set('auth', [
            'email' => $this->credentials['email'] ?? $input['email'],
            'name' => $this->credentials['name'] ?? 'Administrator',
        ]);
        session()->set('nama_pengguna', $this->credentials['name'] ?? 'Administrator');
        session()->flash('success', 'Anda berhasil masuk.');
        session()->setOldInput([]);

        return redirect('/');
    }

    public function logout(): mixed
    {
        session()->forget('auth');
        session()->forget('nama_pengguna');
        session()->flash('success', 'Anda telah keluar.');

        return redirect('/auth/login');
    }

    protected function validate(array $input): array
    {
        $errors = [];
        $configuredEmail = strtolower((string) ($this->credentials['email'] ?? ''));
        $configuredPassword = (string) ($this->credentials['password'] ?? '');
        $configuredHash = (string) ($this->credentials['password_hash'] ?? '');

        if ($input['email'] === '') {
            $errors[] = 'Email wajib diisi.';
        }

        if ($input['password'] === '') {
            $errors[] = 'Kata sandi wajib diisi.';
        }

        if (!empty($errors)) {
            return $errors;
        }

        if ($configuredEmail === '' || ($configuredPassword === '' && $configuredHash === '')) {
            $errors[] = 'Kredensial admin belum dikonfigurasi.';
            return $errors;
        }

        if ($input['email'] !== $configuredEmail) {
            $errors[] = 'Email atau kata sandi salah.';
            return $errors;
        }

        $passwordValid = false;

        if ($configuredHash !== '') {
            $passwordValid = password_verify($input['password'], $configuredHash);
        }

        if (!$passwordValid && $configuredPassword !== '') {
            $passwordValid = hash_equals($configuredPassword, $input['password']);
        }

        if (!$passwordValid) {
            $errors[] = 'Email atau kata sandi salah.';
        }

        return $errors;
    }
}
