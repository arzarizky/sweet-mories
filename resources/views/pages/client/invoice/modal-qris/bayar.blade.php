@if ($data->status === 'PAID')
    <div class="modal fade" id="bayar-{{ $data->id }}" tabindex="-1" aria-labelledby="bayar-{{ $data->id }}Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="p-4">
                    <h3 class="text-center">Qris {{ $data->invoice_id }}</h3>
                    <h3 class="text-center text-warning">Sudah Bayar</h3>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="modal fade" id="bayar-{{ $data->id }}" tabindex="-1"
        aria-labelledby="bayar-{{ $data->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="p-4">
                    <h3 class="text-center">Qris {{ $data->invoice_id }}</h3>
                    <div class="d-flex justify-content-center mb-3">
                        <img src="{{ $data->payment_link }}" height="50%" width="50%" alt="qris">
                    </div>
                    <h3 class="text-center text-warning">Total Price {{ $data->amount }}</h3>
                </div>
            </div>
        </div>
    </div>
@endif
