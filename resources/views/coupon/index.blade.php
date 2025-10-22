@extends('layout.master')
@section('title', 'coupon page')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h4 class="fw-bold">تخفیف ها</h4>
        <a href="{{ route('coupon.create') }}" class="btn btn-sm btn-outline-primary">ایجاد تخفیف</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>کد</th>
                    <th>درصد تخفیف</th>
                    <th>تاریخ انقضا</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->percentage }}</td>
                        <td>{{getjalaliDate($coupon->expired_at)}}</td>
                        <td>
                            <div class="d-flex">

                                <a href="{{ route('coupon.edit', ['coupon' => $coupon->id]) }}"
                                    class="btn btn-sm btn-outline-info me-2">ویرایش</a>
                                <form action="{{ route('coupon.destroy',['coupon' => $coupon->id]) }}" method="POST">
                                   @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

            @endsection


