package com.example.nialonic_gc.ui.fragment

import android.content.Intent
import android.os.Build
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.Fragment
import com.bumptech.glide.Glide
import com.example.nialonic_gc.*
import com.example.nialonic_gc.config.MQTT_HOST
import com.example.nialonic_gc.helper.MqttClientHelper
import com.example.nialonic_gc.databinding.FragmentHomeBinding
import com.example.nialonic_gc.model.Common
import com.example.nialonic_gc.model.Monitoring
import com.example.nialonic_gc.model.Thumbnail
import com.example.nialonic_gc.ui.activity.DetailActivity
import com.example.nialonic_gc.ui.activity.SettingActivity
import com.example.nialonic_gc.ui.activity.TurnOnActivity
import com.google.gson.Gson
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage
import java.time.LocalDate
import java.time.format.DateTimeFormatter

class HomeFragment : Fragment() {

    private lateinit var binding: FragmentHomeBinding
    private var commonMsg = Common()

    private val mqttClient by lazy {
        MqttClientHelper(requireContext())
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentHomeBinding.inflate(inflater, container, false)
        return binding.root
    }

    @RequiresApi(Build.VERSION_CODES.O)
    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        binding.toolbar.inflateMenu(R.menu.action_nav3)
        binding.toolbar.setOnMenuItemClickListener {
            when(it.itemId) {
                R.id.power -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("This can be perform the machine")
                    builder.setPositiveButton("YES") { _, _ ->
                        commonMsg.power = "off"
                        mqttClient.publish("arceniter/common", Gson().toJson(commonMsg))
                        startActivity(Intent(context, TurnOnActivity::class.java))
                    }
                    builder.setNegativeButton("NO") { dialog, _ ->
                        dialog.dismiss()
                    }
                    val alert = builder.create()
                    alert.show()
                }
                R.id.detail -> {
                    startActivity(Intent(requireContext(), DetailActivity::class.java))
                }
                R.id.about -> {
                    AlertDialog.Builder(requireContext())
                        .setTitle("App Version")
                        .setMessage("Beta 1.0.0")
                        .setCancelable(true)
                        .setPositiveButton("OK", null)
                        .create()
                        .show()
                }
                R.id.setting -> {
                    startActivity(Intent(context, SettingActivity::class.java))
                }
            }
            true
        }
        binding.no1.setOnLongClickListener {
            activity?.let { it1 -> SeekPlantFragment().show(it1.supportFragmentManager, "BottomSheetDialog") }
            false
        }
        val dtf = DateTimeFormatter.ofPattern("dd MMM")
        val localDate = LocalDate.now()
        binding.txtTanggalHome.text = dtf.format(localDate)
        setMqttCallBack()
    }

    private fun setMqttCallBack() {
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arceniter/common")
                mqttClient.subscribe("arceniter/monitoring")
                mqttClient.subscribe("arceniter/thumbnail")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                Log.w("Debug", "Message received from host '$MQTT_HOST': $mqttMessage")
                if(topic == "arceniter/common"){
                    val common = Gson().fromJson(mqttMessage.toString(), Common::class.java)
                    commonMsg = Gson().fromJson(mqttMessage.toString(), Common::class.java)
                    binding.plantName.text = common.plant_name.capitalize()
                    binding.startedPlanting.text = common.started_planting
                    if(common.is_planting == "no"){
                        binding.toolbar.menu.getItem(1).isVisible = false
                        binding.keteranganTidakAda.visibility = View.VISIBLE
                        binding.keteranganAda.visibility = View.GONE
                    } else {
                        binding.toolbar.menu.getItem(1).isVisible = true
                        binding.keteranganTidakAda.visibility = View.GONE
                        binding.keteranganAda.visibility = View.VISIBLE
                    }
                } else if (topic == "arceniter/monitoring"){
                    val monitoring = Gson().fromJson(mqttMessage.toString(), Monitoring::class.java)
                    binding.valTemperature.text = monitoring.temperature.toString() + "°C"
                    binding.valPh.text = monitoring.ph + " Ph"
                    binding.valGas.text = monitoring.gas.toString() + " ppm`"
                    binding.valNutrition.text = monitoring.nutrition.toString() + " ppm"
                    binding.valNutritionVolume.text = monitoring.nutrition_volume.toString() + " ml"
                    binding.valGrowthLamp.text = monitoring.growth_lamp.capitalize()
                } else if (topic == "arceniter/thumbnail"){
                    val thumbnail = Gson().fromJson(mqttMessage.toString(), Thumbnail::class.java)
                    Log.d("ayo dongg", thumbnail.imgURL)
                    Glide.with(this@HomeFragment)
                        .load(thumbnail.imgURL)
                        .into(binding.image)
                }
            }
            override fun deliveryComplete(iMqttDeliveryToken: IMqttDeliveryToken) {
                Log.w("Debug", "Message published to host '$MQTT_HOST'")
            }
        })
    }

    override fun onDestroy() {
//        if (mqttClient.isConnected()) {
//            mqttClient.destroy()
//        }
        super.onDestroy()
    }

}