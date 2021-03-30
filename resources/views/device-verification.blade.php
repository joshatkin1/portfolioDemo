<?php $email = session('email');?>

@extends('layouts.home')

@section('content')

    <div class="centercontent" style="margin-top:70px">
        <div id="vrfy-dvc-hd">
            <h3 id="vrfydvcp">Please verify your device &amp; email</h3>
            <p style="margin-top:20px;">We have emailed you a secure code, please input this code below.</p>
        </div>
        <form id="verify-device-form" method="post" action="/verify-device/submit" enctype="application/x-www-form-urlencoded">
            @csrf

            @if(Session('email'))
                <div class="vrfydvceinpt">
                    <label class="lrg-inpt-lbl">Email address</label>
                    <input id="email" class="lrg-inpt" name="email" type="email"  autocomplete="off" value="{{$email}}" readonly/>
                </div>
            @endif

            <div class="vrfydvceinpt">
                <label class="lrg-inpt-lbl">Verification Code</label>
                <input id="verification-code" class="lrg-inpt" name="verification-code" type="text" autocomplete="off" required="required" autofocus/>
                @error('verification-code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div id="sbmt-vrfy-btn-sec" class="vrfydvceinpt" style="display:block;">
                <button class="whitebtn verfybtns" type="submit">Submit Code</button>
            </div>

            <div class="vrfydvceinpt">
                <p>Please resend verification code to {{$email}}</p>
                <button id="resend-verify-btn" class="blubtn verfybtns" name="resend-verify-btn" type="button">resend</button>
            </div>
        </form>
    </div>
    <script type="application/javascript">
        const csrfToken = "<?php echo csrf_token();?>";
        document.getElementById("resend-verify-btn").addEventListener("click", function(e){
            e.preventDefault();
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log('email sent');
                }
            };
            xhttp.open("POST", "/verify-device/resend-code", true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.send();
        });
    </script>
    <style type="text/css">
        #verify-device-form{
            width:100%;
            max-width:450px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-content:center;
            margin-top:20px;
        }
        #vrfydvcp{
            margin-top:40px;
            font-size:28px;
            font-family:"Lato",sans-serif;
            font-weight: 400;
            color:rgb(90,90,90);
            width:100%;
            text-align:center;
        }
        #vrfy-dvc-hd{
            height:100px;
            width:100%;
            display:flex;
            flex-direction:column;
            text-align:center;
            justify-content:center;
            align-content:center;
        }
        .vrfydvceinpt{
            padding-top:30px;
        }
        #resend-verify-btn{
            width:100%;
            font-size:20px;
            letter-spacing:3px;
            padding:15px 0px;
            border-radius:4px;
            margin-top:5px;
        }
        .verfybtns{
            width:100%;
            padding:15px 0px;
            font-size:16px;
            font-weight: normal;
        }
        #sbmt-vrfy-btn-sec{
            width:100%;
            justify-content:center;
        }
    </style>
@endsection
