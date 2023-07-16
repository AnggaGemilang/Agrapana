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

<div class="row content-wrapper mt-3">
    <div class="col-xl-12 col-sm-12">
        <div class="row">

            @hasrole('Operator')

                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers" style="min-height: 93px;">
                                        <p class="text-md mb-0 text-capitalize font-weight-bold">Today <br> Value</p>
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

            @endhasrole

            @hasrole('Client')

                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers" style="min-height: 93px;">
                                        <p class="text-md mb-0 text-capitalize font-weight-bold">Temperature2 <br> Value</p>
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

            @endhasrole

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
