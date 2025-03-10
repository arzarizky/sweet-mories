<div class="modal fade" id="addCloseOutlet" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('create-setting-outlet') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCloseOutletTitle">Menambahkan Jadwal Tutup Outlet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="outlet_name" class="form-label">Nama Event</label>
                            <input type="text" id="outlet_name" name="name" class="form-control"
                                placeholder="Contoh: Hari Raya" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="start_day" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="start_day" name="start_day" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">Waktu Mulai</label>
                            <input type="time" step="1" id="start_time" name="start_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label for="end_day" class="form-label">Tanggal Selesai</label>
                            <input type="date" id="end_day" name="end_day" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">Waktu Selesai</label>
                            <input type="time" step="1" id="end_time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Jadwal Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
