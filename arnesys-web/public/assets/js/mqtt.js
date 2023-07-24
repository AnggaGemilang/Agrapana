var connected_flag = 0
var mqtt
var reconnectTimeout = 2000
var host="test.mosquitto.org"
var port=8080
var sub_topic="arnesys/#"
var userId = ""
var passwordId = ""

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
