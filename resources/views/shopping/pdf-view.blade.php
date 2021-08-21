<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice for order number {{ $orders->order_number }}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: center;
        }

        .invoice-box table tr td:nth-child(3) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
            width: 30%;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(3) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{asset('resources/assets/files/assets/images/logoNew.png')}}" style="width:300px;">
							<!-- https://knitfitco.com/web/resources/assets/files/assets/images/logoNew.png -->
                        </td>
                        <td> </td>
                        <td style="float:right;">
                            Invoice #: {{ $orders->order_number }}<br>
							@if($orders->receiverTransactionId)
                            Transaction Id : {{ $orders->receiverTransactionId }}<br>
							@endif
                            Created: {{ date('M d,Y',strtotime($orders->created_at)) }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php
        $address = App\Models\UserAddress::where('id',$orders->address_id)->first();
        $seller = App\Models\PaypalCredentials::where('user_id',$orders->designer_id)->first();
        ?>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
						@if($address)
                            {{ucfirst($address->first_name)}} {{$address->last_name}}<br>
                            {{$address->address}}<br>
                            {{$address->city}}<br>
                            {{$address->country}}<br>
                            {{$address->zipcode}}<br>
                            {{$address->mobile}}
						@endif
                        </td>
                        <td></td>
                        <td style="float:right;">
                            <b>Seller info</b><br>
							@if($seller)
                            {{ $seller->store_name }}<br>
                            {{ $seller->country }}
							@else
								No seller info
							@endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table>
        <tr class="heading">
            <td>
                Payment Method
            </td>

            <td>
            </td>
            <td>
                Check #
            </td>
        </tr>

        <tr class="details">
            <td>
                Paypal
            </td>

            <td>

            </td>
            <td>

            </td>
        </tr>

        <tr class="heading">
            <td>
                Item
            </td>

            <td >
                Qty
            </td>

            <td >
                Price
            </td>
        </tr>
        @if($booking_process->count() > 0)
            <?php $i=0; ?>
            @foreach($booking_process as $bp)

        <tr class="item @if($i === $booking_process->count() - 1) last @endif">
            <td >
                {{ucfirst($bp->product_name)}}
            </td>

            <td >
                {{$bp->product_quantity}}
            </td>

            <td >
                ${{number_format($bp->setpayment,2)}}
            </td>
        </tr>
                <?php $i++; ?>
            @endforeach
        @endif

        <tr class="total">
            <td></td>
            <td></td>
            <td>
                Subtotal: ${{number_format($orders->ordered_amt,2)}}
            </td>
        </tr>
        <tr class="total">
            <td></td>
            <td></td>
            <td>
                Shipping: $0.00
            </td>
        </tr>
        <tr class="total">
            <td></td>
            <td></td>
            <td>
                Tax: $0.00
            </td>
        </tr>
        <tr class="total">
            <td></td>
            <td></td>
            <td>
                Total: ${{number_format($orders->ordered_amt,2)}}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
