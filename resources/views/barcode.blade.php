<!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Product BarCode</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->bar_code,'CODE11') }}" height="30" width="auto" />
        <br>
        <p style="letter-spacing: 10px;margin-left:5px">{{$product->bar_code}}</p>
        <p>{{$product->name}} ( ¥{{$product->price}} )</p>
        <script>
            window.print();
        </script>
    </body>
</html>