@extends('layouts.app', [
    'title' => 'Product Background Add',
])

@section('konten')
    <form action="{{ route('product-manager-product-background-add-store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card p-3 mb-3">

            <div class="mb-3">
                <label for="picture" class="form-label">Product Backround Picture</label>
                <input class="form-control" type="file" id="imageInput" accept="image/*" name="picture"
                    placeholder="Pilih Gambar Product Background" required />
            </div>

            <div class="d-flex justify-content-center">
                <img id="imagePreview" class="preview-img" src="" width="75%" height="auto">
            </div>

        </div>

        <div class="card p-3">

            <div class="mb-3">
                <label for="name" class="form-label">Name Product Background</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="Red" required />
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type Product Background</label>
                <select class="form-select" id="product" name="type" aria-label="select product" required>
                    <option selected="" value="">Pilih Type Product Background</option>
                    <option value="Color">Color</option>
                    <option value="Projector">Projector</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('product-manager-product-background') }}" type="submit" class="btn btn-secondary">Cancel</a>
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
@endpush
