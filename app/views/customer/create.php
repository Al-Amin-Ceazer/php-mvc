<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="cointainer">
        <form action="<?= app_url('customer/store') ?>" method="post">
            <input type="text" name="username">
            <input type="text" name="password">
            <input type="submit" name="submit" value="login">
        </form>
    </div>
</body>
</html>
