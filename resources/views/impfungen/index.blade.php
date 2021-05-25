<!DOCTYPE html >
<html>
<head>
    <title></title>
</head>
<body>
<ul>
    @foreach ( $impfungen as $impfung)
        <li><a href= "impfungen/{{$impfung->id}}">{{$impfung->impfzeit}}</a></li>
    @endforeach
</ul>
</body>
</html>