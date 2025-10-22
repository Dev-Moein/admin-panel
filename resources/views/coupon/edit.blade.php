@extends('layout.master')
@section('title', 'category Edit')
@section('link')
    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
    <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
@endsection
@section('script')
<script type="text/javascript">
    jalaliDatepicker.startWatch({time:true});
</script>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">ویرایش کد تخفیف</h4>
    </div>

    <form action="{{ route('coupon.update', ['coupon' => $coupon->id]) }}" method="POST" class="row gy-4">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">کد تخفیف</label>
            <input name="code" type="text" value="{{ $coupon->code }}" class="form-control" />
            <div class="form-text text-danger">
                @error('code')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">درصد تخفیف</label>
            <input name="percentage" type="text" value="{{ $coupon->percentage }}" class="form-control" />
            <div class="form-text text-danger">
                @error('percentage')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">تاریخ انقضا</label>
            <input data-jdp name="expired_at" type="text" value="{{ getJalaliDate($coupon->expired_at, true) }}" class="form-control" />
            <div class="form-text text-danger">
                @error('expired_at')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-outline-dark mt-3">
                ویرایش کد تخفیف
            </button>
        </div>
    </form>
@endsection
