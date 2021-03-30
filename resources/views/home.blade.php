@extends('layouts.home')

@section('content')

    <section class="container" style="margin-top: 70px;">
        <div id="landingheader">
            <div class="ldngheadsec">
                <h1 id='lndgpgwebname'>workcloud</h1>
                <p id="lndgpgheadp">everything work.</p>
            </div>
            <div class="ldngheadsec">

                @guest
                    <form id="ldngpgregform" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2 style="font-family: 'Product Sans';">Create Your Account</h2>
                        <h4>join free today.</h4>
                        <div class="lndpglgninptdv">
                            <label class="lrg-inpt-lbl">Full name*</label>
                            <input id="name" name="name" class="hm-reg-inpt" type="text" autocomplete="off"  required/>
                            @error('name')
                            <strong><p class="invalid-feedback">{{ $message }}</p></strong>
                            @enderror
                        </div>
                        <div class="lndpglgninptdv">
                            <label class="lrg-inpt-lbl">Job Title*</label>
                            <input id="job" name="job_title" class="hm-reg-inpt" type="text" autocomplete="off"  required/>
                            @error('job_title')
                            <strong><p class="invalid-feedback">{{ $message }}</p></strong>
                            @enderror
                        </div>
                        <div class="lndpglgninptdv">
                            <label class="lrg-inpt-lbl">Email*</label>
                            <input id="email" name="email" class="hm-reg-inpt" type="email" autocomplete="off" required/>
                            @error('email')
                            <strong><p class="invalid-feedback">{{ $message }}</p></strong>
                            @enderror
                        </div>
                        <div class="lndpglgninptdv">
                            <label class="lrg-inpt-lbl">Password*</label>
                            <input id="password" name="password" type="password" class="hm-reg-inpt" autocomplete="off" required/>
                            @error('password')
                            <strong><p class="invalid-feedback">{{ $message }}</p></strong>
                            @enderror
                        </div>
                        <div class="lndpglgninptdv">
                            <button id="lndgsgnupbtn" class="whitebtn">Sign Up</button>
                            <p style="font-size:10px;margin-top:20px;">By clicking Sign Up, you agree to our <a href="/terms">Terms</a>. Learn how we collect, use and share your data in our Data Policy and how we use cookies and similar technology in our Cookie Policy. You may receive SMS notifications from us and can opt out at any time.</p>
                        </div>
                    </form>
                @endguest

            </div>
        </div>
        <div class="lndgpgesecdv">
            <h2 class="lndgpgsecheader">Business Account</h2>
            <p class="lndgpgsecselhd">Work Management</p>
            <div id="ldngpgsitebuscntsell" class="ldngpgsitecntsell">
                <div class="webfuncselldv" style="border-color:#0D9BB4;">Workflow</div>
                <div class="webfuncselldv">CRM</div>
                <div class="webfuncselldv">Recruitment</div>
                <div class="webfuncselldv">Tasks</div>
                <div class="webfuncselldv">Messenger</div>
                <div class="webfuncselldv">Projects</div>
                <div class="webfuncselldv">Scheduling</div>
                <div class="webfuncselldv">Compliance</div>
                <input id="selfuncbusvalinpt" type="hidden" value="0"/>
            </div>
        </div>
        <div class="lndgpgesecdv">
            <h2 class="lndgpgsecheader">User Account</h2>
            <p class="lndgpgsecselhd">Career Development</p>
            <div id="ldngpgsiteusrcntsell" class="ldngpgsitecntsell">
                <div class="webfuncselldv" style="border-color:#0D9BB4;">Job Search</div>
                <div class="webfuncselldv">Freelance</div>
                <div class="webfuncselldv">Contracting</div>
                <div class="webfuncselldv">Network</div>
                <div class="webfuncselldv">Projects</div>
                <input id="selfuncusrvalinpt" type="hidden" value="0"/>
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
            min-height:550px;
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
            color:#1770E2;
            letter-spacing:7px;
        }
        #lndgpgheadp{
            margin-top:16px;
            width:95%;
            max-width:600px;
            font-size:43px;
            color:rgb(80, 80, 80);
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
            border-radius:20px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items: center;
            margin:20px;
            overflow:hidden;
            font-size:15px;
            font-weight:bolder;
            color:#1770E2;
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
            margin-top:30px;
            font-family:'Open Sans';
        }
        #ldngpgregform h2 {
            font-size:30px;
            margin-bottom:10px;
        }
        #ldngpgregform h4 {
            font-size:18px;
            font-weight:200;
        }
        .lndpglgninptdv{
            padding-top:20px;
            display:flex;
            flex-direction:column;
        }
        #lndgsgnupbtn{
            width:100%;
            max-width:470px;
            font-size:19px;
            padding:14px 0px;
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
            padding:2%;
            width:96%;
            max-width:450px;
            font-size:17px;
            font-weight:lighter;
            letter-spacing: 1.5px;
            color:rgb(60,60,60);
            border-radius:1px;
            border:solid 1px rgb(210,210,210);
            background-color:white;
        }
        .hm-reg-inpt:focus{
            border-color:#1770E2;
            opacity:1;
        }
        .hm-reg-inpt:valid{
            background-color:white;
            border-color:#1770E2;
        }
    </style>
    <script type="text/javascript">

        var highlightInterval = window.setInterval(siteFunctionalityHighlight, 1500);

        var regform = document.getElementById('ldngpgregform');
        var regformbtn = document.getElementById('lndgsgnupbtn');
        regform.addEventListener("submit", function(){
            regformbtn.disabled = true;
        });

        function siteFunctionalityHighlight(){
            var myNodeList = document.getElementById('ldngpgsitebuscntsell').querySelectorAll('div');
            let funcboxindx = document.getElementById('selfuncbusvalinpt').value;
            funcboxindx = Number.parseInt(funcboxindx);
            myNodeList[funcboxindx].style.borderColor = 'lightgray';

            if(funcboxindx == 7){
                funcboxindx = -1;
            }

            funcboxindx = funcboxindx + 1;
            myNodeList[funcboxindx].style.borderColor = '#0D9BB4';
            document.getElementById('selfuncbusvalinpt').value = funcboxindx;
        }

        function hightlightHoverOn(){
            clearInterval(highlightInterval);

            let children_el = document.getElementById('ldngpgsitebuscntsell').childNodes;

            children_el.forEach(function(element){
                if(element.nodeName == "DIV"){
                    element.style.borderColor = 'lightgray';
                }
            });

            event.target.style.borderColor = '#0D9BB4';

            function whichChild(elem){
                var  i = 0;
                while((elem=elem.previousElementSibling)!=null) ++i;
                return i;
            }

            let el_index = whichChild(event.srcElement);
            document.getElementById('selfuncbusvalinpt').value = el_index;
        }

        function hightlightHoverOff(){
            highlightInterval = window.setInterval(siteFunctionalityHighlight, 1500);
        }

        var highlightBtns = document.getElementsByClassName('webfuncselldv');
        Array.from(highlightBtns).forEach(function(input) {
            input.addEventListener('mouseover', hightlightHoverOn);
            input.addEventListener('mouseout', hightlightHoverOff);
        });

    </script>
@endsection
