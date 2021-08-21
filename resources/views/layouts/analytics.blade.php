<?php if(Auth::check()){
	$user_id = Auth::user()->id;
}else{
	$user_id = 0;
}
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117935197-1"></script>
<script>
var user_id = '{{$user_id}}';
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js',new Date());

if(user_id != 0){
	gtag('config', 'UA-117935197-1', {'user_id': user_id});
	//gtag('set', {'user_id': user_id});
	//console.log('user id : '+user_id);
	//ga('set', 'userId', user_id);
}else{
gtag('config','UA-117935197-1');
}
</script>