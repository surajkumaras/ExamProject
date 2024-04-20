<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamPayment;
use Razorpay\Api\Api;

use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Notification;

class StudentController extends Controller
{
    private $_api_context;

    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }
    //paid exam 

    public function examDashboard()
    {
        $exams =  Exam::where('plan',1)->with('subjects')->orderBy('date','DESC')->get();
        // return $exams;
        return view('student.paid-exam',['exams'=>$exams]);
    }

    public function paymentInr(Request $request)
    {
        try{
            $api =  new Api('rzp_test_gpIkesNsRrYttd','LsU7HHNN04ACWOvTUal3YTN6');
        //    $api =  new Api(env('PAYMENT_KEY'),env('PAYMENT_SECRET'));

            $orderData = [
                'receipt'         => 'rcptid_11',
                'amount'          => $request->price.'00', // 39900 rupees in paise
                'currency'        => 'INR'
            ];
            
            $razorpayOrder = $api->order->create($orderData);

            return response()->json(['status'=>true,'order_id'=>$razorpayOrder['id']]);

        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //verify payment
    public function verifyPayment(Request $request)
    {
        try
        {
            $api =  new Api('rzp_test_gpIkesNsRrYttd','LsU7HHNN04ACWOvTUal3YTN6');

            $attributes = array(
                "razorpay_payment_id"=> $request->razorpay_payment_id,
                "razorpay_order_id"=> $request->razorpay_order_id,
                "razorpay_signature"=> $request->razorpay_signature
            );

            $api->utility->verifyPaymentSignature($attributes);

            ExamPayment::create([
                'exam_id'=>$request->exam_id,
                'user_id'=>auth()->user()->id,
                'payment_details'=>json_encode($attributes)
            ]);
            
            return response()->json(['status'=>true,'msg'=>'Payment verified successfully, Your payment ID'.$request->razorpay_order_id]);
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>false,'msg'=>'Your payement failed!!']);
        }
    }

    //paypal

    public function paymentStatus(Request $requesr ,$examId)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('/payment-status/')+examId) /** Specify return URL **/
            ->setCancelUrl(URL::to('/payment-status/')+examId);

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try 
        {

            $payment->create($this->_api_context);

        } 
        catch (\PayPal\Exception\PPConnectionException $ex) 
        {

            if (\Config::get('app.debug')) 
            {

                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');

            } 
            else 
            {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');

            }

        }

        foreach ($payment->getLinks() as $link) 
        {

            if ($link->getRel() == 'approval_url') 
            {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }

        Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');






        // paypal old code;==========================//
        // if($request->PayerID)
        // {
        //     $data = array(
        //         'PayerID'=>$request->PayerID
        //     );

        //     ExamPayment::create([
        //         'exam_id'=>$examId,
        //         'user_id'=>auth()->user()->id,
        //         'payment_details'=>json_encode($data)
        //     ]);

        //     $msg = 'Your payment has been done';
        //     return view('payment',compact('msg'));
        // }
        // else
        // {
        //     $msg = 'Your payment has been failed';
        //     return view('payment',compact('msg'));
        // }
    }
}
