package com.agrapana.arnesys.ui.fragment

import android.app.ProgressDialog
import android.content.Intent
import android.os.Build
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import kotlin.random.Random
import android.view.ViewGroup
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProviders
import com.bumptech.glide.Glide
import com.agrapana.arnesys.*
import com.agrapana.arnesys.config.MQTT_HOST
import com.agrapana.arnesys.databinding.FragmentHomeBinding
import com.agrapana.arnesys.helper.MqttClientHelper
import com.agrapana.arnesys.ui.activity.SettingActivity
import com.google.gson.Gson
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage
import java.math.RoundingMode
import java.text.DecimalFormat
import java.text.SimpleDateFormat
import java.time.LocalDate
import java.time.format.DateTimeFormatter
import java.util.*

class HomeFragment : Fragment() {

    private lateinit var binding: FragmentHomeBinding

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
        binding.toolbar.inflateMenu(R.menu.action_nav1)
        binding.toolbar.setOnMenuItemClickListener {
            when(it.itemId) {
                R.id.power -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("This can be perform the machine")
                    builder.setPositiveButton("YES") { _, _ ->
                        binding.loadingPanel.visibility = View.VISIBLE
                    }
                    builder.setNegativeButton("NO") { dialog, _ ->
                        dialog.dismiss()
                    }
                    val alert = builder.create()
                    alert.show()
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
                R.id.logout -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("You can't get in to your account")
                    builder.setPositiveButton("YES") { _, _ ->

                    }
                    builder.setNegativeButton("NO") { dialog, _ ->
                        dialog.dismiss()
                    }
                    val alert = builder.create()
                    alert.show()
                }
            }
            true
        }
        val dtf = DateTimeFormatter.ofPattern("dd MMM")
        val localDate = LocalDate.now()
        binding.txtTanggalHome.text = dtf.format(localDate)

        Handler(Looper.getMainLooper()).postDelayed({
            binding.plantNamePlaceholder.visibility = View.GONE
            binding.imagePlaceholder.visibility = View.GONE
            binding.startedPlantingPlaceholder.visibility = View.GONE
            binding.valTemperaturePlaceholder.visibility = View.GONE
            binding.valGasPlaceholder.visibility = View.GONE
            binding.valPhPlaceholder.visibility = View.GONE
            binding.valVolumePlaceholder.visibility = View.GONE
            binding.valNutritionPlaceholder.visibility = View.GONE
            binding.valGasPlaceholder.visibility = View.GONE
            binding.valGrowthLampPlaceholder.visibility = View.GONE
            binding.plantName.visibility = View.VISIBLE
            binding.image.visibility = View.VISIBLE
            binding.startedPlanting.visibility = View.VISIBLE
            binding.valTemperature.visibility = View.VISIBLE
            binding.valGas.visibility = View.VISIBLE
            binding.valPh.visibility = View.VISIBLE
            binding.valGas.visibility = View.VISIBLE
            binding.valGrowthLamp.visibility = View.VISIBLE
            binding.valNutritionVolume.visibility = View.VISIBLE
            binding.valNutrition.visibility = View.VISIBLE

            val mainHandler = Handler(Looper.getMainLooper())

            mainHandler.post(object : Runnable {
                override fun run() {
                    minusOneSecond()
                    mainHandler.postDelayed(this, 5000)
                }
            })

        }, 3000)
    //        setMqttCallBack()
    }

    private fun minusOneSecond(){
        val df = DecimalFormat("#.##")
        df.roundingMode = RoundingMode.DOWN

        val suhu = 23.4 + Random.nextDouble() * (23.8 - 23.4)
        val kelembaban = (50..54).shuffled().last()
        val cahaya = (80..83).shuffled().last()

        val suhuConverted = df.format(suhu)

        binding.valTemperature.text = suhuConverted + "°C"
        binding.valPh.text = kelembaban.toString() + " %"
        binding.valGas.text = cahaya.toString()
        binding.valNutrition.text = "Normal"
    }

    private fun setMqttCallBack() {
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arnesys/common")
                mqttClient.subscribe("arnesys/thumbnail")
                mqttClient.subscribe("arnesys/monitoring")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                Log.w("Debug", "Message received from host '$MQTT_HOST': $mqttMessage")
                if(topic == "arnesys/common"){

                } else if (topic == "arnesys/monitoring"){

                } else if (topic == "arnesys/thumbnail"){

                }
                binding.plantNamePlaceholder.visibility = View.GONE
                binding.imagePlaceholder.visibility = View.GONE
                binding.startedPlantingPlaceholder.visibility = View.GONE
                binding.valTemperaturePlaceholder.visibility = View.GONE
                binding.valGasPlaceholder.visibility = View.GONE
                binding.valPhPlaceholder.visibility = View.GONE
                binding.valVolumePlaceholder.visibility = View.GONE
                binding.valNutritionPlaceholder.visibility = View.GONE
                binding.valGasPlaceholder.visibility = View.GONE
                binding.valGrowthLampPlaceholder.visibility = View.GONE
                binding.plantName.visibility = View.VISIBLE
                binding.image.visibility = View.VISIBLE
                binding.startedPlanting.visibility = View.VISIBLE
                binding.valTemperature.visibility = View.VISIBLE
                binding.valGas.visibility = View.VISIBLE
                binding.valPh.visibility = View.VISIBLE
                binding.valGas.visibility = View.VISIBLE
                binding.valGrowthLamp.visibility = View.VISIBLE
                binding.valNutritionVolume.visibility = View.VISIBLE
                binding.valNutrition.visibility = View.VISIBLE
            }
            override fun deliveryComplete(iMqttDeliveryToken: IMqttDeliveryToken) {
                Log.w("Debug", "Message published to host '$MQTT_HOST'")
            }
        })
    }

    override fun onDestroy() {
        if (mqttClient.isConnected()) {
            mqttClient.destroy()
        }
        super.onDestroy()
    }

}