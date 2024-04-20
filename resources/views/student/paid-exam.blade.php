@extends('layout.student-layout')

@section('space-work')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <h1 class="text-center">Exams</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Exam Name</th>
                    <th>Subject Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Passing Marks</th>
                    <th>Total Attempt</th>
                    <th>Available Attempt</th>
                    <th>Copy Link</th>
                </tr>
            </thead>
            <tbody>
                @if (count($exams) > 0)
                    @php $count = 1; @endphp
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ $exam->subjects[0]['name']}}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }} hrs</td>
                            <td>{{ $exam->pass_marks }}</td>
                            <td>{{ $exam->attempt }} Time</td>
                            <td>{{ $exam->attempt_counter }} Time</td>
                            <td>
                                {{-- <a href="#" data-code="{{ $exam->enterance_id }}" class="copy"><i class="fa fa-copy"></i></a> --}}
                                {{-- <a href="{{ url('/exam/' . $exam->enterance_id) }}"><i class="fa fa-copy"></i>Click me</a> --}}
                                <b><a href="#" style="color:red" class="buyNow" data-name="{{ $exam->exam_name }}" data-price="{{ $exam->price}}" data-id="{{$exam->id}}" data-toggle="modal" data-target="#buyModal">Buy Now</a></b>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">No exam available!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{-- PayPal --}}
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="POST" id="paypalForm">
        <input type="hidden" name="business" value="sb-cdovj30385582@business.example.com">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="item_name" id="item_name">
        <input type="hidden" name="item_number" id="item_number">
        <input type="hidden" name="amount" id="amount">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="cancel_return" value="{{ route('examDashboard')}}">
        <input type="hidden" name="return" id="return">
    </form>
    {{-- End paypal --}}
{{-- Payment modal --}}
<div class="modal fade" id="buyModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Buy Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="buyForm">
                  @csrf
                  <div class="modal-body">
                     <select name="price" id="price" required class="w-100">

                     </select>
                     <input type="hidden" name="exam_id" id="exam_id">
                     <input type="hidden" name="exam_name" id="examName">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning buyNowButton">Byu Now</button>
                  </div>
                </form>
            </div>
        
    </div>
  </div>
{{-- End modal --}}
    <script>
        var IsInr = false;
        $(document).ready(function () 
        {
            $('.copy').click(function () {
                $(this).parent().prepend('<span class="copied_text">Copied</span>');

                var code = $(this).attr('data-code');
                var url = "{{ URL::to('/') }}/exam/" + code;
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();

                setTimeout(() => {
                    $('.copied_text').remove();
                }, 1000);
            });

            $('#price').change(function()
            {
                var text = $('#price option:selected').text();

                if(text.includes('INR'))
                {
                    IsInr = true;
                }
                else
                {
                    IsInr = false;
                }
            })
            //payment 
            $('.buyNow').click(function () 
            {
                var price = JSON.parse($(this).attr('data-price'));
                var html = '';
                html +=`
                <option value="">Select Currency(price)</option>

                <option value="`+price.INR+`">INR`+price.INR+`</option>
                <option value="`+price.USD+`">USD`+price.USD+`</option>
                    `;
                
                    
                $('#price').html(html);
                $('#exam_id').val($(this).attr('data-id'));
                $('#exam_name').val($(this).attr('data-name'));
            });

            //submit payment form
            $('#buyForm').submit(function (e) 
            {
                e.preventDefault();
                
                $('.buyNowButton').text("Please wait....");
                var formData = $(this).serialize();
                var price = $('#price').val();
                var exam_id = $('#exam_id').val();
                var exam_name = $('#exam_name').val();

                if(IsInr == true)
                {
                    $.ajax({
                        url:"{{ route('paymentInr')}}",
                        tyep:"POST",
                        data:formData,
                        success:function (response) 
                        {
                            if(response.status == true)
                            {

                                var options = {
                                    "key":"rzp_test_gpIkesNsRrYttd",
                                    "currency": "INR",
                                    "name": "{{ auth()->user()->name}}",
                                    "description": "Exam fee",
                                    "image": "https://example.com/your_logo",
                                    "order_id": response.order_id, 
                                    "handler": function (response){
                                        var paymentData = {
                                            exam_id:exam_id,
                                            razorpay_payment_id:response.razorpay_payment_id,
                                            razorpay_order_id:response.razorpay_order_id,
                                            razorpay_signature:response.razorpay_signature
                                        }

                                        $.ajax({
                                            url:"{{ route('verifyPayment')}}",
                                            type:"GET",
                                            data:paymentData,
                                            success:function(res)
                                            {
                                                if(res.status == true)
                                                {
                                                    alert(res.msg);
                                                    location.reload();
                                                }
                                            },
                                            error:function(err)
                                            {

                                            }
                                        })
                                    },
                                    "prefill": {
                                        "name": "{{ auth()->user()->name}}",
                                        "email": "{{ auth()->user()->email}}",
                                        "contact": "8360666189"
                                    },
                                    "notes": {
                                        "address": "Razorpay Corporate Office"
                                    },
                                    "theme": {
                                        "color": "#3399cc"
                                    }
                                };
                                var rzp1 = new Razorpay(options);
                                rzp1.on('payment.failed', function (response){
                                        alert(response.error.code);
                                        alert(response.error.description);
                                        alert(response.error.source);
                                        alert(response.error.step);
                                        alert(response.error.reason);
                                        alert(response.error.metadata.order_id);
                                        alert(response.error.metadata.payment_id);
                                });
                                
                                rzp1.open();
                                
                            }
                            else 
                            {
                                alert(response.msg);
                            }
                        },
                        error:function (error) 
                        {
                            console.log(error);
                        }
                    })
                }else 
                {
                    $('#item_name').val(exam_name);
                    $('#item_number').val('1');
                    $('#amount').val(price);
                    $('#return').val("{{ URL::to('/')}}/payment-status/"+exam_id);
                    $('#paypalForm').submit();
                }

                

            });
        });
    </script>
@endsection
