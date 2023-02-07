@extends('layouts.main')
@section('content')

    <div class="centercontent" style="height:100vh;align-content: center;">
        <div class="centercontent" style="margin-top:-10vh;">
            <div id="vrfy-dvc-hd">
                <a href="/"><h1 id="lgnpghdr">portfolioDemo</h1></a>
                <p id="vrfydvcp">Two-factor authentication</p>
                <p style="text-align:left;margin-top:30px;line-height:1.3;font-size:15px;">We have emailed you a secure code, please input this code below to verify your device.</p>
            </div>
            <form id="verify-device-form" method="post" action="verify-device/submit" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="vrfydvceinpt">
                    <label class="lrg-inpt-lbl" style="font-size:15px;">Authentication Code</label>
                    <input id="verification-code" class="lrg-inpt" name="verification-code" type="text" autocomplete="off" required="required" placeholder="6 digit code" autoFocus/>
                </div>
                <button class="whitebtn verfybtns" type="submit">Verify</button>
            </form>
            <div id="rsnd-cd-dv">
                <p>We have just sent an email to you with a verification code to verify your email, device &amp; identity.</p>
                <a id="resend-verify-btn">Re-send verification code</a>
            </div>
        </div>
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
            xhttp.open("GET", "verify-device/resend-code");
            xhttp.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhttp.send();
        });
    </script>
    <style type="text/css">
        #verify-device-form{
            width:100%;
            max-width:350px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-content:center;
            margin-top:20px;
            background-color:white;
            border:solid 1px #EAEAEA;
            border-radius:5px;
            padding:20px;
        }
        #vrfydvcp{
            margin-top:15px;
            font-size:26px;
            font-family:"Lato",sans-serif;
            font-weight: 400;
            color:rgb(90,90,90);
            width:100%;
            text-align:center;
            letter-spacing:0.5px;
        }
        #vrfy-dvc-hd{
            margin-top:20px;
            height:100px;
            width:100%;
            max-width:390px;
            display:flex;
            flex-direction:column;
            text-align:center;
            justify-content:center;
            align-content:center;
            margin-bottom:30px;
        }
        #resend-verify-btn{
            width:100%;
            font-size:18px;
            padding-top:10px;
            color:#1770E2;
            cursor: pointer;
        }
        #resend-verify-btn:hover{
            text-decoration: underline;
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
        #lgnpghdr{
            font-size:28px;
            color:#1770E2;
            font-family:'Comfortaa',sans-serif;
            letter-spacing:3px;
            text-decoration:none;
        }
        .vrfydvceinpt{
            margin-bottom:20px;
        }
        #rsnd-cd-dv{
            max-width:390px;
            text-align: left;
            margin-top: 30px;
        }
    </style>
@endsection
