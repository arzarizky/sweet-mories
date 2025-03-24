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
                    <span
                        class="ms-2 badge rounded-pill badge-bg
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
                            @if ($product->products->promo === 'true')
                                <li>
                                    {{ $product->products->name ?? 'Data Tidak Ada' }}
                                    {{ $product->products->type ?? 'Data Tidak Ada' }} :
                                    {{ $product->products->price_promo ?? 'Data Tidak Ada' }} x
                                    {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                                </li>
                            @else
                                <li>
                                    {{ $product->products->name ?? 'Data Tidak Ada' }}
                                    {{ $product->products->type ?? 'Data Tidak Ada' }} :
                                    {{ $product->products->price ?? 'Data Tidak Ada' }} x
                                    {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                                </li>
                            @endif
                        @endforeach

                        @foreach ($data->productAdditionalBookings as $additional)
                            <li>
                                {{ $additional->productsAdditional->name ?? 'Data Tidak Ada' }} :
                                {{ $additional->productsAdditional->price ?? 'Data Tidak Ada' }} x
                                {{ $additional->quantity_product ?? 'Data Tidak Ada' }}
                            </li>
                        @endforeach

                        @foreach ($data->productBackgroundBookings as $background)
                            <li>
                                Background : {{ $background->productsBackground->name ?? 'Data Tidak Ada' }}
                            </li>
                        @endforeach

                        @if ($data->promo != null)
                            <li>
                                Promo : {{ $data->promo->code }}
                            </li>
                        @endif
                    </ul>
                    <div class="countdown-container">
                        <p>Sisa Waktu Pembayaran: <b><span class="countdown-timer"
                                    data-expired-at="{{ $data->expired_at }}"></span></b></p>
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


@if (session()->has('sukses-pembayaran'))
    <div class="modal fade" id="sukses-pembayaran" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">

        @php
            $test = true;
            if ($test === false) {
                $routeBook = 'https://stg.sweetmoriesstudio.com/' . session('email') . '/booking/';
            } else {
                $routeBook = route('client-booking', session('email'));
            }
            $routePage = '&per_page=5&page=1';
            $routeBookSearch = '?search=';
            $urlBook = $routeBook . $routeBookSearch . session('booking_id');

            $bookingDate = new DateTime(session('date'));
            $bookingTime = new DateTime(session('time'));
        @endphp

        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div
                    style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15); overflow: hidden;">

                    <!-- Header -->
                    <div
                        style="background: linear-gradient(45deg, #6f42c1, #00aaff); padding: 50px 20px; text-align: center; color: #ffffff;">
                        <img src="https://sweetmoriesstudio.com/template/assets/img/favicon/black-logo.png"
                            alt="Sweet Mories" style="max-width: 120px; margin-bottom: 20px;">
                        <h1 style="margin: 0; font-size: 32px; font-weight: bold; letter-spacing: 1px;"
                            class="text-dark">Booking Berhasil!</h1>
                        <p style="margin-top: 10px; font-size: 16px;">Terima kasih telah mempercayakan momen indahmu
                            pada kami</p>
                    </div>

                    <!-- Content -->
                    <div style="padding: 30px 20px; color: #555555;">
                        <p style="margin: 5px 0 20px; font-size: 16px; line-height: 1.6;">Halo, Mories-mates!</p>
                        <p style="margin: 5px 0 20px; font-size: 16px; line-height: 1.6;">Terima kasih sudah
                            mempercayai
                            kami untuk
                            mengabadikan momen indahmu. Kami akan menginformasikan kembali terkait booking kamu
                            pada:
                        </p>

                        <div
                            style="background-color: #fafafa; border-radius: 10px; padding: 20px; border: 1px solid #e0e0e0; margin-bottom: 20px;">

                            <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Nama</h4>
                            <p style="margin-top: 5px; font-size: 16px; color: #666666;">{{ session('name') }}</p>

                            <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Email</h4>
                            <p style="margin-top: 5px; font-size: 16px; color: #666666;">{{ session('email') }}</p>

                            <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Hari</h4>
                            <p style="margin-top: 5px; font-size: 16px; color: #666666;">
                                {{ $bookingDate->format('l') }}</p>

                            <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Tanggal</h4>
                            <p style="margin-top: 5px; font-size: 16px; color: #666666;">
                                {{ $bookingDate->format('j F Y') }}</p>

                            <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Pukul</h4>
                            <p style="margin-top: 5px; font-size: 16px; color: #666666;">
                                {{ $bookingTime->format('H:i') }}</p>

                            <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Invoice ID
                            </h4>
                            <p style="margin-top: 5px; font-size: 16px; color: #666666;">
                                {{ session('invoice_id') }}</p>

                            <h4 style="margin: 0; font-size: 16px; font-weight: bold; color: #444444;">Booking ID
                            </h4>
                            <p style="margin-top: 5px; font-size: 16px; color: #666666;">
                                {{ session('booking_id') }}</p>
                        </div>

                        <p style="margin: 5px 0 20px; font-size: 16px; line-height: 1.6;" class="text-danger">Jangan lupa datang 15 menit lebih awalya!</p>

                        <p>
                            Waktu akan terpotong otomatis jika terjadi keterlambatan. Reschedule hanya dapat
                            dilakukan maksimal
                            3 jam sebelum sesi dimulai dengan cara konfirmasi ke Admin Mories.
                        </p>

                        <p style="margin: 5px 0 20px; font-size: 16px; line-height: 1.6;">Abadikan momen, ciptakan
                            cerita.<br>Di
                            studio kami, kenangan takkan terlupa.</p>

                        <!-- CTA Buttons -->
                        <div style="text-align: center; margin-top: 30px;">
                            <a href="{{ $urlBook }}"
                                style="display: inline-block; margin: 10px; padding: 12px 30px; font-size: 16px; color: #ffffff; background-color: #6f42c1; text-decoration: none; border-radius: 5px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15); transition: background-color 0.3s ease;">Cek
                                Booking</a>
                            <a href="https://maps.app.goo.gl/RRH9aiv2dGTi8XHG6?g_st=com.google.maps.preview.copy"
                                style="display: inline-block; margin: 10px; padding: 12px 30px; font-size: 16px; color: #ffffff; background-color: #00aaff; text-decoration: none; border-radius: 5px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15); transition: background-color 0.3s ease;">Lokasi
                                Kami</a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        style="background-color: #f4f4f4; padding: 20px; text-align: center; color: #777777; border-top: 1px solid #e0e0e0;">
                        <p style="font-size: 14px; color: #777777;">&copy; 2024 Sweet Mories. All rights reserved.
                        </p>
                        <p style="font-size: 14px; color: #777777;">
                            <a href="https://www.instagram.com/sweetmoriesstudio?igsh=ZnhpZ2g4bHYxM3M4"
                                style="color: #C13584; text-decoration: none; margin: 0 10px;">Instagram</a> |
                            <a href="https://www.facebook.com/share/898o1N7z5pfNo6Mm/?mibextid=LQQJ4d"
                                style="color: #1877F2; text-decoration: none; margin: 0 10px;">Facebook</a> |
                            <a href="https://www.tiktok.com/@sweetmories.studio?_t=8pPW86NyYeA&_r=1"
                                style="color: #69C9EF; text-decoration: none; margin: 0 10px;">TikTok</a>
                        </p>
                        <p style="font-size: 14px; color: #777777;">
                            <a href="https://sweetmoriesstudio.com"
                                style="color: #777777; text-decoration: none;">Website</a> |
                            <a href="https://api.whatsapp.com/send?phone=6285847747737"
                                style="color: #25D366; text-dezcoration: none;">Whatsapp</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@push('js-konten')
    @if (Session::has('sukses-pembayaran'))
        <script>
            const myModal = new bootstrap.Modal(document.getElementById('sukses-pembayaran'));
            myModal.show();
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElements = document.querySelectorAll('.countdown-timer');

            countdownElements.forEach(function(element) {
                const expiredAt = new Date(element.getAttribute('data-expired-at')).getTime();
                const cardElement = element.closest('.card'); // Get the closest card element
                const bgBadge = cardElement.querySelector('.badge-bg');
                const statusBadge = cardElement.querySelector(
                    '.status-badge'); // Get the status badge element
                const actionButtons = cardElement.querySelector(
                    '.action-buttons'); // Get the action buttons container
                const countdownContainer = cardElement.querySelector(
                    '.countdown-container'); // Get the countdown container

                const countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = expiredAt - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        element.innerHTML = "Expired";

                        // Only modify the card if the status is PENDING
                        if (statusBadge.textContent === "PENDING") {
                            cardElement.classList.remove('border-primary', 'border-warning',
                                'border-info', 'border-success', 'border-dark'
                            ); // Remove existing border classes
                            cardElement.classList.add('border-danger'); // Add expired border class
                            statusBadge.textContent = "EXP"; // Update status badge text
                            statusBadge.classList.remove('bg-primary', 'bg-warning', 'bg-info',
                                'bg-success', 'bg-dark'); // Remove existing badge classes
                            statusBadge.classList.add('bg-danger'); // Add expired badge class
                            bgBadge.classList.remove('bg-primary', 'bg-warning', 'bg-info',
                                'bg-success', 'bg-dark'); // Remove existing badge classes
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
