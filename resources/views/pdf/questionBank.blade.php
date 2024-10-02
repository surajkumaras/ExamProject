<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $catName}}</title>
    <style>
        @page {
            margin: 50px;
        }
        body {
            margin: 0;
        }
        .border {
            border: 5px double black;
            height: 100%;
            padding: 20px;
        }
    </style>

</head>
<body>
    @php
        function checkExtension($filename, $extensions) 
        {
            $extPattern = '/\.' . implode('|', $extensions) . '$/i';
            return preg_match($extPattern, $filename);
        }
        $allowedExtensions = ["jpg", "jpeg", "png"];
    @endphp
    <div class="border">

   
    <h4>Topics:{{ $catName}} related questions and answers</h4>
    <p><b>Total Questions:</b> {{ $questions->count()}}</p>
    <div class="row">
        <div class="col-sm-12">
            @if (count($questions) > 0)
                @php
                    $i = 1;
                @endphp
                <table >
                @foreach ($questions as $data)
                    <tr>
                        <td colspan="4">
                            <h5><b>Q.{{ $i }}: {{ $data->question }}</b></h5>
                        </td>
                   
                    @php
                        $filename = $data->image;
                        $j = 1;
                    @endphp
                    @if (checkExtension($filename, $allowedExtensions))
                       
                        <td colspan="8">
                            <img src="{{ public_path('public/image/que_images/' . $data->image) }}" style="border-radius:5px;" width="100px" height="80px" alt="image issue"> 
                        </td>
                    
                    @endif
                </tr>
                    <tr>
                    @foreach ($data->answers as $answeroption)
                        @php
                            $filename = $answeroption['answer'];
                        @endphp
                            @if (checkExtension($filename, $allowedExtensions))
                                @if ($answeroption['is_correct'] == 1)
                                    {{-- <td > {{ $j }}: <img src="{{ public_path('public/image/ans_images/' . $answeroption['answer']) }}" style="margin-left:50%;border-radius:5px;" width="80px" height="80px" alt="image issue">  --}}
                                        <td > Ans : <img src="{{ public_path('public/image/ans_images/' . $answeroption['answer']) }}" style="margin-left:50%;border-radius:5px;" width="80px" height="80px" alt="image issue"> 
                                        {{-- <span style="color:green">(Correct)</span> --}}
                                    </td>
                                {{-- @else
                                   <td > {{ $j }}: <img src="{{ public_path('public/image/ans_images/' . $answeroption['answer']) }}" style="margin-left:50%;border-radius:5px;" width="80px" height="80px" alt="image issue"> </td> --}}
                                @endif
                            @else
                                @if ($answeroption['is_correct'] == 1)
                                   {{-- <td > {{ $j }}: <span style="color:green">{{ $answeroption['answer'] }}</span> --}}
                                    <td >Ans: <span style="color:green">{{ $answeroption['answer'] }}</span>
                                        {{-- <span style="color:green">(Correct)</span> --}}
                                    </td>
                                {{-- @else
                                   <td > {{ $j }}: {{ $answeroption['answer'] }}</td> --}}
                                @endif
                            @endif
                        @if ($j == 2)
                            </tr><tr>
                        @endif
                        @php
                            $j++;
                        @endphp
                    @endforeach
                    @php
                        $i++;
                    @endphp
                @endforeach
                </table>
            @endif
        </div>
    </div>
    
</div>
</body>
</html>
