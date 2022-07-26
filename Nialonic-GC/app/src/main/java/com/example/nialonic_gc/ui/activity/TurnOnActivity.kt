package com.example.nialonic_gc.ui.activity

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import com.example.nialonic_gc.config.MQTT_HOST
import com.example.nialonic_gc.databinding.ActivityTurnOnBinding
import com.example.nialonic_gc.helper.MqttClientHelper
import com.example.nialonic_gc.helper.MqttClientHelper.Companion.TAG
import com.example.nialonic_gc.model.Common
import com.example.nialonic_gc.model.Monitoring
import com.google.firebase.database.core.Tag
import com.google.gson.Gson
import com.ncorti.slidetoact.SlideToActView
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage

class TurnOnActivity : AppCompatActivity() {

    private lateinit var binding: ActivityTurnOnBinding
    private var commonMsg = Common()

    private val mqttClient by lazy {
        MqttClientHelper(this)
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityTurnOnBinding.inflate(layoutInflater)
        setContentView(binding.root)

        binding.slider.onSlideCompleteListener = object : SlideToActView.OnSlideCompleteListener{
            override fun onSlideComplete(view: SlideToActView) {
                Log.d(TAG, commonMsg.toString())
                setMqttCallBack()
            }
        }
    }

    private fun setMqttCallBack() {
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arceniter/common")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                Log.w(TAG, "Message received from host '$MQTT_HOST': $mqttMessage")
                if(topic == "arceniter/common"){
                    commonMsg = Gson().fromJson(mqttMessage.toString(), Common::class.java)
                    commonMsg.power = "on"
                    mqttClient.publish("arceniter/common", Gson().toJson(commonMsg))
                    mqttClient.destroy()
                    startActivity(Intent(this@TurnOnActivity, MainActivity::class.java))
                }
            }
            override fun deliveryComplete(iMqttDeliveryToken: IMqttDeliveryToken) {
                Log.w("Debug", "Message published to host '$MQTT_HOST'")
            }
        })
    }

}