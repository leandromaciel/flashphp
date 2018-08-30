<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notify-me</title>
</head>
<body>

    
    {foreach from=$User->list item=$user}
        Id do usuário: {$user.id}
        <br>
        Login do usuário: {$user.login}
    {/foreach}

</body>
</html>