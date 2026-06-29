{{--
    Shared form partial used by both create.blade.php and edit.blade.php.
    Pass $model for edit mode (pre-fills values).
    Supports old(), existing model values, validation errors, file upload,
    select, checkbox, radio, and boolean fields.
--}}

@if($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row g-3">



    {{-- Status --}}
    <div class="col-md-6">
        <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
            <option value="active"   {{ old('status', $model->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $model->status ?? '')       === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

</div>