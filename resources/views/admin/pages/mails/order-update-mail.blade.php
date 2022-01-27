<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Order Update</title>
</head>

<body>
    <main>
        <h1>THANK YOU FOR YOUR ORDER FROM My Shopping cart.
        </h1>

        <table border="1">
            <thead>
                <tr>
                    <th colspan="5">
                        <h4>Order Id: #{{ $ordmail['order']->id }}</h4>
                        <p>Date : {{ $ordmail['order']->created_at }}</p>
                    </th>
                </tr>
                <tr>
                    <th colspan="5">Your order has been <strong>{{$ordmail['status']}}</strong></th>
                </tr>
            </thead>

        </table>
        <p>Shipped to: {{ $ordmail['address']->name }}, {{ $ordmail['address']->address_1 }}, {{ $ordmail['address']->address_2 }},
            {{ $ordmail['address']->city }}, {{ $ordmail['address']->state }}, Postal Code: {{$ordmail['address']->postal_code}}, Mobile: {{ $ordmail['address']->mobile }}

            <br />
        <p>Order Questions?
            Call Us: +91 - 22 - 2628 7693
            +91 - 22 - 2620 2921
            Email: webadmin@indiabbt.com
        </p>
    </main>
</body>

</html>