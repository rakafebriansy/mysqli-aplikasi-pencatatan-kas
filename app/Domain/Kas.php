<?php

namespace AplikasiKas\Domain;

class Kas
{
    public ?int $id;
    public string $nama;
    public string $tanggal_pembayaran;
    public int $nominal;
}