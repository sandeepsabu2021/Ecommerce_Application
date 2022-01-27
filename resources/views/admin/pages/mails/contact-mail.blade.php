<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>New Contact Message</title>
</head>

<body>
    <main>
        <p>Dear Administrator,</p>
        <h5>Please check below details of customer. </h5>
        <table border="1">
            <tr>
                <td>Name :</td>
                <td>{{ $conmail['name'] }}</td>
            </tr>
            <tr>
                <td>Email :</td>
                <td>{{ $conmail['email'] }}</td>
            </tr>
            <tr>
                <td>Subject :</td>
                <td>{{ $conmail['subject'] }}</td>
            </tr>
            <tr>
                <td>Message: </td>
                <td>{{ $conmail['message'] }}</td>
            </tr>
        </table>
        <p>Form Posted by IP: 206.183.111.25
        </p>
    </main>
</body>

</html>