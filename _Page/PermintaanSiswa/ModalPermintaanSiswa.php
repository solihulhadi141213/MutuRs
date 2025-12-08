<div class="modal fade" id="ModalTambah" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah">
                <div class="modal-header">
                    <h5 class="modal-title text-dak"><i class="bi bi-plus"></i> Tambah Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_siswa" value="<?php echo $SessionIdAccess; ?>">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="tanggal_permintaan">
                                <small>Tanggal</small>
                            </label>
                            <input type="date" name="tanggal_permintaan" id="tanggal_permintaan" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jam_permintaan">
                                <small>Jam</small>
                            </label>
                            <input type="time" name="jam_permintaan" id="jam_permintaan" class="form-control" value="<?php echo date('H:i'); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="kategori">
                                <small>Kategori Permintaan</small>
                            </label>
                            <select id="kategori" name="kategori" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Pembelian">Pembelian</option>
                                <option value="Pemeliharaan Rutin">Pemeliharaan Rutin</option>
                                <option value="Perbaikan">Perbaikan</option>
                                <option value="Isi Ulang">Isi Ulang</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="kebutuhan">
                                <small>Kategori Kebutuhan</small>
                            </label>
                            <select id="kebutuhan" name="kebutuhan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Segera">Segera</option>
                                <option value="Penting">Penting</option>
                                <option value="Biasa">Biasa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="keterangan_permintaan">
                                <small>Keterangan Permintaan</small>
                            </label>
                            <textarea class="form-control" name="keterangan_permintaan" id="keterangan_permintaan" required></textarea>
                            <small>
                                <small>Diisi dengan nama barang dan penjelasan yang perlu dilakukan</small>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="NotifikasiTambah">
                            <!-- Notifikasi Tambah Permintaan Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDetail" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormDetail">
                            <!-- Detail Permintaan Akan di tampilkan disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-rounded">
                        Lihat Selengkapnya <i class="bi bi-chevron-right"></i>
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDetailFoto" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-image"></i> Detail Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12" id="FormDetailFoto">
                        <!-- Form Update Status -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEdit" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="FormEdit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalHapus" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-trash"></i> Hapus Permintaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapus">
                            <!-- Form Hapus Disini -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapus">
                            <!-- Notifikasi Hapus -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Ya, Hapus
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>