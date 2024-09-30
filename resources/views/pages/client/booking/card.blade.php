<div class="row ps-3 pe-3">
    @forelse ($datas as $data)
        <div class="col-md-6 col-lg-4 mb-3">
            <div
                class="card border
                    @if ($data->status === 'PENDING') border-primary
                    @elseif ($data->status === 'ON PROCESS')
                        border-warning
                    @elseif ($data->status === 'PAYMENT PROCESS')
                        border-info
                    @elseif ($data->status === 'EXP')
                        border-danger
                    @elseif ($data->status == 'DONE')
                        border-success
                    @else
                        border-dark @endif mb-3">
                <div class="card-header">
                    {{ $data->booking_date }} | {{ $data->booking_time }}
                    <span class="ms-2 badge rounded-pill badge-bg
                        @if ($data->status === 'PENDING') bg-primary
                        @elseif ($data->status === 'ON PROCESS') bg-warning
                        @elseif ($data->status === 'PAYMENT PROCESS') bg-info
                        @elseif ($data->status === 'EXP') bg-danger
                        @elseif ($data->status == 'DONE') bg-success
                        @else bg-dark @endif">
                        <span class="status-badge">{{ $data->status }}</span>
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data->book_id ?? 'Data Tidak Ada' }}</h5>
                    <p class="card-text">
                    <ul class="pt-2">
                        @foreach ($data->productBookings as $product)
                            <li>
                                {{ $product->products->name ?? 'Data Tidak Ada' }} :
                                {{ $product->products->price ?? 'Data Tidak Ada' }} x
                                {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="countdown-container">
                        <p>Sisa Waktu Pembayaran: <b><span class="countdown-timer" data-expired-at="{{ $data->expired_at }}"></span></b></p>
                    </div>
                    <h5 class="card-title">Total Price : {{ $data->total_price }}</h5>
                    </p>
                    <div class="action-buttons">
                        @if ($data->status === 'EXP')
                            <button type="button" class="btn btn-danger" disabled>
                                Booking EXP Tidak Bisa Melakukan Pembayaran
                            </button>
                        @else
                            <form method="post" action="{{ route('payment', ['email' => $users->email]) }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $data->book_id }}">
                                @if ($data->invoice != null)
                                    <a href="{{ $data->invoice->payment_link }}" class="btn btn-warning">
                                        Cek Pembayaran
                                    </a>
                                @else
                                    <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                                @endif
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-danger text-center">
            <div class="card">
                @if (request()->input('search') === null)
                    <h5 class="mt-5 mb-5">{{ $users->name }} Belum Pernah Booking 😢</h5>
                @else
                    <h5 class="mt-5 mb-5">Pesanan {{ $users->name }} dengan {{ request()->input('search') }} tidak
                        ada</h5>
                @endif
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-between" style="align-self: center;">
    <div class="ps-2" style="margin-top: 25px;" class="data-count">
        Menampilkan {{ $datas->count() }} data dari {{ $datas->total() }}
    </div>

    <div>
        {{ $datas->links('layouts.pagination') }}
    </div>
</div>

@push('js-konten')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElements = document.querySelectorAll('.countdown-timer');

            countdownElements.forEach(function(element) {
                const expiredAt = new Date(element.getAttribute('data-expired-at')).getTime();
                const cardElement = element.closest('.card');  // Get the closest card element
                const bgBadge = cardElement.querySelector('.badge-bg');
                const statusBadge = cardElement.querySelector('.status-badge');  // Get the status badge element
                const actionButtons = cardElement.querySelector('.action-buttons');  // Get the action buttons container
                const countdownContainer = cardElement.querySelector('.countdown-container'); // Get the countdown container

                const countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = expiredAt - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        element.innerHTML = "Expired";

                        // Only modify the card if the status is PENDING
                        if (statusBadge.textContent === "PENDING") {
                            cardElement.classList.remove('border-primary', 'border-warning', 'border-info', 'border-success', 'border-dark'); // Remove existing border classes
                            cardElement.classList.add('border-danger'); // Add expired border class
                            statusBadge.textContent = "EXP"; // Update status badge text
                            statusBadge.classList.remove('bg-primary', 'bg-warning', 'bg-info', 'bg-success', 'bg-dark'); // Remove existing badge classes
                            statusBadge.classList.add('bg-danger'); // Add expired badge class
                            bgBadge.classList.remove('bg-primary', 'bg-warning', 'bg-info', 'bg-success', 'bg-dark'); // Remove existing badge classes
                            bgBadge.classList.add('bg-danger');


                            // Update action buttons for expired status
                            actionButtons.innerHTML = `
                                <button type="button" class="btn btn-danger" disabled>
                                    Booking EXP Tidak Bisa Melakukan Pembayaran
                                </button>
                            `;
                        } else {
                            // If status is not PENDING or EXP, hide the countdown container
                            countdownContainer.style.display = 'none'; // Hide the countdown display
                        }
                    } else {
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        element.innerHTML = minutes + "m " + seconds + "s ";
                    }
                }, 1000);
            });
        });
    </script>
@endpush
