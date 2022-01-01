<!DOCTYPE html>
<html>
<head>
    <title>Invitattion de {{ $details['guest'] }}</title>
</head>
<body>
<h1>{{ $details['guest'] }} souhaite partager une todo-list avec vous</h1>
<p>Rejoignez-le sur <strong>TeamTodoList</strong> en cliquant sur le lien suivant: <a href="{{url("/")}}">{{url("/")}}</a></p>
<p>A bientôt</p>
<p>L'équipe de <strong>TeamTodoList</strong></p>
</body>
</html>
