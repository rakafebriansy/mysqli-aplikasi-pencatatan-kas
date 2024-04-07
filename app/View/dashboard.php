<div class="border-bottom">
  <h1 class="text-center m-2"> APLIKASI PENCATATAN KAS</h1>
</div>

<div class="container d-flex flex-column align-items-center mt-3 mb-5">
    <?php if(isset($_GET['error'])): ?>
      <div class="alert alert-danger" role="alert" style="min-width: 75%; margin-bottom: 2rem;">
        <?= $_GET['error'];?>
      </div>
    <?php elseif (isset($_GET['success'])): ?>
      <div class="alert alert-primary" role="alert" style="min-width: 75%; margin-bottom: 2rem;">
        <?= $_GET['success'];?>
      </div>
    <?php endif; ?>
    <div class="d-block w-75">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah kas</button>
    </div>
    <table class="table table-hover w-75">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama</th>
          <th scope="col">Tanggal Pembayaran</th>
          <th scope="col">Nominal</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
          <?php if(count($data['kas']) > 0): ?>
            <?php foreach($data['kas'] as $index=>$row): ?>
              <tr>
                <th scope="row"><?= $index+=1;?></th>
                <td><?= htmlspecialchars($row['nama']);?></td>
                <td>
                  <?= date_format(date_create(htmlspecialchars($row['tanggal_pembayaran'])), 'd/m/Y')?>
                </td>
                <td>Rp<?= htmlspecialchars($row['nominal']);?></td>
                <td>
                  <span role="button" class="badge text-bg-warning" data-bs-toggle="modal" data-bs-target="#ubahModal" data-id="<?= $row['id'] ?>" data-nama="<?= htmlspecialchars($row['nama']) ?>" data-tanggal="<?= htmlspecialchars($row['tanggal_pembayaran']) ?>" data-nominal="<?= htmlspecialchars($row['nominal']) ?>">Ubah</span>
                  <span role="button" class="badge text-bg-danger" data-bs-toggle="modal" data-bs-target="#hapusModal" data-id="<?= $row['id'] ?>">Hapus</span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <td colspan="100%">
              <h4 style="text-align: center; margin: 0.5rem 0 0.5rem 0;">Data tidak tersedia.</h4>
            </td>
          <?php endif; ?>
        </tbody>
      </table>
      <div id="cekTahun" class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Tahun
        </button>
        <ul class="dropdown-menu">
          <?php  foreach (json_decode($data['jumlahPerBulan']) as $tahun => $value): ?>
            <li><a class="dropdown-item" href="#cekTahun" data-tahun="<?= $tahun;?>"><?= $tahun;?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
      <div class="w-75 mt-2">
        <canvas id="myChart"></canvas>
      </div>
</div>


<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah data kas</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/tambah" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" aria-describedby="namaHelp">
            <div id="namaHelp" class="form-text">Nama harus berupa nama lengkap.</div>
          </div>
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal">
          </div>
          <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Rp</span>
              <input type="text" class="form-control" name="nominal" id="nominal" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="hapusModalLabel">Hapus data kas</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/hapus" method="post">
        <div class="modal-body">
          <p>Data yang telah dihapus tidak dapat dipulihkan. Apakah anda yakin?</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ubahModalLabel">Ubah data kas</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/ubah" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" aria-describedby="namaHelp">
            <div id="namaHelp" class="form-text">Nama harus berupa nama lengkap.</div>
          </div>
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal">
          </div>
          <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Rp</span>
              <input type="text" class="form-control" name="nominal" id="nominal" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id">
          <button type="submit" class="btn btn-warning">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>
