<?php

    // delete image
    function DeleteImage($folder_path,$file_name)
    {
        $image = explode("/",$file_name);
        unlink(public_path().'/'.$folder_path.'/'.$image[5]);
    }

    // OTP
    function sendSMS($phone, $message)
    {
        $response = Http::withBasicAuth('SB40357562362498329450562314881743', 'ToFK0dbw59@8a$MJ8y(x8AOdmUbc(ppzcMQvXZ5r5t8b')
            ->asForm()->post('http://api.smsbrix.com/v1/message/send', [
                'senderid' => 'Xsphere',
                'number' => $phone,
                'message' => $message,
            ]);
        return $response;
    }

    function addNoti($title, $message,$type = null,$type_id = null) 
    {
        $new_noti = App\Models\Notification::create([
            'title' => $title,
            'message' => $message,
            'date' => date('Y-m-d H:i:s'),
            'type' => $type,
            'type_id' => $type_id,
            'create_by' => Auth::user()->id,
        ]);

    }

    function apiResponse($status, $message, $data, $statusCode)
    {
        return response()->json([
            'meta' => [
                'status' => $status,
                'message' => $message,
            ],
            'body' => $data,
        ], $statusCode);
    }

    function getAuth($request){
        $header = $request->header('Authorization');
        $explode = explode('Bearer ', $header);
        $customer = App\Models\Customer::where('token', $explode[1])->first();
        return $customer;
    }

    function sendNoti($customer_id,$title,$message,$type = null, $type_id = null)
    {
        // dd($customer_id,$title,$message,$type);
        $SERVER_API_KEY = 'AAAA0ss1k8I:APA91bHz-pzHCe5psxnxLJS20Ve8v17l9tEYe7z0Uuq7shv2R0A99h7BG0XdNQWO0dhEpgYpkZQymHtFfzyGvl5HYvPWRiv1sUC-moNkZlOyrSlvCN1va2GGAkJxKFo-1lRfdgsS3j3S';
        if($customer_id){
            $firebaseToken = App\Models\Customer::where('id',$customer_id)->whereNotNull('fcm_token')->pluck('fcm_token')->all();
            $firebaseToken2 = $firebaseToken;
        }
        else{
            $customerToken = App\Models\Customer::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            $tokens = App\Models\FireBaseToken::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            $firebaseToken = array_merge($customerToken,$tokens);
            $firebaseToken2 = array_values(array_unique($firebaseToken));
        }
        $data = [
            "registration_ids" => $firebaseToken2,
            "notification" => [
                "title" => $title,
                "body" => $message,
            ],
        ];
        $dataString = json_encode($data);

        $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);
            $result = json_decode($response);
            // dd($response,$result);
            if ($result) {
                if ($result->success > 0) {
                    $message = App\Models\Notification::create([
                        'title' => $title,
                        'message' => $message,
                        'date' => date('Y-m-d H:i:s'),
                        'customer_id' => $customer_id,
                        'type' => $type,
                        'type_id' => $type_id,
                    ]);
                }
                return TRUE;
            }
            return FALSE;
        
    }

    function generateBarcode(){
        $bar_code = mt_rand(1000000000, 9999999999);
        $check = FALSE;
        $product = \App\Models\Product::where('bar_code',$bar_code)->first();
        if($product){
            $check = TRUE;
        }

        while ($check == TRUE) {
            $bar_code = mt_rand(1000000000, 9999999999);
            $product = \App\Models\Product::where('bar_code',$bar_code)->first();
            if($product){
                $check = TRUE;
            }
            else{
                $check = FALSE;
            }
        }

        return $bar_code;
    }

