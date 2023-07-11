<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="" />
    <title>Guest Book - Agrapana</title>
    <link rel="preload" as="image" href="{{ asset('assets')}}/presence-page/images/1.jpg">
    <link rel="preload" as="image" href="{{ asset('assets')}}/presence-page/images/2.jpg">
    <link rel="preload" as="image" href="{{ asset('assets')}}/presence-page/images/3.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/images/logo/favicon.png">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/presence-page/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/presence-page/css/responsive.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/presence-page/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

    <style>

    </style>

</head>

<body>
    <div class="hero_area">
        <header class="header_section">
            <nav class="navbar navbar-expand-lg custom_nav-container pt-5 navbar-fixed-top">
                <div class="container d-flex justify-content-center">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset("assets") }}/presence-page/images/logo.png" style="width: 150px;" alt="">
                    </a>
                </div>
            </nav>
        </header>
        <section class="slider_section" style="margin-top: -20px;">
            <div class="container" style="margin-top: -25px;">
                <div class="row">
                    <div class="col-md-12" style="position: relative;">
                        <form id="regForm" action="" method="POST">
                            <div class="tab">
                                <p style="font-size: 55pt;" class="title">Enter Your Presences</p>
                                <p style="font-size: 15pt; color: white; text-align: center;">Thank You For Coming To
                                    Our Booth</p>
                                <div style="display: flex; margin-top: 15px; justify-content: center;">
                                    <button type="button" class="btn mt-2 btn-get-started" id="btn-get-started" style="background: #8CC447; color: white; width: 250px;">
                                        Click Here To Get Started
                                    </button>
                                </div>
                                <small
                                    style="display: flex; margin-top: 15px; justify-content: center; color: white;"><i
                                        class="bi bi-clock-fill pr-2" style="padding-top: 0.5px;"></i> Takes Less Than 1
                                    Minute
                                </small>
                            </div>

                            <div class="tab">
                                <div class="form-group">
                                    <label for="full_name">a. Full Name</label>
                                    <input type="text" name="full_name" placeholder="Type our first name here..." autocomplete="off" id="fullName">
                                    <small class="required-element">Required</small>
                                </div>
                                <div class="btn-ok-wrapper d-flex">
                                    <button type="button" class="btn btn-ok" id="btnOK">
                                        OK <i class="bi bi-check"></i>
                                    </button>
                                    <small>
                                        press Enter <i class="bi bi-unindent"></i>
                                    </small>
                                </div>
                            </div>

                            <div class="tab">
                                <div class="form-group">
                                    <label for="nationality">b. Nationality</label>
                                    <select name="nationality" id="nationality">
                                        <option value="">Choose Nationality</option>
                                    </select>
                                    <small class="required-element">Required</small>
                                </div>
                                <div class="btn-ok-wrapper d-flex">
                                    <button type="button" class="btn btn-ok" id="btnOK">
                                        OK <i class="bi bi-check"></i>
                                    </button>
                                    <small>
                                        press Enter <i class="bi bi-unindent"></i>
                                    </small>
                                </div>
                            </div>

                            <div class="tab">
                                <div class="form-group">
                                    <label for="opinion">c. Any Opinion?</label><br>
                                    <textarea type="text" name="opinion" placeholder="Type our opinion here..." id="opinion" rows="5"></textarea>
                                    <small class="required-element">Required</small>
                                </div>
                                <div class="btn-ok-wrapper d-flex">
                                    <button type="button" class="btn btn-ok" id="btnOK">
                                        OK <i class="bi bi-check"></i>
                                    </button>
                                    <small>
                                        press Enter <i class="bi bi-unindent"></i>
                                    </small>
                                </div>
                            </div>

                            <div class="row tab">
                                <div class="col-md-12" style="display: flex; justify-content: center;">
                                    <div class="signature-wrapper" style="width: 55%;">
                                        <div class="form-group">
                                            <label for="signature" style="width: 100%">c. Signature</label>
                                            <canvas id="signature-pad" class="signature-pad" style="border: 1px solid #AAB7A6;margin-left: 22px !important;"></canvas>
                                        </div>
                                        <div class="btn-ok-wrapper d-flex">
                                            <button type="button" class="btn btn-clear" id="clear">
                                                Clear <i class="bi bi-x"></i>
                                            </button>
                                            <button type="button" class="btn btn-ok btn-submit" style="margin-left: 8px;" id="btnOK">
                                                OK <i class="bi bi-check"></i>
                                            </button>
                                            <small>
                                                press Enter <i class="bi bi-unindent"></i>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab">
                                <div style="text-align: center;">
                                    <i class="bi bi-check2-circle" style="font-size: 90pt; color: white;"></i>
                                    <h3 style="color: white; margin-top: -10px;">Thank You For Your Participation!</h3>
                                    <p class="text-countdown" style="margin-top: 5px; color: white; font-size: 15pt;">System Will Redirect You In 5...</p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div id="btn-control-wrapper" style="position: absolute; bottom: 20px; right: 225px; display: none;">
                <div style="float:right;">
                    <button class="btn btn-control" style="border-top-left-radius: 5px !important; border-bottom-left-radius: 5px !important; border-top-right-radius: 0px !important; border-bottom-right-radius: 0px !important; height: 36px; background:#8CC447; color: black;" type="button"
                        id="prevBtn">
                        <i class="bi bi-chevron-up" style="color: white;"></i>
                    </button>
                    <button class="btn btn-control" style="border-top-right-radius: 5px !important; border-bottom-right-radius: 5px !important; border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important; height: 36px; background:#8CC447; color: black; margin-left: -5px; color: white;"
                        type="button" id="nextBtn">
                        <i class="bi bi-chevron-down" style="color: white;"></i>
                    </button>
                </div>
            </div>
            <div id="brand-wrapper" style="display: none; position: absolute; bottom: 20px; right: 20px; background: #8CC447; border-radius: 5px;">
                <p style="color: white; font-size: 11pt; padding: 6px 20px; padding-bottom: 8px;">Powered By <b>Agrapana</b></p>
            </div>
        </section>
    </div>

    <script type="text/javascript" src="{{ asset('assets') }}/presence-page/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/presence-page/js/bootstrap.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/presence-page/extensions/jquery/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

    <script>

        var signaturePad = null

        $(document).ready(function() {

            $('#nationality').select2();

            var canvas = document.getElementById('signature-pad')
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'transparent'
            });

            $('#clear').on('click', function(){
                signaturePad.clear();
            });

            getCountryData()
            changeBackground()
        })

        function changeBackground() {
            let kodeGambar = Math.floor((Math.random() * 3) + 1)
            $(".hero_area").css("background-image", "linear-gradient(rgba(122, 136, 119, 0.9), rgba(0, 0, 0, 0.6)), url('assets/presence-page/images/" + kodeGambar + ".jpg')")
        }

        function getCountryData() {
            $.ajax({
                url: '{{ route("presence.get.country") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                success: function (data) {
                    $("#nationality").children().remove()
                    $("#nationality").append($('<option value="">').text("Choose Nationality"))
                    $.each(data, function (key, value) {
                        $("#nationality")
                            .append($('<option value="' + value.id + '">').text(value.nicename))
                    })
                },
                error: function (data) {
                    $("#nationality").children().remove()
                    $("#nationality").append($('<option>').text("Choose Nationality"))
                },
            })
        }

        var currentTab = 0
        showTab(currentTab)

        function showTab(n) {
            var x = document.getElementsByClassName("tab")
            x[n].style.display = "block"
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none"
            } else {
                document.getElementById("prevBtn").style.display = "inline"
            }
            if (n == (x.length - 2)) {
                document.getElementById("nextBtn").innerHTML = "Submit"
            } else {
                document.getElementById("nextBtn").innerHTML = "<i class='bi bi-chevron-down' style='color: white;'></i>"
            }
        }

        $("textarea").focus(function (){
            var sibling = document.getElementsByClassName("required-element")
            for(var i = 0; i < sibling.length; i++){
                sibling[i].style.display = "none"
            }
        })

        $("input").focus(function (){
            var sibling = document.getElementsByClassName("required-element")
            for(var i = 0; i < sibling.length; i++){
                sibling[i].style.display = "none"
            }
        })

        $("select").change(function (){
            var sibling = document.getElementsByClassName("required-element")
            for(var i = 0; i < sibling.length; i++){
                sibling[i].style.display = "none"
            }
        })

        $("#nextBtn").click(function (e) {
            e.preventDefault()
            changeQuestion(1)
        })

        $("#btn-get-started").click(function () {
            changeQuestion(1)
        })

        $("#prevBtn").click(function () {
            changeQuestion(-1)
        })

        $(document).keypress(function (e) {
            var key = e.which
            if(key == 13){
                e.preventDefault()
                if(currentTab > 0){
                    changeQuestion(1)
                }
            }
        })

        $(".btn-ok").on("click", function (e) {
            e.preventDefault()
            changeQuestion(1)
        })

        function blockSmall() {
            var sibling = document.getElementsByClassName("required-element")
            for(var i = 0; i < sibling.length; i++){
                sibling[i].style.display = "block"
            }
        }

        function changeQuestion(n) {
            var x = document.getElementsByClassName("tab")

            if(n > 0){
                if(currentTab == 1){
                    if($("input").val() == ""){
                        blockSmall()
                        return false
                    }
                } else if(currentTab == 2){
                    if($("select").val() == ""){
                        blockSmall()
                        return false
                    }
                } else if(currentTab == 3){
                    if($("textarea").val() == ""){
                        blockSmall()
                        return false
                    }
                }
            }

            x[currentTab].style.display = "none"
            currentTab = currentTab + n

            if (currentTab == 0){
                $("#btn-control-wrapper").hide()
                $("#brand-wrapper").hide()
            } else {
                $("#btn-control-wrapper").show()
                $("#brand-wrapper").show()
            }

            if (currentTab >= (x.length-1)) {

                console.log(signaturePad.toDataURL('image/png'))

                let datas = {
                    full_name: $("#fullName").val(),
                    nationality: $("#nationality").val(),
                    signature: signaturePad.toDataURL('image/png'),
                    opinion: $("#opinion").val()
                }

                $.ajax({
                    url: '{{ route("presence.post") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        presenceData: datas
                    },
                    success: function (data) {
                        $("input").val("")
                        $("select").val("").change()
                        $("textarea").val("")
                        signaturePad.clear()
                    },
                })

                showTab(currentTab++)

                var counter = 5;
                $(".text-countdown").text(`System Will Redirect You In 5...`)
                var interval = setInterval(function() {
                    counter--;
                    $(".text-countdown").text(`System Will Redirect You In ${counter}...`)
                    if (counter == 0) {
                        clearInterval(interval);
                        x[5].style.display = "none"
                        currentTab = 0
                        showTab(currentTab)
                    }
                }, 1000);

                $("#btn-control-wrapper").hide()
                $("#brand-wrapper").hide()
            }
            showTab(currentTab)
        }

    </script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

</body>

</html>
