<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register Email</title>
</head>

<body>
    <main>
        <h1>Welcome to E-Shopper</h1>
        <p>To log in when visiting our site just click <b>Login</b> or <b>Account</b> at the top of every page, and then enter your email address and password.
        </p>
        <h6>Use the following values when prompted to log in:
        </h6>
        <table border="1">
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $regmail['email'] }}</td>
            </tr>
            <tr>
                <td><strong>Password:</strong></td>
                <td>{{ $regmail['password'] }}</td>
            </tr>
        </table>
        <ul>When you log in to your account, you will be able to do the following:
            <li>Proceed through checkout faster when making a purchase</li>
            <li>Check the status of orders</li>
            <li>View past orders</li>
            <li>Make changes to your account information
            </li>
            <li>Change your password</li>
            <li>Store alternative addresses (for shipping to multiple family members and friends!)</li>
        </ul><br />
        <p>If you have any questions, please feel free to contact us at info@shoppingcompany.com or by phone at +91 - 22 - 40500699.
        </p>
    </main>
</body>

</html>