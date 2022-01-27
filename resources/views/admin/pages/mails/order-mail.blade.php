<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Order Email</title>
</head>

<body>
    <main>
        <h1>THANK YOU FOR YOUR ORDER FROM My Shopping cart.
        </h1>
        <h5>Once your package ships we will send an email with a link to track your order. Your order summary is below. Thank you again for your business.
        </h5>

        <table border="1">
            <thead>
                <tr>
                    <th colspan="5">
                        <h4>Order Id: #{{ $ordmail['order']->id }}</h4>
                        <p>Date : {{ $ordmail['order']->created_at }}</p>
                    </th>
                </tr>
                <tr>
                    <th>Sr. No.</th>
                    <th>Products</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                $sn = 1;
                @endphp
                @foreach($ordmail['details'] as $d)
                <tr>
                    <td>{{ $sn }}</td>
                    <td>
                        @foreach($ordmail['product'] as $p)
                        @if($d->product_id == $p->id)
                        {{$p->name}}
                        @endif
                        @endforeach
                    </td>
                    <td>{{ $d->quantity }}</td>
                    <td>{{ $d->price }}</td>
                    <td>{{ $d->total }}</td>
                </tr>
                @php
                $sn++;
                @endphp
                @endforeach
                <tr>
                    <td colspan="5">Bill Total: {{ $ordmail['order']->total}}</td>
                </tr>
            </tbody>
        </table>
        <p>Shipped to: {{ $ordmail['address']->name }}, {{ $ordmail['address']->address_1 }}, {{ $ordmail['address']->address_2 }},
            {{ $ordmail['address']->city }}, {{ $ordmail['address']->state }}, Postal Code: {{$ordmail['address']->postal_code}}, Mobile: {{ $ordmail['address']->mobile }}

            <br />
        <p>Call Us: +91 - 22 - 40500699
            Email: info@shoppingcompany.com
        </p>
    </main>
</body>

</html>