<?php
// perbedaan helpers dan libraries
// helpers : bikin API, method/func nya cmn ada 1
// libraries : pake API, method/func nya lebih dari 1
namespace App\Http\Libraries;
// mengatur posisi file : namespace
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Cast\String_;

class BaseApi
{
    // variable yg cuman bisa di akses di class ini dan turunannya
    protected $baseUrl;
    // constractor : menyiapkan isi data, dijalankan otomatis tanpa dipanggil
    public function __construct()
	{
        // var $baseUrl yg diatas diisi nilainya dari isian file .env bagian API_HOST
        // var ini diisi otomatis ketika file/class BaseApi dipanggil di controller
        $this->baseUrl = env('API_HOST');
    }
    private function client()
    {
        // koneksikan ip dari var $baseUrl ke depedency Http
        // menggunakan depedency Http karna project API nya berbasis web (protocol Http)
        return Http::baseUrl($this->baseUrl);
    }
    public function index(String $endpoint, Array $data = [])
    {
        // manggil ke func client yg diatas, trs manggil path yang dari $endpoint yg dikirim controllernya, kalau ada data yg mau di cari (params di postman) diambil dari parameter2 $data
        return $this->client()->get($endpoint, $data);
    }

    private function token()
    {
        $proses = $this->client()->get('/generate-token');
        return $proses->json();
    }

    public function store(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di project REST API nya pake ::post
        return $this->client()->post($endpoint, $data);
    }

    public function edit(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }

    public function update(String $endpoint, Array $data = [])
    {
        return $this->client()->patch($endpoint, $data);
    }

    public function delete(String $endpoint, Array $data = [])
    {
        return $this->client()->delete($endpoint, $data);
    }
}