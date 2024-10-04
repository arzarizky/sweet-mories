@extends('layouts.app', [
    'title' => 'Product Main Add',
])

@section('konten')
    <div class="card p-3 mb-3">

        <div class="mb-3">
            <label for="name" class="form-label">Product Main Picture</label>
            <input class="form-control" type="file" id="imageInput" accept="image/*" name="name"
                placeholder="Pilih Gambar Product" required />
        </div>

        <div class="d-flex justify-content-center">
            <img id="imagePreview" class="preview-img" src="" width="75%" height="auto">
        </div>

    </div>

    <div class="card p-3">

        <div class="mb-3">
            <label for="name" class="form-label">Name Product Main</label>
            <input class="form-control" type="text" id="name" name="name" placeholder="John Doe" required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Sub Title Product Main</label>
            <input class="form-control" type="text" id="name" name="name" placeholder="John Doe" required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Sub Title Promo Product Main</label>
            <input class="form-control" type="text" id="name" name="name" placeholder="John Doe" required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Price Text</label>
            <input class="form-control" type="text" id="name" name="name" placeholder="John Doe" required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Price Promo Text</label>
            <input class="form-control" type="text" id="name" name="name" placeholder="John Doe" required />
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Price</label>
            <input class="form-control" type="number" id="name" name="name" placeholder="John Doe" required />
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Price Promo</label>
            <input class="form-control" type="number" id="name" name="name" placeholder="John Doe" required />
        </div>

        <div id="terms-container" class="mb-3">
            <div class="term-field mb-2">
                <label class="form-label">Terms and Conditions</label>
                <input type="text" name="terms[]" placeholder="Masukan T&C" class="form-control" required />
            </div>
            <button type="button" class="btn btn-success mt-2" id="add-term">Add More Terms</button>
        </div>

    </div>
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
            <input type="text" name="terms[]" placeholder="Masukan T&C" class="form-control" required />
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
