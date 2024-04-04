<?php
use AplikasiKas\Controller\KasController;
use AplikasiKas\Core\Router;

require_once 'app/init.php';

Router::add('GET','/',KasController::class,'index');
Router::add('POST','/tambah',KasController::class,'tambahKas');
Router::add('POST','/hapus',KasController::class,'hapusKas');
Router::add('POST','/ubah',KasController::class,'ubahKas');
Router::add('GET','/test',KasController::class,'test');

Router::run();