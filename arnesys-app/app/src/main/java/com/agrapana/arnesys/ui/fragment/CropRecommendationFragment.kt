package com.agrapana.arnesys.ui.fragment

import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import com.agrapana.arnesys.config.MQTT_HOST
import com.agrapana.arnesys.databinding.FragmentSeekCropRecommendationBinding
import com.agrapana.arnesys.helper.MqttClientHelper
import com.agrapana.arnesys.model.MonitoringAIProcessing
import com.agrapana.arnesys.model.MonitoringMainDevice
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.google.gson.Gson
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage

class CropRecommendationFragment(private var fieldId: String) : RoundedBottomSheetDialogFragment() {

    private lateinit var binding: FragmentSeekCropRecommendationBinding

    private val mqttClient by lazy {
        MqttClientHelper(requireContext())
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentSeekCropRecommendationBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)



//        binding.txtCrop.text = cropRecommendation
//
//        if(cropRecommendation == cropNow) {
//            binding.txtCropDetail.text = "Based on the dataset used, the results of AI processing indicate that this land is already suitable for $cropRecommendation"
//        } else {
//            binding.txtCropDetail.text = "Based on the dataset used, the results of AI processing indicate that this land is suitable for $cropRecommendation With the current land being used for $cropNow, further studies are needed regarding the suitability of this land for the type of crops to be planted"
//        }
    }

    private fun setMqttCallBack() {
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arnesys/$fieldId/utama")
                mqttClient.subscribe("arnesys/$fieldId/utama/ai")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                Log.w("mqttMessage", "Message received from host '$MQTT_HOST': $mqttMessage")
                if(topic == "arnesys/$fieldId/utama"){
                    val message = Gson().fromJson(mqttMessage.toString(), MonitoringMainDevice::class.java)
                    Log.d("/utama", message.toString())

                } else if(topic == "arnesys/$fieldId/pendukung/1"){
                    val message = Gson().fromJson(mqttMessage.toString(), MonitoringMainDevice::class.java)
                    Log.d("/pendukung", message.toString())

                }
            }
            override fun deliveryComplete(iMqttDeliveryToken: IMqttDeliveryToken) {
                Log.w("Debug", "Message published to host '$MQTT_HOST'")
            }
        })
    }

}