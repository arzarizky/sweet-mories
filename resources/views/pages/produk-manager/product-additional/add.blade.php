@extends('layouts.app', [
    'title' => 'Product Main Add',
])

@section('konten')
    <form action="{{ route('product-manager-product-additional-add-store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card p-3 mb-3">

            <div class="mb-3">
                <label for="picture" class="form-label">Product Addtional Picture</label>
                <input class="form-control" type="file" id="imageInput" accept="image/*" name="picture"
                    placeholder="Pilih Gambar Product" required />
            </div>

            <div class="d-flex justify-content-center">
                <img id="imagePreview" class="preview-img" src="" width="75%" height="auto">
            </div>

        </div>

        <div class="card p-3">

            <div class="mb-3">
                <label for="name" class="form-label">Name Product Addtional</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="1 Printed Photo 4R" required />
            </div>

            <div class="mb-3">
                <label for="price_text" class="form-label">Price Text</label>
                <input class="form-control" type="text" id="price_text" name="price_text" placeholder="40K" required />
            </div>


            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input class="form-control" type="number" id="price" name="price" placeholder="40000" required />
            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('product-manager-product-addtional') }}" type="submit" class="btn btn-secondary">Cancel</a>
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
