@extends('layouts.app', [
    'title' => 'Booking Preview ' . $users->name,
])

@section('konten')
    @php
        $now = \Carbon\Carbon::now(); // Get the current time using Carbon
        $currentTime = $now->hour * 60 + $now->minute; // Calculate current time in minutes
    @endphp

    <form action="{{ route('book.store') }}" method="POST" id="bookingForm">
        @csrf
        <div class="card p-4 shadow">
            <h2 class="text-center mb-4">
                @foreach ($productDisplay as $display)
                    <input type="hidden" name="id_product" value="{{ $display->products->id }}" id="id_product">
                    Booking {{ $display->products->name }} {{ $display->products->type }}
                    @if ($display->products->promo === 'true')
                        <small class="text-warning">{{ $display->products->sub_title_promo }}</small>
                    @endif
                    <input type="hidden" id="hidden-qty-{{ $display->products->id }}-main" name="main_product[quantity]"
                        value="1">
                    <input type="hidden" name="main_product[product_name]" value="{{ $display->products->id }}">
                @endforeach
            </h2>

            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="form-group mb-3">
                        <label for="alias_name_booking">Name</label>
                        <input type="text" name="alias_name_booking" placeholder="Masukkan Nama Lengkap Kamu"
                            class="form-control" autocomplete="off" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control"
                            autocomplete="off" required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="no_tlp">No Whatsapp</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input class="form-control" type="text" id="no_tlp-{{ $users->id }}" name="no_tlp"
                                value="{{ $users->no_tlp }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                placeholder="82244862271" autocomplete="off" required />
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5><strong>Terms And Conditions</strong></h5>
                        <div class="terms-list">
                            @foreach ($productDisplay as $display)
                                @if (!empty($display->products->tnc))
                                    <ol>
                                        @foreach (json_decode($display->products->tnc, true) as $term)
                                            <li>{{ $term ?? 'Tidak Ada Data' }}</li>
                                        @endforeach
                                    </ol>
                                @else
                                    <span>Tidak Ada Data</span>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5><strong>Additional Products</strong></h5>
                        <ul id="additional-products-list" class="list-group mb-3">
                            @foreach ($productDisplay as $display)
                                @foreach ($display->additionalProducts as $additional)
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center position-relative">
                                        <div class="d-flex">
                                            <img class="rounded me-2" src="{{ $additional->getPicProductAdditional() }}"
                                                alt="Card image" style="width: 60px; height: auto;">
                                            <div>
                                                <h6 class="mb-0">{{ $additional->name }}</h6>
                                                <small class="text-muted">{{ $additional->price_text }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger qty-minus"
                                                data-price="{{ $additional->price }}"
                                                data-target="{{ $additional->id }}">-</button>
                                            <span id="qty-{{ $additional->id }}" class="mx-2">0</span>
                                            <button type="button" class="btn btn-sm btn-outline-success qty-plus"
                                                data-price="{{ $additional->price }}"
                                                data-target="{{ $additional->id }}">+</button>
                                        </div>
                                    </li>
                                    <input type="hidden" id="hidden-qty-{{ $additional->id }}"
                                        name="additional_products[{{ $loop->index }}][quantity]" value="0">
                                    <input type="hidden" name="additional_products[{{ $loop->index }}][product_name]"
                                        value="{{ $additional->name }}">
                                @endforeach
                            @endforeach
                        </ul>
                    </div>

                    @if ($display->product_background === 'Color')
                        <div class="mb-3">
                            <h5><strong>Background</strong></h5>
                            <ul id="background-products-list" class="list-group mb-3">
                                @foreach ($productDisplay as $display)
                                    @foreach ($display->backgroundsProducts as $background)
                                        <li
                                            class="list-group-item d-flex justify-content-start align-items-center position-relative">
                                            <div class="d-flex">
                                                <img class="rounded me-2"
                                                    src="{{ $background->getPicProductBackground() }}" alt="Card image"
                                                    style="width: 60px; height: auto;">
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="background"
                                                    value="{{ $background->name }}" id="background-{{ $background->id }}"
                                                    required>
                                                <label class="form-check-label" for="background-{{ $background->id }}">
                                                    {{ $background->name }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($productDisplay->first()->products->promo === 'false')
                        <div class="form-group mb-3">
                            <label for="kode_promo">Kode Promo</label>
                            <input type="text" id="kode_promo" name="kode_promo" placeholder="Masukkan Promo Kamu"
                                class="form-control" autocomplete="off" style="text-transform: uppercase;"
                                onblur="this.value = this.value.toUpperCase();">
                        </div>
                        <button type="button" class="btn btn-primary w-100 mb-3 promo-check">Gunakan
                            Promo</button>
                    @endif


                    <h3>Total Price: <span id="total-price">
                            @php
                                // Menentukan harga dasar berdasarkan status promo
                                $basePrice =
                                    $productDisplay->first()->products->promo === 'true'
                                        ? $productDisplay->first()->products->price_promo // Gunakan harga promo jika tersedia
                                        : $productDisplay->first()->products->price; // Jika tidak, gunakan harga reguler

                                // Format harga dasar
                                $formattedPrice =
                                    $basePrice >= 1000
                                        ? floor($basePrice / 1000) . 'K'
                                        : number_format($basePrice, 0, ',', '.');
                            @endphp
                            {{ $formattedPrice }}
                        </span>
                    </h3>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div id="booking-preview" class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="booking_date">Select Date:</label>
                                <input type="text" id="booking_date" name="booking_date" class="form-control"
                                    autocomplete="off" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="booking_time">Select Time:</label>
                                <div id="time-slots" class="d-flex flex-wrap mb-2">
                                    <!-- Time slots will be loaded here -->
                                </div>
                                <input type="hidden" id="booking_time" name="booking_time">
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitButton">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('js-konten')
        <script>
            $(document).ready(function() {

                $("#bookingForm").submit(function() {
                    $("#submitButton").prop("disabled", true);
                    $("#submitButton").text("Loading...");
                });

                let basePrice = parseFloat('{{ $basePrice }}'); // Use base price with promo consideration
                let totalPrice = basePrice;
                let discount = 0; // Initialize discount variable

                function updateTotalPrice() {
                    let additionalTotal = 0;
                    $('#additional-products-list .qty-minus').each(function() {
                        let qty = parseInt($('#qty-' + $(this).data('target')).text());
                        let price = parseFloat($(this).data('price'));
                        additionalTotal += qty * price;
                    });

                    // Calculate total price considering the discount
                    totalPrice = basePrice - discount + additionalTotal;

                    // Convert to "K" format without decimal points
                    let formattedPrice = totalPrice >= 1000 ? Math.floor(totalPrice / 1000) + 'K' : totalPrice
                        .toLocaleString('id-ID');
                    $('#total-price').text(formattedPrice); // Ensure currency format
                }

                function updateHiddenInputs(target, qty) {
                    $('#hidden-qty-' + target).val(qty); // Update the hidden input with quantity
                }

                $('.qty-minus').click(function() {
                    let target = $(this).data('target');
                    let currentQty = parseInt($('#qty-' + target).text());
                    if (currentQty > 0) {
                        $('#qty-' + target).text(currentQty - 1);
                        updateHiddenInputs(target, currentQty - 1);
                        updateTotalPrice();
                    }
                });

                $('.qty-plus').click(function() {
                    let target = $(this).data('target');
                    let currentQty = parseInt($('#qty-' + target).text());
                    $('#qty-' + target).text(currentQty + 1);
                    updateHiddenInputs(target, currentQty + 1);
                    updateTotalPrice();
                });

                // Function to apply the promo discount
                function applyPromoDiscount(discountValue) {
                    discount = discountValue; // Set the discount from promo
                    updateTotalPrice(); // Update the total price with the new discount
                }

                // Variabel untuk menyimpan status penggunaan promo
                let isPromoUsed = false;

                // Function to check promo and apply discount
                $('.promo-check').click(function() {

                    const promoCode = document.getElementById('kode_promo').value;

                    if (!promoCode) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Silakan masukkan kode promo',
                            position: 'topRight',
                        });
                        return;
                    }

                    // Cek apakah promo sudah digunakan
                    if (isPromoUsed) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Hanya Dapat Menggunakan 1 Kode Promo',
                            position: 'topRight',
                        });
                        return;
                    }

                    // Make a POST request to check the promo code
                    fetch(`/promo/check/${promoCode}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.valid) {

                                // Set status promo digunakan
                                isPromoUsed = true;

                                if (data.model === "PERCENTAGE") {
                                    const discountAmount = (basePrice * data.discount) / 100;
                                    applyPromoDiscount(discountAmount);
                                    iziToast.success({
                                        title: 'Promo berhasil digunakan!',
                                        message: `Diskon ${data.discount}%`,
                                        position: 'topRight',
                                    });
                                } else {
                                    applyPromoDiscount(data.discount);
                                    iziToast.success({
                                        title: 'Promo berhasil digunakan!',
                                        message: `Diskon Rp. ${data.discount}`,
                                        position: 'topRight',
                                    });
                                }
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Kode promo tidak valid atau sudah digunakan.',
                                    position: 'topRight',
                                });
                            }
                        })
                        .catch(error => {
                            iziToast.error({
                                title: 'Error',
                                message: error,
                                position: 'topRight',
                            });
                        });
                });

                // Datepicker configuration
                $('#booking_date').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '0d',
                    autoclose: true,
                    todayHighlight: true,
                }).on('changeDate', function(e) {
                    checkDate(e.format());
                });

                function checkDate(date) {
                    $.ajax({
                        url: '{{ route('book.checkDate') }}',
                        type: 'GET',
                        data: {
                            date: date
                        },
                        success: function(response) {
                            if (response.allBooked) {
                                iziToast.info({
                                    title: 'Info',
                                    message: 'All time slots for this date are booked. Please select another date.',
                                    position: 'topCenter',
                                });

                                $('#time-slots').html(
                                    '<div class="card bg-warning text-white p-3">All time slots for this date are booked. Please select another date.</div>'
                                );
                            } else {
                                loadTimeSlots(date);
                            }
                        }
                    });
                }

                function loadTimeSlots(selectedDate) {
                    $('#time-slots').empty();

                    $.ajax({
                        url: '{{ route('book.checkTime') }}',
                        type: 'GET',
                        data: {
                            date: selectedDate
                        },
                        success: function(response) {
                            if (response.closed) {
                                iziToast.info({
                                    title: 'Info',
                                    message: 'Booking untuk tanggal ini sedang ditutup',
                                    position: 'topCenter',
                                });

                                $('#time-slots').html(
                                    '<div class="card bg-warning text-white p-3">Booking untuk tanggal ini sedang ditutup</div>'
                                );

                            } else {

                                const bookedTimes = response.bookedTimes;
                                const start = 9 * 60; // 09:00
                                const end = 21 * 60; // 21:00

                                const selectedDateTime = new Date(selectedDate);
                                const currentDateTime = new Date();

                                for (let time = start; time <= end; time += 20) {
                                    const hour = Math.floor(time / 60);
                                    const minute = time % 60;
                                    const timeString = hour.toString().padStart(2, '0') + ':' + minute
                                        .toString().padStart(2, '0');

                                    const isBooked = bookedTimes.includes(timeString);
                                    const isCurrent = selectedDateTime.setHours(hour, minute, 0, 0) <=
                                        currentDateTime;

                                    // Add different styles for available and booked time slots
                                    if (isBooked || isCurrent) {
                                        $('#time-slots').append(`
                                            <button type="button" class="btn btn-outline-danger m-1 time-slot" disabled>
                                                ${timeString}
                                            </button>
                                        `);
                                    } else {
                                        $('#time-slots').append(`
                                            <button type="button" class="btn btn-outline-success m-1 time-slot" data-time="${timeString}">
                                                ${timeString}
                                            </button>
                                        `);
                                    }
                                }

                                // Click handler for available time slots
                                $('.time-slot').click(function() {
                                    $('#booking_time').val($(this).data('time'));
                                    $('.time-slot').removeClass('btn-success').addClass(
                                        'btn-outline-success');
                                    $(this).removeClass('btn-outline-success').addClass('btn-success');
                                });

                            }
                        }
                    });
                }

            });
        </script>
    @endpush
@endsection
