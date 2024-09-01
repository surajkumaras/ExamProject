<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Exam,User};
use App\Models\ExamPayment;
use Razorpay\Api\Api;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function studentProfile()
    {
        try
        {
            $data = User::where('id',auth()->user()->id)->first();
            return view('student.profile')->with('data',$data);
            // return $data;
        }
        catch(\Exception $e)
        {
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    //================== User Profile Update ==================//
    public function profileUpdate(Request $request)
    {
        // return $request->all();
        try 
        {
            $user = auth()->user();

            if ($request->hasFile('profileImg')) 
            {
                $logoPath = 'public/profile/';
                $oldLogo = $user->profile_image;

                if ($oldLogo && File::exists(public_path($logoPath . $oldLogo))) 
                {
                    File::delete(public_path($logoPath . $oldLogo));
                }

                $file = $request->file('profileImg');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($logoPath), $filename);
                $user->image = $filename;
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone_number['full'],
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->pin,
                'country' => $request->country,
                'gender' => $request->gender,
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully');
        } 
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    //===================== User Export ==================//
    public function userExport()
    {
        try{
            $spreadsheet = new Spreadsheet();
            $activeWorksheet = $spreadsheet->getActiveSheet();
            $activeWorksheet->setCellValue('A1', 'ID');
            $activeWorksheet->setCellValue('B1', 'Name');
            $activeWorksheet->setCellValue('C1', 'Email');
            $activeWorksheet->setCellValue('D1', 'Gender');
            $activeWorksheet->setCellValue('E1', 'Phone');
            $activeWorksheet->setCellValue('F1', 'Address');
            $activeWorksheet->setCellValue('G1', 'City');
            $activeWorksheet->setCellValue('H1', 'State');
            $activeWorksheet->setCellValue('I1', 'Pin Code');
            $activeWorksheet->setCellValue('J1', 'Country');

            $users = user::all();

            $row = 2;
            foreach ($users as $user) 
            {
                $activeWorksheet->setCellValue('A' . $row, $user->id);
                $activeWorksheet->setCellValue('B' . $row, $user->name);
                $activeWorksheet->setCellValue('C' . $row, $user->email ?? 'null');
                $activeWorksheet->setCellValue('D' . $row, $user->gender ?? 'null');
                $activeWorksheet->setCellValue('E' . $row, $user->phone ?? 'null');
                $activeWorksheet->setCellValue('F' . $row, $user->address ?? 'null');
                $activeWorksheet->setCellValue('G' . $row, $user->city ?? 'null');
                $activeWorksheet->setCellValue('H' . $row, $user->state ?? 'null');
                $activeWorksheet->setCellValue('I' . $row, $user->zip_code ?? 'null');
                $activeWorksheet->setCellValue('J' . $row, $user->country ?? 'null');
               
                $row++;
            }
            $folderPath = public_path('excel');

            if (!file_exists($folderPath)) 
            {
                mkdir($folderPath, 0777, true);
            }
            
            $fileName = 'users_export_' . date('Y-m-d_H-i-s') . '.xlsx';
            $filePath = $folderPath ."/". $fileName;
            // Generate a unique file name
            // $fileName = 'users_export_' . date('Y-m-d_H-i-s') . '.xlsx';
            //  $filePath = public_path($fileName);
             $writer = new Xlsx($spreadsheet);
             
            // Prepare the response with headers to prompt the download
            $response = new StreamedResponse(function() use ($writer) 
            {
                $writer->save('php://output'); // Output the file directly to the browser
            });

            $fileName = 'users_export_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Set the headers for the response
            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
            $response->headers->set('Cache-Control', 'max-age=0');

            return $response;
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
    
}
