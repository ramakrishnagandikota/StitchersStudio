@extends('layouts.app')
@section('title','Invitation')
@section('content')
<div class="col-sm-12">

    <div class="hide alert" id="errorMsg"></div>
    <form class="md-float-material form-material" method="post" id="update-role">
                       @csrf
        <div class="auth-box card">
            
                <div class="row m-b-10 custom-card-header">
                    <div class="col-md-8">
                        <h3 class="txt-primary text-light">You're invited</h3>
                        <h6 class="text-light">to become a member of the StitchersStudio designer community!</h6>
                    </div>
                    <div class="col-md-4 m-t-10">
                        <img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo img-fluid" alt="logo.png">
                    </div>
                </div>
                <!-- <p class="text-muted text-center p-b-5">Sign in with your regular account</p> -->
               
                <!-- <div class="row text-left">
                    <div class="col-12">
                       
                        <div class="forgot-phone text-right float-right m-b-20">
                            <a href="reset-password.html" class="text-right text-muted micro-label"> Forgot Password?</a>
                        </div>
                    </div>
                </div>
               -->
               <p class="f-w-600 f-14 m-t-20">Get the full benefits of being a designer on the StitchersStudio app.</p>
               <ul>
                    <li>Unlimited traditional pattern listings</li>
                    <li>Ability to offer promotions and notifications to the StitchersStudio knitter community</li>
                    <li>Ability to connect in private groups with your knitters</li>
                    <li>Access to trained technical editors for pattern grading and Custom Pattern translation services</li>
               </ul>
               <p class="f-w-600 f-14">Click below to start. You'll be asked to sign in with your StitchersStudio account or register for a new account.</p>

               

               <div class="checkbox-fade fade-in-primary row" id="tncaccept" style="background: none;">
                <label class="micro-label col-md-12" >
                    <input type="checkbox" value="1" id="terms" name="terms">
                    <span class="cr custom-chkbox"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                    <!--<span class="text-inverse">I read and accept Terms and Conditions</span>-->
                    <p>Please read <a href="javascript:;" id="tnclink" data-toggle="modal" data-target="#tncModal">terms and conditions</a> and provide your consent to go ahead.</p>
                </label>
            </div>

           @if(Session::has('identity'))
            <input type="hidden" name="identity" value="{{ Session::get('identity') }}">
            <input type="hidden" name="invited" value="{{ Session::get('invited') }}">
            <input type="hidden" name="new" value="{{ Session::get('new') }}">
           @endif

                <div class="row m-t-20">
                    <div class="col-md-6 text-center offset-lg-6">
                        <button id="login-button" type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-5 theme-btn" disabled >Register now</button>
                    </div>
                </div>
                <p class="text-inverse text-left"><a href="{{ url('skip-invitaton') }}" style="color: #0d665c">Skip invitation</a></p>
                <!--<p class="text-inverse text-left">Use existing account?<a href="sign-up.html" style="color: #0d665c"> <b>Proceed as a designer</b></a></p>-->
            <!--<p class="text-muted f-w-600">When you accept your subscription,you'll get your own StitchersStudio account page,where you can access your personal data,To manage your subscription,go to my account.</p>
            <p>Link not working? Copy and paste this url:</p>-->
        </div>
    </form>
</div>


<div class="modal fade" id="tncModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
        </div>
        <div class="modal-body">
            <h3>Privacy Policy</h3>
            <p>We respect your privacy and are committed to protecting it as described in this privacy policy. We use a variety of current technologies and processes designed to secure your information. And you can unsubscribe from our email and postal mailing lists at any time.</p>
            <p>This Privacy Policy governs the manner in which Stitchers Studio and Knit Fit Couture, LLC. (collectively, “Stitchers Studio,” “KnitFitCo,” “we” or “us”) collects, uses, maintains and discloses information collected from users (each, a “User”) of the stitchersstudio.com and knitfitco.com websites and our mobile applications (collectively, the “Site”). This Privacy Policy applies to the Site and all products and services (“Services”) offered by Stitchers Studio and KnitFitCo on or through the Site. By accessing and using the Site and Services, you agree to the terms and conditions of this Privacy Policy. If you do not agree with any terms of this Privacy Policy, you may not access or use the Site or Services for any purpose.</p>
            <p>Stitchers Studio and Knit Fit Couture provide a service that uses proprietary technology to bring you custom fitted knitting patterns based on your exact size.</p>

            <h3>Information We Collect</h3>
            <p>We collect personal information directly from you. We receive and store information you enter on our Services, when you call or email or communicate with us through social media (Twitter, Facebook, et al.), or participate in events or other promotions. Part of our Services involves collecting, storing, processing and otherwise using measurements relating to certain features of your body. You provide the measurements of your body that we use as requested and described within our Services.</p>
            <p>Examples of personal information that we collect include sizing information, name, email address, credit card number, purchase and order information, personal preferences, and responses to survey information.</p>
            <p>Usage and Log Information: When you use our Services, we collection and log information about your use of our Services, including your browser type and language, access times, pages viewed, your IP address and location.</p>
            <p>Device Information: We may collect information about the computer or device you use to access our Services, including the hardware model, operating system and version, MAC address, unique device identifier, phone number, International Mobile Equipment Identity (“IMEI”) and mobile network information. In addition, the Services may access your device’s native phonebook, with your consent, to facilitate your use of certain features of the Services.</p>
            <p>Information Collected by Cookies and Other Tracking Technologies: We use various technologies to collect information, and this may include sending cookies to you. Cookies are small data files stored on your hard drive or in device memory that help us to improve our Services and your experience, see which areas and features of our Services are popular and count visits. We may also collect information using web beacons (also known as “tracking pixels”)</p>

            <h3>Use of Information</h3>
            <p>We do not share your personal information with any third party, except as described in this Privacy Policy.</p>
            <p>Stitchers Studio and KnitFitCo collects and uses your personal information to provide, maintain and improve our Services and deliver the services you have requested, including processing transactions. Stitchers Studio and KnitFitCo may also use your personally identifiable information to inform you of other products or services available from Stitchers Studio and KnitFitCo and its affiliates, store information about your preferences, allowing us to customize our Services according to your individual interests, speed up your searches, recognize you when you return to our website, estimate our audience size and usage patterns. Stitchers Studio and KnitFitCo may also contact you via surveys to conduct research about your opinion of current services or of potential new services that may be offered.</p>
            <p>We may disclose your personal information to our service providers and other third parties we use to support our business. However, at all times we restrict who has access to your personal information and take great care to protect your privacy in all regards.</p>
            <p>Stitchers Studio and KnitFitCo may disclose your personal information, without notice, if required to do so by law or in the good faith belief that such action is necessary to: (a) conform to the edicts of the law or comply with legal process served on Stitchers Studio and KnitFitCo or the Services, including respond to any government or regulatory request; (b) protect and defend the rights or property of Stitchers Studio and KnitFitCo, including enforcing or applying our terms of use and other agreements, including for billing and collection purposes; and, (c) if we believe disclosure is necessary or appropriate to protect the rights, property, or safety of Stitchers Studio and KnitFitCo, our customers or others. We may share information about you in connection with, or during negotiations of, any reorganization, dissolution, restructuring, merger, sale of company assets, financing or acquisition of all or a portion of our business to a buyer or other successor, whether as a going concern or as part of bankruptcy, liquidation or similar proceeding, in which personal information held by Stitchers Studio and KnitFitCo about the users of our Services is among the assets transferred.</p>
            <p>We may also share aggregated or de-identified information, which cannot reasonably be used to identify you. This could include aggregated, anonymous measurement, size and shape information about our users and their purchases. The anonymous aggregated data that we may collect could be used in a variety of ways, including but not limited to, improving the performance of our Services and helping us understand more about the relationships between body shapes, sizes and style preferences. We may also, in the future, share such aggregated, anonymous information with third-party partners. By using our services, you are consenting to the collection and use of such anonymous aggregated data.</p>
            <p>We may share the personal information we collect with our affiliates, business partners, ad network vendors and their participants, and other third parties for the purposes described in this Policy, including to communicate with you about products and services, offers, events and promotions that we believe may be of interest to you.</p>

            <h3>Security of Your Personal Information</h3>
            <p>We further suggest that all users safeguard their own account username and password and not share that information with anyone. If users are concerned about misuse of their identity within the Services, or are using a shared device, users should make an effort to log out as often as necessary. We will never ask for your password via email and users should report any such inquiry.</p>
            <p>Stitchers Studio and KnitFitCo meets or exceeds the standards generally accepted by the industry within which it operates in regards to the protection of personal information. However, no electronic transmission of information can be executed with absolute certainty that a failure or breach will not occur. Company cannot guarantee that the security measures in place to safeguard personal information will never be defeated or fail, or that those measures will always be sufficient or effective.</p>

            <h3>Children under Thirteen</h3>
            <p>Our Services are not intended to be used by children under 13 years of age. No one under age 13 may provide any information to or on our Services. We do not knowingly or intentionally collect personal information, except for measurement data to be used to create custom knitting patterns, from children under the age of 13. If you are under 13, do not use or provide any information on our website and other Services. If you believe we might have any information from or about a child under 13, please contact us at info@knitfitco.com.</p>
            <p>Parents or guardians: we want to help you guard your children’s privacy. We encourage you to talk to your children about safe and responsible use of their Personal Information while using the Internet. In addition, users of our Service must (a) be at least 18 years of age or, (b) if younger, be with the supervision of a parent or guardian.</p>

            <h3>Opt-Out and Unsubscribe</h3>
            <p>We respect your privacy and give you an opportunity to opt-out of receiving announcements of certain information. Users may opt-out of receiving any or all communications from Stitchers Studio and Knitfitco by contacting us by email at info@knitfitco.com or calling 1-269-326-6193.</p>

            <h3>Your California Privacy Rights</h3>
            <p>California Civil Code Section 1798.83 permits users of our Services that are California residents to request certain information regarding our disclosure of personal information to third parties for their direct marketing purposes. To make such a request, please send an email to info@knitfitco.com or write us at noetic address: 6277 Carolina Commons Drive, Ste 600-319, &ZeroWidthSpace;Indian Land, SC 29707.</p>

            <h3>Changes to Privacy Policy</h3>
            <p>This policy may change from time to time. Your continued use of our Services after we make changes is deemed to be acceptance of those changes, so please check the policy periodically for updates.</p>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn theme-outline-btn" data-dismiss="modal">Close</button>
          <!--<button id="proceed" type="button" class="btn theme-btn">Proceed</button> -->
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footersection')
<style>
      .theme-logo {width: 210px;}
      .form-material .form-control:focus {
    background-color: #fff;
    border-bottom: 1px solid #cccccc;
    border-radius: 2px;
}
.login-block{margin:20px auto}
.auth-box{padding:0px 15px 10px 15px}
.login-block .auth-box{max-width: 550px;}
.custom-card-header{padding-top: 40px;padding-bottom: 40px;background-color: #0d665c;}
.modal-body{height: 380px;overflow-y: scroll;}
#tncaccept{bottom: 62px;width: 99.7%;background: #e4e4e4;padding: 6px;padding-top: 3px;float: left;left: 1px;} 
#tnclink{color: #c14d7d;}
#login-button{    padding-right: 40px;
    padding-left: 40px;}
      </style>

      <script type="text/javascript">
          $(function(){
                $(document).on('click','#terms',function(){
                    if($(this).prop('checked') == true){
                        $("#login-button").prop('disabled',false);
                    }else{
                        $("#login-button").prop('disabled',true);
                    }
                });


                $(document).on('click','#login-button',function(){
                    var Data = $("#update-role").serializeArray();

                    $.ajax({
                        url : "{{ url('update-user-roles') }}",
                        type : "POST",
                        data : Data,
                        beforeSend : function(){
                            $(".loading").show();
                        },
                        success : function(res){
                            if(res.status == true){
                                $("#errorMsg").removeClass('hide alert-danger').addClass('alert-success').html(res.message);
                                setTimeout(function(){ $("#errorMsg").addClass('hide').html(''); },5000);
                                window.location.assign('{{ url("dashboard") }}');
                            }else{
                                $("#errorMsg").addClass('alert-danger').removeClass('hide alert-success').html(res.message);
                                setTimeout(function(){ $("#errorMsg").addClass('hide').html(''); },5000);
                            }
                        },
                        complete : function(){
                            $(".loading").hide();
                        }
                    });
                });
          });
      </script>
@endsection
