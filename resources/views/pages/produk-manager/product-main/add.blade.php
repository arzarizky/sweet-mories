@extends('layouts.app', [
    'title' => 'Product Main Add',
])

@section('konten')
    <form action="{{ route('product-manager-product-main-add-store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card p-3 mb-3">

            <div class="mb-3">
                <label for="picture" class="form-label">Product Main Picture</label>
                <input class="form-control" type="file" id="imageInput" accept="image/*" name="picture"
                    placeholder="Pilih Gambar Product" required />
            </div>

            <div class="d-flex justify-content-center">
                <img id="imagePreview" class="preview-img" src="" width="75%" height="auto">
            </div>

        </div>

        <div class="card p-3">

            <div class="mb-3">
                <label for="type" class="form-label">Type Product Main</label>
                <input class="form-control" type="text" id="type" name="type" placeholder="Self Photoshoot"
                    required />
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name Product Main</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="Basic" required />
            </div>
            <div class="mb-3">
                <label for="sub_title" class="form-label">Sub Title Product Main</label>
                <input class="form-control" type="text" id="sub_title" name="sub_title"
                    placeholder="Bebas Pilih Background" required />
            </div>
            <div class="mb-3">
                <label for="sub_title_promo" class="form-label">Sub Title Promo Product Main</label>
                <input class="form-control" type="text" id="sub_title_promo" name="sub_title_promo"
                    placeholder="Grand Opening 30% OFF" />
            </div>
            <div class="mb-3">
                <label for="price_text" class="form-label">Price Text</label>
                <input class="form-control" type="text" id="price_text" name="price_text" placeholder="40K" required />
            </div>
            <div class="mb-3">
                <label for="price_promo_text" class="form-label">Price Promo Text</label>
                <input class="form-control" type="text" id="price_promo_text" name="price_promo_text" placeholder="10K" />
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input class="form-control" type="number" id="price" name="price" placeholder="40000" required />
            </div>

            <div class="mb-3">
                <label for="price_promo" class="form-label">Price Promo</label>
                <input class="form-control" type="number" id="price_promo" name="price_promo" placeholder="10000" />
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <input class="form-control" type="text" id="note" name="note"
                    placeholder="Syarat & Ketentuan : Tag IGS, Follow IG dan Tik Tok @Sweetmoriesstudio & Review Google Maps."   />
            </div>

            <div id="terms-container" class="mb-3">
                <div class="term-field mb-2">
                    <label class="form-label">Terms and Conditions</label>
                    <input type="text" name="tnc[]" placeholder="Masukan T&C" class="form-control" required />
                </div>
                <button type="button" class="btn btn-success mt-2" id="add-term">Add More Terms</button>
            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('product-manager-product-main') }}" type="submit" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection

@push('js-konten')
    <script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    imagePreview.setAttribute('src', event.target.result);
                    imagePreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    </script>

    <script>
        document.getElementById('add-term').addEventListener('click', function() {
            const termField = document.createElement('div');
            termField.className = 'term-field mb-2';
            termField.innerHTML = `
            <input type="text" name="tnc[]" placeholder="Masukan T&C" class="form-control" required />
            <button type="button" class="btn btn-danger remove-term mt-2">Remove</button>
        `;
            document.getElementById('terms-container').insertBefore(termField, this);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-term')) {
                e.target.closest('.term-field').remove();
            }
        });
    </script>
@endpush
