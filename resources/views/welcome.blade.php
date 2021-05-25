<!DOCTYPE html >
<html>
<head>
    <title></title>
</head>
<body>
<!-- Ausgabe von Text ---->
<h1> Hello, World </h1 >


<ul>
    @foreach($impfungen as $impfung)
        <li> {{$impfung->id}} {{$impfung->impfzeit}}</li>
    @endforeach
</ul>


</body>
