<table border="1" style="border-collapse:collapse;">
@foreach($products as $pro)
<tr>
<td>{{ $pro->id }}</td>
<td>
{{ $pro->product_name }}<br>
	<div style="border: 1px solid #000;margin-top: 10px;">
	<b>Product images</b>
	@php
	$product_images = App\Models\Product_images::where('product_id',$pro->id)->get();
	@endphp
	@foreach($product_images as $pi)
		<p>{{ $pi->id}} - {{ $pi->image_small }}</p>
	@endforeach
	</div>
	
	<div style="border: 1px solid #000;margin-top: 10px;">
	<b>Product Designer measurements</b>
	@php
	$product_designer_measurements = DB::table('product_designer_measurements')->where('product_id',$pro->id)->get();
	@endphp
	@foreach($product_designer_measurements as $dsm)
		<p>{{ $dsm->id}} - {{ $dsm->measurement_name }}</p>
	@endforeach
	</div>
	
	<div style="border: 1px solid #000;margin-top: 10px;">
	<b>Product pdf</b>
	@php
	$product_pdf = DB::table('product_pdf')->where('product_id',$pro->id)->get();
	@endphp
	@foreach($product_pdf as $pp)
		<p>{{ $pp->id}} - {{ $pp->uom }}</p>
	@endforeach
	</div>
</td>
</tr>
@endforeach
</table>