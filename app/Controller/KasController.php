<?php

namespace AplikasiKas\Controller;
use AplikasiKas\Config\Database;
use AplikasiKas\Core\View;
use AplikasiKas\Exception\ValidationException;
use AplikasiKas\Model\KasRequest;
use AplikasiKas\Repository\KasRepository;
use AplikasiKas\Services\KasService;

class KasController
{
    private KasService $kas_service;
    public function __construct() 
    {
        $conn = Database::getConnection();
        $kas_repository = new KasRepository($conn);
        $this->kas_service = new KasService($kas_repository);
    }
    public function index()
    {
        $rows = $this->kas_service->lihat();
        $sum_per_month = $this->kas_service->jumlahPerBulan();
        View::setView('dashboard', [
            'title' => 'Dashboard',
            'kas' => $rows,
            'jumlahPerBulan' => $sum_per_month
        ]);
    }
    public function tambahKas()
    {
        $request = new KasRequest();
        $request->nama = $_POST['nama'];
        $request->tanggal_pembayaran = $_POST['tanggal'];
        $request->nominal = (int)$_POST['nominal'];
        
        try {
            $this->kas_service->tambah($request);
            $message = 'Data berhasil ditambah.';
            View::redirectMsg('/',$message,false);
        } catch (ValidationException $e) {
            View::redirectMsg('/',$e->getMessage(),true);
        }
    }
    public function hapusKas()
    {
        $id = (int)$_POST['id'];
        try {
            $this->kas_service->hapus($id);
            $message = 'Data telah berhasil dihapus.';
            View::redirectMsg('/', $message, false);
        } catch (\Exception $e) {
            View::redirectMsg('/',$e->getMessage(), true);
        }
    }
    public function ubahKas()
    {
        $request = new KasRequest();
        $request->id = $_POST['id'];
        $request->nama = $_POST['nama'];
        $request->tanggal_pembayaran = $_POST['tanggal'];
        $request->nominal = (int)$_POST['nominal'];

        try {
            $this->kas_service->ubah($request);
            $message = 'Data berhasil diperbarui.';
            View::redirectMsg('/', $message, false);
        } catch (ValidationException $e) {
            View::redirectMsg('/',$e->getMessage(), true);
        }
    }
    public function test()
    {
        $sum_per_month = json_encode($this->kas_service->jumlahPerBulan());
        
        var_dump($sum_per_month);
    }
}
