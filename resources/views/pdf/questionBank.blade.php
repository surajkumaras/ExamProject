<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    <h1>Question Bank</h1>
    
    <div class="row">
        <div class="col-sm-12">
            @if (count($questions) > 0)
                @php
                    $i = 1;
                @endphp
                @foreach ($questions as $data)
                    <h5><b>Q.{{ $i }}: {{ $data->question }}</b></h5>
                    @php
                        $filename = $data->image;
                        $j = 1;
                    @endphp
                    @if (checkExtension($filename, $allowedExtensions))
                        <img src="{{ asset('public/image/que_images/' . $data->image) }}" style="margin-left:50%;border-radius:5px;" width="80px" height="80px" alt="image issue"><br>
                    @endif

                    @foreach ($data->answers as $answeroption)
                        @php
                            $filename = $answeroption['answer'];
                        @endphp

                        @if (checkExtension($filename, $allowedExtensions))
                            @if ($answeroption['is_correct'] == 1)
                                {{ $j }}: <img src="{{ asset('public/image/ans_images/' . $answeroption['answer']) }}" style="border-radius:5px;" width="50px" height="50px" alt="image issue">
                                <span style="color:green">(Correct)</span><br><br>
                            @else
                                {{ $j }}: <img src="{{ asset('public/image/ans_images/' . $answeroption['answer']) }}" style="border-radius:5px;" width="50px" height="50px" alt="image issue"><br><br>
                            @endif
                        @else
                            @if ($answeroption['is_correct'] == 1)
                                {{ $j }}: <span style="color:green">{{ $answeroption['answer'] }}</span>
                                <span style="color:green">(Correct)</span><br><br>
                            @else
                                {{ $j }}: {{ $answeroption['answer'] }}<br><br>
                            @endif
                        @endif

                        @php
                            $j++;
                        @endphp
                    @endforeach
                    @php
                        $i++;
                    @endphp
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>
