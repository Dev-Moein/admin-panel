<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('coupon.index',compact('coupons'));
    }
    public function create()
    {
        return view('coupon.create');
    }
       public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'percentage' => 'required|integer',
            'expired_at' => 'required|date_format:Y/m/d H:i:s'

        ]);
        Coupon::create([
           'code' => $request->code,
    'percentage' => $request->percentage,
    'expired_at' => getMiladiDate($request->expired_at)
        ]);
       return redirect()->route('coupon.index')->with('success',' تخفیف با موفقیت ایجاد شد');
    }
    public function edit(Coupon $coupon)
    {
        return view('coupon.edit',compact('coupon'));
    }
     public function update( Request $request,Coupon $coupon)
    {
         $request->validate([
    'code' => 'required|string|unique:coupons,code,' . $request->id,
    'percentage' => 'required|integer',
    'expired_at' => 'required|date_format:Y/m/d H:i:s',
]);
        $coupon->update([
        'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => getMiladiDate($request->expired_at)
        ]);
         return redirect()->route('coupon.index')->with('success',' کد تخفیف با موفقیت ویرایش شد');
    }
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
          return redirect()->back()->with('warning',' کد تخفیف با موفقیت حذف شد');
    }
}
