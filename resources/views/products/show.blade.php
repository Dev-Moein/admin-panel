@extends('layout.master')
@section('title', 'Products Show')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">نمایش محصول</h4>
    </div>

    <div class="row gy-4 mb-5">
        <div class="col-md-12 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                        <img src="{{asset('images/products/'.$product->primary_image )}}" class="rounded" width=350 height=220 alt="primary-image">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">نام</label>
            <input class="form-control bg-light" disabled value="{{$product->name}}">
        </div>

        <div class="col-md-3">
            <label class="form-label">دسته بندی</label>
        <input class="form-control bg-light" disabled value="{{$product->category->name}}">
        </div>

        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <input class="form-control bg-light" disabled value="{{$product->status ? 'فعال' : 'غیرفعال'}}">
        </div>
        <div class="col-md-3">
            <label class="form-label">قیمت</label>
            <input  disabled value="{{ $product->price }}" class="form-control bg-light" />

        </div>

        <div class="col-md-3">
            <label class="form-label">تعداد</label>
            <input disabled value="{{ $product->quantity }}" class="form-control bg-light" />
        </div>

        <div class="col-md-3">
            <label class="form-label">قیمت حراجی</label>
            <input disabled value="{{ $product->sale_price > 0 ? $product->sale_price : '' }}" class="form-control bg-light" />
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ شروع حراجی</label>
            <input disabled value="{{ getjalaliDate($product->date_on_sale_from,'Y/m/d H:i') }}"  class="form-control bg-light" />
        </div>

        <div class="col-md-3">
            <label class="form-label">تاریخ پایان حراجی</label>
            <input disabled value="{{ getjalaliDate($product->date_on_sale_to,'Y/m/d H:i')}}"  class="form-control bg-light" />
        </div>

        <div class="col-md-12">
            <label class="form-label">توضیحات</label>
            <textarea disabled rows="5" class="form-control bg-light">{{$product->description}}</textarea>
        </div>

        <div class="col-md-12 d-flex flex-wrap gap-3">
            @foreach ($product->images as $image)
              <img src="{{asset('images/products/'.$image->image )}}" class="rounded " width=200  >
              @endforeach
        </div>
    </dive>
@endsection
