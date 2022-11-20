<div class="form-group">
    <label>العنوان</label>
    <input type="text" name="title" @class(['form-control', 'is-invalid'=> $errors->has('title')]) value="{{ old('name', $post->title) }}">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>الوصف</label>
    <textarea name="description" @class(['form-control', 'is-invalid'=> $errors->has('description')]) cols="30">{{old('description',$post->description)}}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>فئة العمل التطوعي</label>
    <select name="category_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
        <option selected="selected" value="">اختار الفئة</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected($post->category_id == $category->id )>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>الموقع الجغرافي</label>

    <input type="text" name="location" @class(['form-control', 'is-invalid'=> $errors->has('location')]) value="{{old('location',$post->location)}}">
    @error('location')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="active" @checked($post->status == 'active')>
    <label class="form-check-label">
        نشط
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="archived" @checked($post->status == 'archived')>
    <label class="form-check-label">
        أرشيف
    </label>
</div>
<div class="form-group">
    <label>الصورة</label>
    <input type="file" name="image" @class(['form-control', 'is-invalid'=> $errors->has('image')])>
    @if ($post->image)
    <img src="{{ asset('storage/' . $post->image) }}" width="200">
        @endif
    @error('image')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="py-3">
    <button class="btn btn-outline-success">{{ $button_label ?? 'حفظ' }} </button>
</div>
