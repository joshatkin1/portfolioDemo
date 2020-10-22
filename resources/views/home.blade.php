@extends('layouts.home')

@section('content')

    <section class="container">
        <div id="landingheader">
            <div class="ldngheadsec">
                <h1 class="headertxt" style="font-size:95px;font-weight: normal;letter-spacing:4px;">?<!--softsync--></h1>
                <h3 class="headertxt" style="font-size:33px;padding-top:5px;font-weight: lighter;">??????????<!--synchronizing software development.--></h3>
                <p class="hm-sel-txt">?????????<!--softsync is a software development platform that brings together all the complicated aspects of development and project management into one simple application.--></p>
            </div>
            <div class="ldngheadsec">
                <form id="ldngpgregform" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <h2>Create Your Account</h2>
                    <h4>join free today.</h4>
                    <div class="lndpglgninptdv">
                        <label class="lrg-inpt-lbl">Full name*</label>
                        <input id="name" name="name" class="hm-reg-inpt" type="text" autocomplete="off"  required/>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                    </div>
                    <div class="lndpglgninptdv">
                        <label class="lrg-inpt-lbl">Email*</label>
                        <input id="email" name="email" class="hm-reg-inpt" type="email" autocomplete="off" required/>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                    </div>
                    <div class="lndpglgninptdv">
                        <label class="lrg-inpt-lbl">Password*</label>
                        <input id="password" name="password" type="password" class="hm-reg-inpt" autocomplete="off" required/>
                        <p style="display:none;font-size:11px;margin-top:3px;" id="password-help">make it atleast <span id="hm-pas-lngth-req">10 characters long </span> with <span id="hm-pas-ltr-req">1 lower case letter</span> and <span id="hm-pas-num-req">1 number</span>.</p>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                    </div>
                    <div class="lndpglgninptdv">
                        <button id="lndgsgnupbtn" class="whitebtn">Sign up for ?</button>
                        <p style="font-size:10px;margin-top:20px;letter-spacing:0.5px">By clicking Sign Up, you agree to our <a href="/terms">Terms</a>. Learn how we collect, use and share your data in our Data Policy and how we use cookies and similar technology in our Cookie Policy.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <style type="text/css">
        #landingheader{
            width:100%;
            display:flex;
            flex-direction:row;
            flex-wrap: wrap;
        }
        .ldngheadsec{
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .ldngheadsec:first-child{
            width:65%;
        }
        .ldngheadsec:last-child{
            width:35%;
        }
        #lndgpgwebname{
            margin-top:120px;
            font-family:'Comfortaa',sans-serif;
            font-size:55px;
            font-weight:bolder;
            color:#0D9BB4;
            letter-spacing:7px;
        }
        #lndgpgheadp{
            margin-top:16px;
            width:95%;
            max-width:600px;
            font-size:43px;
            color:rgb(80, 80, 80);
            font-weight: lighter;
            font-family:'Lato',sans-serif;
            font-weight:bolder;
            line-height:1.8em;
        }
        .ldngpgsitecntsell{
            width:100%;
            height:250px;
            margin-top:10px;
            display:flex;
            flex-direction: row;
            justify-content:flex-start;
            flex-wrap:wrap;
        }
        .webfuncselldv{
            width:150px;
            height:150px;
            border:solid 1.5px lightgray;
            border-color:lightgray;
            border-radius:20px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items: center;
            margin:20px;
            overflow:hidden;
            font-size:15px;
            font-weight:bolder;
            color:#0D9BB4;
            padding:3px;
            -webkit-transition : border 500ms ease-out;
            -moz-transition : border 500ms ease-out;
            -o-transition : border 500ms ease-out;
            transition : border 500ms ease-out;
            cursor:pointer;
        }
        .lndgpgesecdv{
            width:100%;
            display:flex;
            flex-direction:column;
            margin-top:20px;
            height:700px;
        }
        #ldngpgregform{
            width:100%;
            max-width:400px;
            margin-top:40px;
            font-family:'Open Sans',sans-serif;
            background-color:rgb(252,253,254);
            border: solid 1px rgb(220,220,220);
            padding:20px;
            border-radius:20px;
            box-shadow: 1px 1px 1px 0px rgb(220,220,220);
        }
        #ldngpgregform h2 {
            font-size:22px;
            margin-bottom:5px;
        }
        #ldngpgregform h4 {
            font-size:18px;
            font-weight:200;
            color:#7B10DA;
            font-family: Serenity, sans-serif;
        }
        .hm-sel-txt{
            margin-top:30px;
            max-width:600px;
            width:90%;
            font-family: "Product Sans",sans-serif;
            font-weight: lighter;
            font-size:23px;
            line-height:1.4;
        }
        .lndpglgninptdv{
            padding-top:15px;
            display:flex;
            flex-direction:column;
        }
        #lndgsgnupbtn{
            width:100%;
            font-size:19px;
            padding:17px 0px;
        }
        .lndgpgsecheader{
            margin-top:30px;
            margin-left:20px;
            font-size:30px;
            font-family:'Montserrat','Open Sans',sans-serif;
            font-weight:lighter;
        }
        .lndgpgsecselhd{
            margin-left:30px;
        }
        .hm-reg-inpt{
            padding:3%;
            width:94%;
            max-width:450px;
            font-size:17px;
            font-weight:lighter;
            letter-spacing: 1.5px;
            color:rgb(60,60,60);
            border-radius:3px;
            border:solid 1px rgb(210,210,210);
            background-color:rgb(248,248,248);
        }
        .hm-reg-inpt:focus{
            background-color:white;
            border-color:#7B10DA;
            opacity:1;
        }
        .hm-reg-inpt:valid{
            background-color:white;
        }
        .hm-act-btns{
            width: 300px;
            padding:18px 40px;
            margin-top:15px;
            background-color: lightgray;
            border-radius:20px;
            border: solid 1px lightgray;
            font-family: "Product Sans",sans-serif;
            font-size:18px;
            cursor: pointer;
        }
        #hm-pas-lngth-req{
            color:rgb(250,50,100);
        }
        #hm-pas-ltr-req{
            color:rgb(250,50,100);
        }
        #hm-pas-num-req{
            color:rgb(250,50,100);
        }
    </style>
    <script type="application/javascript">

        var passInput = document.getElementById('password');
        var passHelp = document.getElementById('password-help');
        var passLenReq = document.getElementById('hm-pas-lngth-req');
        var passLtrReq = document.getElementById('hm-pas-ltr-req');
        var passNumReq = document.getElementById('hm-pas-num-req');

        var LtrLowRegEx = new RegExp(/[a-z]/);
        var LtrUprRegEx = new RegExp(/[A-Z]/);
        var NumRegEx = new RegExp(/[0-9]/);

        passInput.addEventListener("focus", function(){
            passHelp.style.display = "block";
        });

        passInput.addEventListener("blur", function(){
            passHelp.style.display = "none";
        });

        passInput.addEventListener("keyup", function(){
            var value = passInput.value;

            //CHECK PASSWORD LENGTH
            if(value.length < 10){
                passLenReq.style.color = "rgb(250,50,100)";
            }else{
                passLenReq.style.color = "rgb(20,220,20)";
            }
            //CHECK PASSWORD FOR UPPERCASE & Lowercase LETTERS
            if(!LtrLowRegEx.test(value) || !LtrUprRegEx.test(value)){
                passLtrReq.style.color = "rgb(250,50,100)";
            }else{
                passLtrReq.style.color = "rgb(20,220,20)";
            }
            //CHECK PASSWORD FOR NUMBER
            if(!NumRegEx.test(value)){
                passNumReq.style.color = "rgb(250,50,100)";
            }else{
                passNumReq.style.color = "rgb(20,220,20)";
            }
        });

    </script>
@endsection
