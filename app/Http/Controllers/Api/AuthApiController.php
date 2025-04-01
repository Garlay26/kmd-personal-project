<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Models\Customer;
use App\Models\DeliveryTime;
use App\Models\FireBaseToken;
use App\Models\Notification;
use App\Models\PaymentMethod;
use App\Models\State;
use App\Models\Township;
use Hash;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\Cache;
use Validator;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'name' => 'required',
            'password' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'township_id' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }

        if ($request->email) {
            $check_customer = Customer::where('phone', $request->phone)->orWhere('email', $request->email)->first();
        } else {
            $check_customer = Customer::where('phone', $request->phone)->first();
        }

        if (!$check_customer) {
            $token = Str::random(20);
            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'township_id' => $request->township_id,
                'address' => $request->address,
                'fcm_token' => $request->fcm_token,
                'token' => $token,
                'register_date' => date('Y-m-d'),
            ]);

            return apiResponse(true, 'Successfully Registered!', $customer, 200);
        } else {
            return apiResponse(false, 'Phone number or email is already taken!', [], 400);
        }
    }

    public function login(request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }

        $check_customer = Customer::where('phone', $request->username)->orWhere('email', $request->username)->first();
        if ($check_customer) {
            if ($check_customer->status == 'ban') {
                return apiResponse(false, 'Your account is banned by admin!', [], 400);
            }
            $check_password = Hash::check($request->password, $check_customer->password);
            if ($check_password) {
                $token = Str::random(60);
                if ($request->fcm_token) {
                    $check_customer->token = $token;
                    $check_customer->fcm_token = $request->fcm_token;
                    $check_customer->save();
                } else {
                    $check_customer->token = $token;
                    $check_customer->save();
                }

                return apiResponse(true, 'Log In Success', $check_customer, 200);
            }
        }
        return apiResponse(false, 'Username or password wrong!', [], 400);
    }

    public function me(request $request)
    {
        $customer = getAuth($request);
        return apiResponse(true, 'Profile Fetch!', $customer, 200);
    }

    public function getCountry(request $request)
    {
        $countries = Country::orderbydesc('id')->get();
        return apiResponse(true, 'Country Fetch!', $countries, 200);
    }

    public function getState(request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }
        $cacheName = "stateList_$request->country_id";
        if (Cache::has($cacheName)) {
            $states = Cache::get($cacheName);
        } else {
            $states = State::where('country_id', $request->country_id)->orderbydesc('id')->get();
            Cache::forever($cacheName, $states);
        }
        return apiResponse(true, 'State Fetch!', $states, 200);
    }

    public function getTownship(request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_id' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }
        $cacheName = "townshipList_$request->state_id";
        if (Cache::has($cacheName)) {
            $townships = Cache::get($cacheName);
        } else {
            $townships = Township::where('state_id', $request->state_id)->orderbydesc('id')->get();
            Cache::forever($cacheName, $townships);
        }
        return apiResponse(true, 'Township Fetch!', $townships, 200);
    }

    public function getDeliveryTime(request $request)
    {
        $times = DeliveryTime::orderbydesc('id')->get();
        return apiResponse(true, 'Delivery Time Fetch!', $times, 200);
    }

    public function changePassword(request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }
        $customer = getAuth($request);
        $checkCurrent = Hash::check($request->current_password, $customer->password);
        if ($checkCurrent) {
            $customer->password = Hash::make($request->new_password);
            $customer->save();
            return apiResponse(true, 'Password Changed!', $customer, 200);
        } else {
            return apiResponse(false, 'Wrong Current Password', [], 400);
        }
    }

    public function deleteAccount(request $request)
    {
        $customer = getAuth($request);
        $customer->is_delete = 1;
        $customer->save();

        return apiResponse(true, 'Account Deleted!', [], 200);
    }

    public function paymentMethodList()
    {
        $paymentMethods = PaymentMethod::orderbydesc('id')->get();
        return apiResponse(true, 'Payment Method Fetch!', $paymentMethods, 200);
    }

    public function setFcmToken(request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }

        $token = FireBaseToken::create([
            'fcm_token' => $request->fcm_token,
        ]);

        return apiResponse(true, 'Set FCM Token!', $token, 200);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'name' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'township_id' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }
        $customer = getAuth($request);
        if ($request->email) {
            $check_customer = Customer::where(function ($query) use ($request) {
                return $query->where('phone', $request->phone)->orWhere('email', $request->email);
            })
                ->where('id', '!=', $customer->id)->first();
        } else {
            $check_customer = Customer::where('phone', $request->phone)->where('id', '!=', $customer->id)->first();
        }

        if (!$check_customer) {
            $token = Str::random(20);
            $customer->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'township_id' => $request->township_id,
                'address' => $request->address,
            ]);

            return apiResponse(true, 'Successfully Updated!', $customer, 200);
        } else {
            return apiResponse(false, 'Phone number or email is already taken!', [], 400);
        }
    }

    public function uploadProfileImage(request $request)
    {
        $customer = getAuth($request);
        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/profile_image';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $customer->update([
                'profile_image' => asset("img/profile_image/$image"),
            ]);

            return apiResponse(true, 'Successfully Updated!', $customer, 200);
        } else {
            return apiResponse(false, 'Please Upload Profile Image!', [], 400);
        }
    }

    public function notiList(request $request)
    {
        $customer = getAuth($request);
        $notifications = Notification::where('customer_id', $customer->id)->orWhereNull('customer_id')->orderbydesc('id')->paginate(10);
        return apiResponse(true, 'Notification Fetch!', $notifications, 200);
    }

    public function updateNoti(request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        }

        $noti = Notification::find($request->id);
        $noti->status = 'read';
        $noti->save();
        return apiResponse(true, 'Notification Update!', $noti, 200);
    }

    public function countUnreadNoti(request $request){
        $customer = getAuth($request);
        $count =  Notification::where('customer_id', $customer->id)->where('status','unread')->count();
        return apiResponse(true, 'Notification Count!', $count, 200);
    }

    public function checkVersion(){
        $androidVersion = "1.0.0";
        $iosVersion = "1.0.1";
        $isForceUpdate = TRUE;
        
        $result = [
            'android_version' =>  $androidVersion,
            'ios_version' =>  $iosVersion,
            'force_update' =>  $isForceUpdate,
        ];

        return apiResponse(true, 'Check Version!', $result, 200);
    }
}
