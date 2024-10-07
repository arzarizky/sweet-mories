@extends('layouts.app', [
    'title' => 'Booking Preview ' . $users->name,
])

@section('konten')
    @php
        $now = \Carbon\Carbon::now(); // Mengambil waktu saat ini menggunakan Carbon
        $currentTime = $now->hour * 60 + $now->minute; // Menghitung waktu sekarang dalam menit
    @endphp

    <form action="{{ route('book.store') }}" method="POST">
        @csrf
        <div class="card p-4">
            <div class="row">
                <h2>
                    Booking

                    @if (request()->input('package') === 'Basic-tnc')
                        Basic Self Photoshoot S&K
                    @elseif (request()->input('package') === 'Projector-tnc')
                        Projector Self Photoshoot S&K
                    @elseif (request()->input('package') === 'Basic')
                        Basic Self Photoshoot
                    @elseif (request()->input('package') === 'Projector')
                        Projector Self Photoshoot
                    @else
                        Tidak Teridentifikasi
                    @endif

                </h2>

                <div class="col-lg-8 col-sm-12">
                    <div class="form-group mb-3">
                        <label for="booking_date">Name</label>
                        <input type="text" name="alias_name_booking" placeholder="Masukan Nama Lengkap Kamu" class="form-control"
                            autocomplete="off" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">Email</label>
                        <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control"
                            autocomplete="off" required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">No Whatsapp</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input class="form-control" type="text" id="no_tlp-{{ $users->id }}" name="no_tlp"
                                value="{{ $users->no_tlp }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                placeholder="82244862271" autocomplete="off" required />
                        </div>
                    </div>

                    <div class="mb-1">
                        @if (request()->input('package') === 'Basic-tnc')
                            Basic Self Photoshoot T&C
                        @elseif (request()->input('package') === 'Projector-tnc')
                            Projector Self Photoshoot T&C
                        @elseif (request()->input('package') === 'Basic')
                            Basic Self Photoshoot
                        @elseif (request()->input('package') === 'Projector')
                            Projector Self Photoshoot
                        @else
                            Tidak Teridentifikasi
                        @endif
                    </div>

                    @if (request()->input('package') === 'Basic-tnc')
                        <ul>
                            <li>
                                <h5>TANPA BATASAN ORANG</h5>
                            </li>
                            <li>
                                <h5>15 MENIT FOTO</h5>
                            </li>
                            <li>
                                <h5>5 MENIT PEMILIHAN FOTO</h5>
                            </li>
                            <li>
                                <h5>BEBAS MEMILIH SEMUA WARNA BACKGROUND</h5>
                            </li>
                            <li>
                                <h5>BEBAS MENGGUNAKAN SEMUA KOSTUM DAN PROPERTI</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN SEMUA ALL SOFT FILE RAW & EDITED</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN 1 CETAK 4R</h5>
                            </li>
                        </ul>
                        <div class="mb-2">
                            Syarat & Ketentuan : Tag IGS, Follow IG dan Tik Tok @Sweetmoriesstudio & Review Google Maps.
                        </div>
                    @elseif (request()->input('package') === 'Projector-tnc')
                        <ul>
                            <li>
                                <h5>TANPA BATASAN ORANG</h5>
                            </li>
                            <li>
                                <h5>15 MENIT FOTO</h5>
                            </li>
                            <li>
                                <h5>5 MENIT PEMILIHAN FOTO</h5>
                            </li>
                            <li>
                                <h5>BEBAS MENGGANTI SEMUA BACKGROUND PROYEKTOR SELAMA SESI FOTO BERLANGSUNG</h5>
                            </li>
                            <li>
                                <h5>BEBAS MENGGUNAKAN SEMUA KOSTUM DAN PROPERTI</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN SEMUA ALL SOFT FILE RAW & EDITED</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN 1 CETAK 4R</h5>
                            </li>
                        </ul>
                        <div class="mb-2">
                            Syarat & Ketentuan : Tag IGS, Follow IG dan Tik Tok @Sweetmoriesstudio & Review Google Maps.
                        </div>
                    @elseif (request()->input('package') === 'Basic')
                        <ul>
                            <li>
                                <h5>TANPA BATASAN ORANG</h5>
                            </li>
                            <li>
                                <h5>15 MENIT FOTO</h5>
                            </li>
                            <li>
                                <h5>5 MENIT PEMILIHAN FOTO</h5>
                            </li>
                            <li>
                                <h5>BEBAS MEMILIH SEMUA WARNA BACKGROUND</h5>
                            </li>
                            <li>
                                <h5>BEBAS MENGGUNAKAN SEMUA KOSTUM DAN PROPERTI</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN SEMUA ALL SOFT FILE RAW & EDITED</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN 1 CETAK 4R</h5>
                            </li>
                        </ul>
                    @elseif (request()->input('package') === 'Projector')
                        <ul>
                            <li>
                                <h5>TANPA BATASAN ORANG</h5>
                            </li>
                            <li>
                                <h5>15 MENIT FOTO</h5>
                            </li>
                            <li>
                                <h5>5 MENIT PEMILIHAN FOTO</h5>
                            </li>
                            <li>
                                <h5>BEBAS MENGGANTI SEMUA BACKGROUND PROYEKTOR SELAMA SESI FOTO BERLANGSUNG</h5>
                            </li>
                            <li>
                                <h5>BEBAS MENGGUNAKAN SEMUA KOSTUM DAN PROPERTI</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN SEMUA ALL SOFT FILE RAW & EDITED</h5>
                            </li>
                            <li>
                                <h5>DAPATKAN 1 CETAK 4R</h5>
                            </li>
                        </ul>
                    @else
                        Tidak Teridentifikasi
                    @endif

                    <div class="mb-1">Additional Print</div>

                    <ul>
                        <li class="mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>1 Printed Photo 4R : 10K</span>
                                <span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary qty-minus"
                                        data-price="10" data-target="photo4r">-</button>
                                    <span id="qty-photo4r" class="mx-2">0</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary qty-plus" data-price="10"
                                        data-target="photo4r">+</button>
                                </span>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>2 Printed Strip : 15K</span>
                                <span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary qty-minus"
                                        data-price="15" data-target="strip">-</button>
                                    <span id="qty-strip" class="mx-2">0</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary qty-plus" data-price="15"
                                        data-target="strip">+</button>
                                </span>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>1 Printed Holoflip 4R : 25K</span>
                                <span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary qty-minus"
                                        data-price="25" data-target="holoflip">-</button>
                                    <span id="qty-holoflip" class="mx-2">0</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary qty-plus" data-price="25"
                                        data-target="holoflip">+</button>
                                </span>
                            </div>
                        </li>
                    </ul>

                    <h3>Total Price: <span id="total-price">47K</span></h3>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div id="#booking-preview" class="row">
                        <div class="col-md-12">

                            <div class="form-group mb-3">
                                <label for="booking_date">Select Date:</label>
                                <input type="text" id="booking_date" name="booking_date" class="form-control"
                                    autocomplete="off" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="booking_time">Select Time:</label>
                                <div id="time-slots" class="d-flex flex-wrap">
                                    <!-- Time slots will be loaded here -->
                                </div>
                                <input type="hidden" id="booking_time" name="booking_time">
                            </div>

                            <!-- Hidden Inputs for Additional Prints and Digital Soft Copy -->
                            <input type="hidden" id="hidden-package" name="items[0][product_name]" value="">
                            <input type="hidden" id="hidden-package-qty" name="items[0][quantity]" value="1">

                            <input type="hidden" id="hidden-photo4r" name="items[1][product_name]"
                                value="1 Printed Photo 4R">
                            <input type="hidden" id="hidden-strip" name="items[2][product_name]"
                                value="2 Printed Strip">
                            <input type="hidden" id="hidden-holoflip" name="items[3][product_name]"
                                value="1 Printed Holoflip 4R">
                            <input type="hidden" id="hidden-photo4r-qty" name="items[1][quantity]" value="0">
                            <input type="hidden" id="hidden-strip-qty" name="items[2][quantity]" value="0">
                            <input type="hidden" id="hidden-holoflip-qty" name="items[3][quantity]" value="0">
                            <button type="submit" class="btn btn-primary mt-3">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('js-konten')
        <script>
            $(document).ready(function() {
                const package = "{{ request()->input('package') }}";

                // Set initial total price based on package
                let totalPrice;

                if (package === 'Basic-tnc') {
                    totalPrice = 47;
                } else if (package === 'Projector-tnc') {
                    totalPrice = 63;
                } else if (package === 'Basic') {
                    totalPrice = 67;
                } else if (package === 'Projector') {
                    totalPrice = 90;
                } else {
                    // Default price if none of the packages match
                    totalPrice = 1000000000000000;
                }

                let hiddenPackageValue;

                if (package === 'Basic-tnc') {
                    hiddenPackageValue = 'Basic Self Photoshoot T&C';
                } else if (package === 'Projector-tnc') {
                    hiddenPackageValue = 'Projector Self Photoshoot T&C';
                } else if (package === 'Basic') {
                    hiddenPackageValue = 'Basic Self Photoshoot';
                } else if (package === 'Projector') {
                    hiddenPackageValue = 'Projector Self Photoshoot';
                } else {
                    // Set a default value if none of the packages match
                    hiddenPackageValue = 'Tidak Terdefinisi'; // Adjust this as needed
                }

                // Set the value of the hidden input
                $('#hidden-package').val(hiddenPackageValue);

                $('#total-price').text(totalPrice + 'K');

                // Konfigurasi Datepicker
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
                            console.log(response);

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

                 // Fungsi untuk memuat slot waktu
                 function loadTimeSlots(selectedDate) {
                    $('#time-slots').empty();

                    $.ajax({
                        url: '{{ route('book.checkTime') }}',
                        type: 'GET',
                        data: {
                            date: selectedDate
                        },
                        success: function(response) {
                            const bookedTimes = response.bookedTimes;
                            const start = 9 * 60; // 09:00
                            const end = 21 * 60; // 21:00

                            // Menghitung waktu saat ini pada tanggal yang dipilih
                            const selectedDateTime = new Date(selectedDate);
                            const now = new Date();
                            const currentTime = (selectedDateTime.toDateString() === now.toDateString()) ?
                                (now.getHours() * 60 + now.getMinutes()) :
                                0; // jika tanggal yang dipilih adalah hari ini, gunakan waktu sekarang

                            for (let time = start; time < end; time += 20) {
                                const hours = String(Math.floor(time / 60)).padStart(2, '0');
                                const minutes = String(time % 60).padStart(2, '0');
                                const timeString = `${hours}:${minutes}`;

                                const timeCard = $('<div class="card m-1 p-2">').text(timeString).css(
                                    'cursor', 'pointer');

                                if (bookedTimes.includes(timeString) || (selectedDateTime.toDateString() ===
                                        now.toDateString() && time < currentTime)) {
                                    timeCard.addClass('bg-danger text-white').css('cursor', 'not-allowed');
                                } else {
                                    timeCard.click(function() {
                                        $('#booking_time').val(timeString);
                                        $('#time-slots .card').removeClass('bg-success text-white');
                                        $(this).addClass('bg-success text-white');
                                    });
                                }

                                $('#time-slots').append(timeCard);
                            }
                        }
                    });
                }

                // Fungsi untuk memperbarui harga total
                function updateTotalPrice() {
                    $('#total-price').text(totalPrice + 'K');
                }

                // Event handler untuk tombol tambah
                $('.qty-plus').click(function() {
                    const target = $(this).data('target');
                    const price = parseInt($(this).data('price'));
                    let qty = parseInt($('#qty-' + target).text());

                    qty++;
                    $('#qty-' + target).text(qty);

                    // Update hidden input
                    $('#hidden-' + target + '-qty').val(qty);

                    totalPrice += price;
                    updateTotalPrice();
                });

                // Event handler untuk tombol kurang
                $('.qty-minus').click(function() {
                    const target = $(this).data('target');
                    const price = parseInt($(this).data('price'));
                    let qty = parseInt($('#qty-' + target).text());

                    if (qty > 0) {
                        qty--;
                        $('#qty-' + target).text(qty);

                        // Update hidden input
                        $('#hidden-' + target + '-qty').val(qty);

                        totalPrice -= price;
                        updateTotalPrice();
                    }
                });
            });
        </script>
    @endpush
@endsection
