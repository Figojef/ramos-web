<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PemesananController extends Controller
{
    protected $apiUrl = 'http://localhost:3000/api/v1/pemesanan';

    // Ambil semua pemesanan (GET)
    public function index()
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->post('pemesanan');

        return response()->json($response->json(), $response->status());
    }

public function store(Request $request)
{
    // Ambil user dan token dari session
    $user = Session::get('user_data');
    $jwt = Session::get('jwt');

    if (!$user || !$jwt) {
        return redirect()->route('login')->withErrors(['Silakan login terlebih dahulu.']);
    }

    // Validasi data dari form
    $validated = $request->validate([
        'jadwal_dipesan' => 'required|json',
        'total_harga' => 'required|numeric',
        'metode_pembayaran' => 'required|string',
        'status_pemesanan' => 'required|string',
    ]);

    // Decode jadwal_dipesan dari JSON
    $jadwal = json_decode($validated['jadwal_dipesan'], true);

    // Ambil hanya _id dari setiap slot
    $jadwal_ids = array_map(function ($item) {
        return $item['_id'];
    }, $jadwal);

    // Base URL backend Node.js
    $baseUrl = rtrim(env('API_BASE_URL'), '/');

    // Kirim request ke API Node.js untuk membuat pemesanan
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $jwt,
    ])->post($baseUrl . '/pemesanan', [
        'user_id' => $user['_id'],
        'jadwal_dipesan' => $jadwal_ids,
        'total_harga' => $validated['total_harga'],
        'metode_pembayaran' => $validated['metode_pembayaran'],
    ]);

    // Cek respon dari API Node.js
    if ($response->successful()) {
        // Ambil ID transaksi dan deadline dari response API
        $transactionId = $response->json()['data']['transaksi']['_id'];  // Ambil _id dari transaksi
        $deadlineUTC = $response->json()['data']['transaksi']['deadline_pembayaran'];  // Ambil waktu deadline dalam UTC

        // Konversi waktu deadline dari UTC ke waktu lokal
        $deadline = Carbon::parse($deadlineUTC)->setTimezone(config('app.timezone'));  // Sesuaikan dengan timezone aplikasi

        // Simpan transaksi, deadline, dan total_harga ke session (hanya untuk frontend yang membutuhkan)
        session([
            'transaction_id' => $transactionId,
            'payment_deadline' => $deadline->format('Y-m-d H:i:s'),  // Format sesuai kebutuhan
            'total_harga' => $validated['total_harga'],             // Total harga juga disimpan
        ]);

        return redirect()->route('detail.pembayaran')->with('success', 'Pemesanan dan transaksi berhasil dibuat!');
    } else {
        return back()->withErrors(['Gagal membuat pemesanan dan transaksi.']);
    }
}

    
public function showProfil()
{
    $token = session('jwt'); 

    if (!$token) {
        return back()->withErrors('Token tidak ditemukan. Pastikan kamu sudah login.');
    }

    $baseUrl = rtrim(env('API_BASE_URL', 'http://localhost:3000'), '/');

    $client = Http::withOptions([
        'base_uri' => $baseUrl,
    ])->withToken($token); // pakai bearer token lebih standar daripada withCookies buat JWT

    // Ambil yang masih berlangsung (menunggu & belum lewat deadline)
    $sedangResponse = $client->get('/v1/pemesanan/user/pesananBelumLewatDeadline');

    // Ambil riwayat yang sudah final (berhasil, dibatalkan, ditolak)
    $riwayatResponse = $client->get('/v1/pemesanan/user/riwayatPemesanan');

    if ($sedangResponse->successful() && $riwayatResponse->successful()) {
        $sedang = $sedangResponse->json('data');
        $riwayat = $riwayatResponse->json('data');

        return view('profil', compact('sedang', 'riwayat'));
    } else {
        return back()->withErrors('Gagal mengambil data pemesanan.');
    }
}
    // Fungsi untuk mengambil data pemesanan berdasarkan ID transaksi
    private function getPemesananData($transactionId)
    {
        // Ambil data transaksi dan pemesanan dari API atau database
        // Contoh mengambil dari API:
        $response = Http::get("url/api/transaksi/$transactionId");
        
        if ($response->successful()) {
            return $response->json()['data'];
        }
    
        return null;
    }
    
    
    // Ambil detail satu pemesanan (GET by ID)
    public function show($id)
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->get("$this->apiUrl/$id");

        return response()->json($response->json(), $response->status());
    }

    // Update pemesanan (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->put("$this->apiUrl/$id", $request->all());

        return response()->json($response->json(), $response->status());
    }

    // Hapus pemesanan (DELETE)
    public function destroy($id)
    {
        $token = Session::get('jwt'); // Ambil token JWT dari session

        $response = Http::withOptions([
            'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/'
        ])
        ->withCookies([
            'jwt' => $token // Kirim token melalui cookies
        ], env('DOMAIN'))
        ->delete("$this->apiUrl/$id");

        return response()->json($response->json(), $response->status());
    }

public function showDetailStatus(Request $request)
{
    $dataEncoded = $request->query('data');

    if (!$dataEncoded) {
        return redirect()->route('profil')->withErrors(['error' => 'Data tidak ditemukan.']);
    }

    $decodedData = json_decode(base64_decode($dataEncoded), true);

    if (!$decodedData) {
        return redirect()->route('profil')->withErrors(['error' => 'Data tidak valid.']);
    }

    return view('detail_status', ['data' => $decodedData]);
}

public function batalkan($id)
{
    $token = Session::get('jwt'); // Ambil token JWT dari session

    $response = Http::withOptions([
        'base_uri' => rtrim(env('API_BASE_URL'), '/') . '/',
    ])
    ->withCookies([
        'jwt' => $token // Kirim token sebagai cookie ke backend Express
    ], env('DOMAIN')) // Sesuaikan dengan domain backend
    ->patch("pemesanan/batalkan/{$id}");
    
    if ($response->failed()) {
        return redirect()->back()->withErrors([
            'error' => $response->json('message') ?? 'Gagal membatalkan pemesanan.'
        ]);
    }

    return redirect()->route('profil')->with('success', 'Pemesanan berhasil dibatalkan.');
}



}
