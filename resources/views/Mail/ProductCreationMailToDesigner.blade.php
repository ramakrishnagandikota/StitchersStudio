<html>
    <head>

    </head>
    <body>
    <p>Hi {{ Auth::user()->first_name.' '.Auth::user()->last_name }} ,</p>
    <p>Thanks you for submitting your pattern at Stitchers Studio.</p>
    <p>Your pattern is under review now. You will get notified once the pattern is approved. Thank you for your patience.</p>
    <p>Below are your pattern details.</p>
    <table border="1" style="border-collapse: collapse;">
        <tr>
            <td>Pattern name</td>
            <td>{{ $details['product_name'] }}</td>
        </tr>
        <tr>
            <td>Tell us about pattern</td>
            <td>{{ $details['product_information'] }}</td>
        </tr>
        <tr>
            <td>Uploaded images</td>
            <td>
                @php
                    $images = App\Models\Product_images::where('product_id',$details['id'])->get();
                @endphp
                @if($images->count() > 0)
                    @foreach($images as $img)
                        {{ $img->image_small }} <br>
                    @endforeach
                @endif
            </td>
        </tr>
    </table>
    <br>

    </body>
</html>
