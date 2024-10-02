@extends('layout.student-layout')

@section('space-work')
@php
    function checkExtension($filename, $extensions) 
        {
            $extPattern = '/\.' . implode('|', $extensions) . '$/i';
            return preg_match($extPattern, $filename);
        }
        $allowedExtensions = ["jpg", "jpeg", "png"];
@endphp
    <h1>View Questions</h1>
<table border="1">
    <div class="row">
        <div class="col-sm-12">
            @if (count($questions) > 0)
                @php
                    $i = 1;
                @endphp

                @foreach ($questions as $data)
                    {{-- Display the question --}}
                    <tr>
                        <td colspan="8"><h6>Q.{{ $i }}: {{ $data->question }}</h6></td>
                    </tr>
                    @php
                        $filename = $data->image;
                        $j = 1;
                    @endphp
                    @if (checkExtension($filename, $allowedExtensions))
                    <tr>
                        <td colspan="8"><img src="{{ asset('public/image/que_images/'. $data->image) }}" style="border-radius:5px;" width="80px" height="80px" alt="image issue"></td>
                    </tr>
                    @endif
                    {{-- Display the answers --}}
                    <tr>
                    @foreach ($data->answers as $answeroption)

                        @php
                            $filename = $answeroption['answer'];
                            
                        @endphp
                        
                        @if (checkExtension($filename, $allowedExtensions))
                        
                            @if ($answeroption['is_correct'] == 1)
                               <td colspan="2"> {{$j}}: &nbsp<img src="{{ asset('public/image/ans_images/'. $answeroption['answer']) }}" style="border-radius:5px;" width="50px" height="50px" alt="image issue">
                                <span style="color:green">(Correct)</span><td>
                            @else
                                <td colspan="2">{{$j}}: &nbsp<img src="{{ asset('public/image/ans_images/'. $answeroption['answer']) }}" style="border-radius:5px;" width="50px" height="50px" alt="image issue"></td>
                            @endif
                        @else
                        
                            @if ($answeroption['is_correct'] == 1)
                               <td> {{$j}}: &nbsp{{ $answeroption['answer'] }}
                                <span style="color:green">(Correct)</span></td>
                            @else
                               <td> {{$j}}: {{ $answeroption['answer'] }}</td>
                            @endif
                        @endif
                        
                        @php
                            $j++;


                        @endphp
                    @endforeach
                </tr>
                <tr>
                    <td colspan="8" width="10%"></td>
                </tr>
                    @php
                        $i++;
                    @endphp
                    
                @endforeach
            @endif
        </div>
    </table>   
@endsection