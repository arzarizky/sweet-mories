@foreach ($datas as $data)
    <div class="modal fade" id="editPromo-{{ $data->id }}" tabindex="-1" style="display: none;" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('promo-update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPromo-{{ $data->id }}Title">Merubah Promo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="nameWithTitle" class="form-label">Name</label>
                                <input type="text" id="nameWithTitle" name="name" class="form-control"
                                    placeholder="Promo Event Akhir Tahun" value="{{ $data->name }}" required>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="kodePromoWithTitle" class="form-label">Kode Promo</label>
                                <input type="text" id="kodePromoWithTitle" name="code"  value="{{ $data->code }}" class="form-control"
                                    placeholder="DARDER">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="discount_percentage" class="form-label">Discount Number</label>
                                <input type="number" id="discount_percentage" value="{{ $data->discount_value }}" name="discount_value"
                                    class="form-control" placeholder="10000">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                <input type="number" id="discount_percentage" value="{{ $data->discount_percentage }}" name="discount_percentage"
                                    class="form-control" placeholder="40">
                            </div>
                            <div class="col-12 mb-2">
                                <label for="usage_limit" class="form-label">Limit Penggunaan</label>
                                <input type="number" id="usage_limit" value="{{ $data->usage_limit }}" name="usage_limit" class="form-control"
                                    placeholder="100" required>
                            </div>
                        </div>
                        <div class="row g-6">
                            <div class="col mb-0">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" value="{{ $data->start_date }}" name="start_date"
                                    class="form-control" required>
                            </div>
                            <div class="col mb-0">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" value="{{ $data->end_date }}" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Promo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
