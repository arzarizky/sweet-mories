@extends('layouts.app', [
    'title' => 'Product Background Edit',
])

@section('konten')
    <form action="{{ route('product-manager-product-background-edit-update', $data->id) }}" method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card p-3 mb-3">
            <div class="mb-3">
                <label for="picture" class="form-label">Product Main Picture</label>
                <input class="form-control" type="file" id="imageInput" accept="image/*" name="picture"
                    placeholder="Pilih Gambar Product" />

                @if ($data->picture)
                    <div class="d-flex justify-content-center mt-2">
                        <img id="imagePreview" class="preview-img" src="{{ asset($data->getPicProductBackground()) }}"
                            width="75%" height="auto">
                    </div>
                @else
                    <div class="d-flex justify-content-center mt-2">
                        <img id="imagePreview" class="preview-img" src="" width="75%" height="auto"
                            style="display:none;">

                    </div>
                @endif
            </div>
        </div>

        <div class="card p-3">

            <div class="mb-3">
                <label for="name" class="form-label">Name Product Main</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $data->name }}"
                    placeholder="Basic" required />
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type Product Background</label>
                <select class="form-select" id="product" name="type" aria-label="select product" required>
                    <option value="" {{ $data->type == '' ? 'selected' : '' }}>Pilih Type Product Background</option>
                    <option value="Color" {{ $data->type == 'Color' ? 'selected' : '' }}>Color</option>
                    <option value="Projector" {{ $data->type == 'Projector' ? 'selected' : '' }}>Projector</option>
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
