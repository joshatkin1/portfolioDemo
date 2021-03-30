@extends('layouts.main')

@section('content')
    <?php $email = Cookie::get('email'); ?>
    <div class="container">
        <div id="loginpagecnt">
            <a href="{{ route('password.request') }}"><h1 id="lgnpghdr">workcloud</h1></a>
            <p id="sgninp">Sign in to workcloud</p>
            <form id="sgninform" method="POST" action="{{ route('login') }}" enctype="application/x-www-form-urlencoded" class="loginform">
                @csrf
                <div class="lgnfrminptsec">
                    <p class="lrg-inpt-lbl">Email address</p>
                    <input id="email" class="lrg-inpt" name="email" type="email" autocomplete="off" value="<?php echo $email = (isset($email)? $email : '');?>" placeholder="email"/>
                    @error('email')
                    <span class="invalid-login-feedback" role="alert">
                    {{ $message }}
            </span>
                    @enderror
                </div>
                <div class="lgnfrminptsec">
                    <div id="passlblsec">
                        <p>Password</p>
                        <a href="/password/reset">forgot password?</a>
                    </div>
                    <input id="password" class="lrg-inpt" name="password" type="password" autocomplete="off" placeholder="******"/>
                    @error('password')
                    <span class="invalid-login-feedback" role="alert">
                    {{ $message }}
                 </span>
                    @enderror
                </div>
                <button id="sgninbtn" name="submit" type="submit">Sign in</button>
            </form>
            <a href="/"  class="loginform create-acnt-btn">
                <p class="lgnsecadhds">New to workcloud?</p>
                <p class="lgnseclnks">Create Account</p>
            </a>
            <div id="lgnlnksec">
                <a href="policyterms" class="lngpglnkhrfs">Terms</a>
                <a href="policyterms" class="lngpglnkhrfs">Privacy</a>
                <a href="policyterms" class="lngpglnkhrfs">Security</a>
                <a href="policyterms" class="lngpglnkhrfs">Contact</a>
            </div>
        </div>
    </div>
    <style type="text/css" charset="utf-8">
        #loginpagecnt{
            width:98%;
            padding:1%;
            display:flex;
            flex-direction: column;
            align-items: center;
        }
        #lgnpghdr{
            margin-top:35px;
            font-size:28px;
            color:#1770E2;
            font-family:'Comfortaa',sans-serif;
            letter-spacing:3px;
            text-decoration:none;
        }
        #sgninp{
            margin-top:30px;
            font-size:22px;
            font-family:"Lato", sans-serif;
            font-weight: 400;
            color:rgb(90,90,90);
            letter-spacing:0.5px;
        }
        #sgninform{
            background-color:white;
            border:solid 1px #EAEAEA;
            border-radius:5px;
            margin-top:30px;
            padding:30px 20px;
        }
        .loginform{
            margin-top:15px;
            width:96%;
            padding:1%;
            max-width:300px;
            color:rgb(120,120,125);
        }
        .lgnfrminptsec{
            margin-bottom:15px;
        }

        .lgnsecadhds{
            font-size:14px;
            font-family:'Lato',sans-serif;
            letter-spacing:1px;
            font-weight:normal;
            color:rgb(80,80,90);
        }
        .lgnseclnks{
            font-size:13px;
            font-family:'Lato',sans-serif;
            letter-spacing:1px;
            font-weight:normal;
            color:#0087FF;
        }
        #lgnlnksec{
            margin-top:30px;
            width:100%;
            max-width:300px;
            display: flex;
            flex-direction: row;
            align-content: stretch;
            justify-content:space-between;
        }
        .lngpglnkhrfs{
            font-size:11px;
            color: #1770E2;
        }
        .lngpglnkhrfs:hover{
            text-decoration: underline;
        }
        #sgninbtn{
            margin-top:15px;
            width:100%;
            font-size:19px;
            padding: 8px 0px;
            background-color: #2BA222;
            border:solid 1px #248C1C;
            border-radius:10px;
            color:white;
            font-family: "Lato", sans-serif;
        }
        #sgninbtn:hover{
            background-color: #21861A;
        }
        #passlblsec{
            display:flex;
            flex-direction: row;
            justify-content:space-evenly;
        }
        #passlblsec > p , #passlblsec > a{
            width:50%;
            text-align: left;
            font-family: 'Lato', sans-serif;
            font-weight: 500;
            color:rgb(70,70,70);
            font-size:15px;
            padding-bottom:5px;
            letter-spacing:1px;
        }
        #passlblsec > a{
            text-align: right;
        }
        #passlblsec > a:hover{
            color:#0087FF;
        }
        .invalid-login-feedback{
            color:darkred;
            font-size:13px;
            position: absolute;
            margin-top: 3px;
            font-weight:300;
            font-family: sans-serif;
        }
        .create-acnt-btn{
            display:flex;
            flex-direction: row;
            justify-content: space-evenly;
            background-color:white;
            border:solid 1px #EAEAEA;
            border-radius:5px;
            margin-top:30px;
            padding:15px 20px;
        }
    </style>
    <script type="application/javascript" charset="UTF-8">
        var sgninform = document.getElementById('sgninform');
        var sgninbtn = document.getElementById('sgninbtn');
        sgninform.addEventListener("submit", function(){
            sgninbtn.disabled = true;
        });
    </script>
@endsection
