@extends('layouts.master')

@section('title','Dashboard')

@section('breadcrumb-content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
            Dashboard
        </li>
    </ol>
    <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
</nav>

@endsection

@section('content')

<div class="row">
    <div class="col-12 not-found2">
        <p>Data Not Found</p>
    </div>
</div>
<div class="row content-wrapper">
    <div class="col-xl-4 col-sm-6" style="min-height: max-content;">
        <div class="card" style="height: 100%;">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-6" style="padding-right: 0px !important;">
                        <div class="numbers" style="min-height: 93px;">
                            <p class="mb-0 text-capitalize font-weight-bold" style="font-size: 13pt;">Planting Description</p>
                            <img src="{{ asset('assets') }}/img/spinach.png" alt="" style="margin-top: 9px; width: 155px;">
                        </div>
                    </div>
                    <div class="col-6 text-end" style="padding-left: 0px !important;">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="ni ni-bell-55 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <p class="mb-0 text-capitalize" style="margin-top: 48px; font-size: 11pt;">Plant Name</p>
                        <h4 id="txtPlantName" class="mb-0 text-capitalize font-weight-bolder" style="font-size: 14pt;">Spinach</h4>
                        <p class="mb-0 text-capitalize" style="font-size: 11pt; margin-top: 15px;">Started Planting</p>
                        <h4 id="txtStartedPlant" class="mb-0 text-capitalize font-weight-bolder" style="font-size: 14pt;">5 Apr 23 13:00</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-sm-10">
        <div class="row">
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Temperature <br> Value</p>
                                    <h4 id="txtTemperature" class="font-weight-bolder mt-2">
                                        25&deg;
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-success text-center rounded-circle">
                                    <i class="ni ni-bulb-61 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Ph Meter <br> Value</p>
                                    <h4 id="txtPh" class="font-weight-bolder mt-2">
                                        7 Ph
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-success text-center rounded-circle">
                                    <i class="ni ni-folder-17 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Gas CO2 <br> Value</p>
                                    <h4 id="txtGas" class="font-weight-bolder mt-2">
                                        620 PPM
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-success text-center rounded-circle">
                                    <i class="ni ni-support-16 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Nutrition <br> Value</p>
                                    <h4 id="txtNutrition" class="font-weight-bolder mt-2">
                                        678 PPM
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-success text-center rounded-circle">
                                    <i class="ni ni-square-pin text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Volume <br> Value</p>
                                    <h4 id="txtVolume" class="font-weight-bolder mt-2">
                                        60 %
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers" style="min-height: 93px;">
                                    <p class="text-md mb-0 text-capitalize font-weight-bold">Growth Lamp <br> Status</p>
                                    <h4 id="txtLamp" class="font-weight-bolder mt-2">
                                        On
                                    </h4>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-success text-center rounded-circle">
                                    <i class="ni ni-istanbul text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row content-wrapper mt-4">
    <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">The Number of Leaves</h6>
                <p class="text-md mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">2.3% more</span> long growth
                </p>
            </div>
            <div class="card-body p-3">
                <div class="box">
                    <canvas id="numberOfLeaves"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-carousel overflow-hidden h-100 p-0">
            <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                <div class="carousel-inner border-radius-lg h-100">
                    <div class="carousel-item h-100 active"
                        style="background-image: url('{{ asset('assets') }}/img/carousel-1.jpg'); background-size: cover;">
                        <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                            <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                <i class="ni ni-camera-compact text-dark opacity-10"></i>
                            </div>
                            <h5 class="text-white mb-1">Get started with Irosysco Web</h5>
                            <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                        </div>
                    </div>
                    <div class="carousel-item h-100" style="background-image: url('{{ asset('assets') }}/img/carousel-2.jpg');
                        background-size: cover;">
                        <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                            <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                            </div>
                            <h5 class="text-white mb-1">Faster way to create web pages</h5>
                            <p>That’s my skill. I’m not really specifically talented at anything except for
                                the ability to learn.</p>
                        </div>
                    </div>
                    <div class="carousel-item h-100" style="background-image: url('{{ asset('assets') }}/img/carousel-3.jpg'); background-size: cover;">
                        <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                            <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                <i class="ni ni-trophy text-dark opacity-10"></i>
                            </div>
                            <h5 class="text-white mb-1">Share with us your design tips!</h5>
                            <p>Don’t be afraid to be wrong because you can’t learn anything from a
                                compliment.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        MQTTconnect()
    })

    var connected_flag = 0
	var mqtt
    var reconnectTimeout = 2000
	var host="test.mosquitto.org"
	var port=8080
    var sub_topic="arceniter/#"
    var userId = "TvfNFPgb38"
    var passwordId = "z7G9v8tTGQ"

    function onConnectionLost(){
        console.log("connection lost")
        connected_flag = 0
	}

    function onFailure(message) {
		console.log("Failed")
        setTimeout(MQTTconnect, reconnectTimeout)
    }

    function onMessageArrived(r_message){
		//console.log("Message received ",r_message.payloadString)

        out_msg = "Message received "+ r_message.payloadString + "<br>"
		out_msg=out_msg+"Message received Topic "+r_message.destinationName
		// console.log(out_msg)

        var topic = r_message.destinationName

        console.log(topic)

        if(topic=="arceniter/monitoring"){
            var data = JSON.parse(r_message.payloadString)
            console.log(data)
            $("#txtTemperature").text(data.temperature + '\u00B0')
            $("#txtPh").text(data.ph + " Ph")
            $("#txtGas").text(data.gas + " PPM")
            $("#txtNutrition").text(data.nutrition + " PPM")
            $("#txtVolume").text(data.nutrition_volume + "%")
		}
		if(topic=="arceniter/common"){
            var data = JSON.parse(r_message.payloadString)
            console.log(data)
            $("#txtPlantName").text(data.plant_name.split('#')[0])
            let custom = data.started_planting.split(',')[0] + ", " + data.started_planting.split(',')[1]
            $("#txtStartedPlant").text(custom)
            if(data.is_planting == "no"){
                $(".not-found2").css('display', 'flex')
                $(".content-wrapper").css('display', 'none')
            } else {
                $(".not-found2").css('display', 'hidden')
                $(".content-wrapper").css('display', 'flex')
            }
        }
	}

    function onConnected(recon,url){
	    console.log(" in onConnected " + reconn)
	}

	function onConnect() {
	    connected_flag = 1
        console.log("on Connect "+connected_flag)
        mqtt.subscribe(sub_topic)
	  }

    function MQTTconnect() {
        console.log("connecting to "+ host +":"+ port)
        var x = Math.floor(Math.random() * 10000)
        var cname = "controlform-" + x
        mqtt = new Paho.MQTT.Client(host,port,cname)
        mqtt.onConnectionLost = onConnectionLost
        mqtt.onMessageArrived = onMessageArrived
        mqtt.connect({
            timeout: 3,
            onSuccess: onConnect,
            onFailure: onFailure
        })
        return false
	}

    function sub_topics(){
		document.getElementById("messages").innerHTML =""
		if (connected_flag==0){
            out_msg = "<b>Not Connected so can't subscribe</b>"
            console.log(out_msg)
            return false
		}

        var stopic= document.forms["subs"]["Stopic"].value
        console.log("Subscribing to topic ="+stopic)
        mqtt.subscribe(stopic)
        return false
	}

    function send_message(msg,topic){
		if (connected_flag==0){
            out_msg="<b>Not Connected so can't send</b>"
            console.log(out_msg)
            document.getElementById("messages").innerHTML = out_msg
    		return false
		}

        var value=msg.value
		console.log("value= "+value)
		console.log("topic= "+topic)
		message = new Paho.MQTT.Message(value)
		message.destinationName = "house/"+topic

		mqtt.send(message)
		return false
	}

    var ctx = document.getElementById("numberOfLeaves")
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['1/3/2023', '1/10/2023', '1/17/2023', '1/24/2023'],
            datasets: [
                {
                    label: 'Number of Leaves',
                    data: [3, 5, 7, 10],
                    backgroundColor: [
                        '#66BB6A',
                    ],
                    borderColor: [
                        '#66BB6A',
                    ],
                    borderWidth: 1
                }
            ]
        },
    })

</script>
@endpush
