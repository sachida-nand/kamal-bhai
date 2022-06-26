<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ $eSewa_url }}" method="POST" name="f1">
        @csrf
    <input value="{{ $order_data['tAmt'] }}" name="tAmt" type="hidden">
    <input value="{{ $order_data['amt'] }}" name="amt" type="hidden">
    <input value="{{ $order_data['txAmt'] }}" name="txAmt" type="hidden">
    <input value="{{ $order_data['psc'] }}" name="psc" type="hidden">
    <input value="{{ $order_data['pdc'] }}" name="pdc" type="hidden">
    <input value="{{ $order_data['scd'] }}" name="scd" type="hidden">
    <input value="{{ $order_data['pid'] }}" name="pid" type="hidden">
    <input value="{{ $order_data['su'] }}" type="hidden" name="su">
    <input value="{{ $order_data['fu'] }}" type="hidden" name="fu">
    
    </form>

    <script>
        document.f1.submit();
    </script>
</body>
</html>