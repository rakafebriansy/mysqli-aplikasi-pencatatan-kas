<?php

namespace AplikasiKas\Model;

class KasRequest
{
    public ?int $id;
    public string $nama;
    public string $tanggal_pembayaran;
    public int $nominal;
}