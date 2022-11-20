<div class="form-group">
    <label>الاسم</label>
    <input type="text" name="name" @class(['form-control', 'is-invalid' => $errors->has('name')]) value="{{ old('name', $category->name) }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div> 
    @enderror
</div>

<div class="form-group">
<label>حالة الفئة</label>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="active" @checked(old('status' ,$category->status) ) == 'active')>
        <label class="form-check-label">
            نشط
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input " type="radio" name="status" value="archived" @checked(old('status' ,$category->status) ) == 'archived')>
        <label class="form-check-label">
            أرشيف
        </label>
    </div>
</div>

<div class="form-group">
    <label>الصورة</label>
    <input type="file" name="image" @class(['form-control', 'is-invalid' => $errors->has('image')])accept="image/*">
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" width="200">
    @endif
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="py-3">
    <button class="btn btn-outline-success">{{ $button_label ?? 'حفظ' }} </button>
</div>
