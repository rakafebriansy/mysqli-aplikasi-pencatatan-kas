<?php

namespace AplikasiKas\Services;
use AplikasiKas\Config\Database;
use AplikasiKas\Domain\Kas;
use AplikasiKas\Exception\ValidationException;
use AplikasiKas\Model\KasRequest;
use AplikasiKas\Model\KasResponse;
use AplikasiKas\Repository\KasRepository;

class KasService
{
    private KasRepository $kas_repository;

    public function __construct(KasRepository $kas_repository)
    {
        $this->kas_repository = $kas_repository;
    }
    public function tambah(KasRequest $request): KasResponse
    {
        $this->validateKas($request);
        try {
            Database::beginTransaction();
            $kas = new Kas();
            $kas->nama = $request->nama;
            $kas->tanggal_pembayaran = $request->tanggal_pembayaran;
            $kas->nominal = $request->nominal;

            $kas = $this->kas_repository->save($kas);

            $response = new KasResponse();
            $response->kas = $kas;
            Database::commitTransaction();

            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
    public function lihat(): array
    {
        try {
            Database::beginTransaction();
            $rows = $this->kas_repository->findAll();
            Database::commitTransaction();
            return $rows;
        } catch (\Exception $e){
            Database::rollbackTransaction();
            throw $e;
        }
    }
    public function hapus(int $id): void
    {
        try {
            Database::beginTransaction();
            $this->kas_repository->remove($id);
            Database::commitTransaction();
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
    public function ubah(KasRequest $request): KasResponse
    {
        $this->validateKas($request);
        try {
            Database::beginTransaction();
            $new_kas = new Kas();
            $new_kas->id = $request->id;
            $new_kas->nama = $request->nama;
            $new_kas->tanggal_pembayaran = $request->tanggal_pembayaran;
            $new_kas->nominal = $request->nominal;

            $this->kas_repository->update($new_kas);

            $response = new KasResponse();
            $response->kas = $new_kas;
            Database::commitTransaction();

            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
    public function jumlahPerBulan(): string
    {
        try {
            Database::beginTransaction();
            $raw = $this->kas_repository->sumPerMonth();
            $sum = $this->sumMap($raw);
            Database::commitTransaction();
            return json_encode($sum);
        } catch (\Exception $e){
            Database::rollbackTransaction();
            throw $e;
        }
    }
    private function validateKas(KasRequest $request): void
    {
        if ($request->nama == null || trim($request->nama) == '') {
            throw new ValidationException(('Nama tidak boleh kosong!'));
        }
        if ($request->tanggal_pembayaran == null || trim($request->tanggal_pembayaran) == '') {
            throw new ValidationException(('tanggal_pembayaran tidak boleh kosong!'));
        }
        if ($request->nominal == null || $request->nominal == 0) {
            throw new ValidationException(('Nominal tidak boleh nol!'));
        }
    }
    private function sumMap(array $raw): array
    {
        $sum = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach($raw as $item) {
            $index = (int)$item['bulan']-1;
            $sum[$index] = (int)$item['total'];
        }
        return $sum;
    }

}