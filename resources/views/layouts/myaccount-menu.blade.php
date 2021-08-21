<ul>
    <li class="{{Request::is('wishlist') ? 'active' : ''}}" >
    	<a href="{{url('wishlist')}}">Wishlist</a>
    </li>
    <li class="{{Request::is('cart') ? 'active' : ''}}" >
    	<a href="{{url('cart')}}">Cart</a>
    </li>
    <li class="{{Request::is('change-password') ? 'active' : ''}}">
    	<a href="{{url('change-password')}}">Change Password</a>
    </li>
    <li class="{{Request::is('my-orders') ? 'active' : ''}}">
    	<a href="{{url('my-orders')}}">My orders</a>
    </li>
    <li class="{{Request::is('my-account') ? 'active' : ''}}" >
    	<a href="{{url('my-account')}}">Newsletter info</a>
    </li>
    <li class="{{Request::is('my-address') ? 'active' : ''}}">
    	<a href="{{url('my-address')}}">Address</a>
    </li>
    @if(Auth::user()->hasRole('Designer'))
    <li class="{{Request::is('designer/paypal') ? 'active' : ''}}">
    	<a href="{{url('designer/paypal')}}">Paypal credentials</a>
    </li>
    @endif
	
</ul>