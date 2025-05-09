<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchasedExercise;
use Carbon\Carbon;

class PaymentController extends Controller{
    function vnpay_payment(Request $request){
        $data=$request->all();
        $code_cart = rand(1000,9999);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/home/topic_payment";
        $vnp_TmnCode = "IP4MN01N";//Mã website tại VNPAY 
        $vnp_HashSecret = "WD6GVH52Y7JTOFD1MDB797STBNDXA80M"; //Chuỗi bí mật
        
        $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $data['id_topic'];
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $data['price'] * 100;
        $vnp_Locale = "VN";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }

    public function handleVNPayCallback(Request $request){
        $vnp_ResponseCode = $request->get('vnp_ResponseCode');
        $vnp_TransactionStatus = $request->get('vnp_TransactionStatus');

        if ($vnp_ResponseCode == '00' && $vnp_TransactionStatus == '00') {

            $transaction = [
                'user_id' => auth()->id(),
                'topic_id' => $request->get('vnp_OrderInfo'), // Thêm ID bài nghe
                'price' => $request->get('vnp_Amount') / 100,
                'order_info' => "Thanh toan khoa hoc co id: ".$request->get('vnp_OrderInfo'),
                'purchase_date' => Carbon::createFromFormat('YmdHis', $request->get('vnp_PayDate')),
                'status' => true,
            ];

            PurchasedExercise::create($transaction);

            return redirect()->route('topic.show', ['id' => $request->get('vnp_OrderInfo')])->with('status', 'Thanh toán thành công!');
        }

        return redirect()->route('topic.show', ['id' => $request->get('vnp_OrderInfo')])->with('status', 'Thanh toán thành công!');
    }
}
