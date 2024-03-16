<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title']}}</title>
</head>
<body>
    <p>
        <b>Hii {{ $data['name']}},</b> your exam {{ $data['exam_name']}} result is rollout ,
        so now you can download your result from the link below.
    </p>
    <a href="{{ $data['url']}}">Click here</a>
    <p>Thank you!</p>
</body>
</html>