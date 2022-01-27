<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin Reply Contact</title>
</head>

<body>
    <main>
        <h4>Subject: Response to "{{ $conmail['subject'] }}"</h4><br />
        <p>Dear {{ $conmail['name'] }},</p><br />
        <p>
            {{ $conmail['message'] }}
        </p>
        <br />
        <p>Admin, E-Shopper
        </p>
    </main>
</body>

</html>