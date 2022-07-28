package com.example.nialonic_gc.ui.activity

import android.content.Intent
import android.graphics.Color
import android.os.Build
import android.os.Bundle
import android.util.Log
import android.view.Menu
import android.view.MenuItem
import android.view.View
import android.view.WindowManager
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat
import androidx.lifecycle.ViewModelProviders
import com.example.nialonic_gc.R
import com.example.nialonic_gc.config.MQTT_HOST
import com.example.nialonic_gc.helper.MqttClientHelper
import com.example.nialonic_gc.databinding.ActivityDetailBinding
import com.example.nialonic_gc.model.Common
import com.example.nialonic_gc.model.Controlling
import com.example.nialonic_gc.model.Monitoring
import com.example.nialonic_gc.model.Plant
import com.example.nialonic_gc.viewmodel.PlantViewModel
import com.github.mikephil.charting.data.Entry
import com.github.mikephil.charting.data.LineData
import com.github.mikephil.charting.data.LineDataSet
import com.github.mikephil.charting.utils.ColorTemplate
import com.google.gson.Gson
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage
import java.text.SimpleDateFormat
import java.util.*
import kotlin.collections.ArrayList

class DetailActivity : AppCompatActivity() {

    private lateinit var binding: ActivityDetailBinding
    private lateinit var viewModel: PlantViewModel
    private var commonMsg =  Common()
    private var controllingMsg =  Controlling()
    lateinit var lineList: ArrayList<Entry>
    lateinit var lineDataSet: LineDataSet
    lateinit var lineData: LineData

    private val mqttClient by lazy {
        MqttClientHelper(this)
    }

    @RequiresApi(Build.VERSION_CODES.O)
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailBinding.inflate(layoutInflater)
        setContentView(binding.root)

        viewModel = ViewModelProviders.of(this)[PlantViewModel::class.java]

        val w = window
        w.setFlags(
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS,
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS
        )

        setSupportActionBar(binding.toolbar);
        supportActionBar?.setDisplayHomeAsUpEnabled(true);
        supportActionBar?.setDisplayShowHomeEnabled(true);
        supportActionBar?.title = ""

        lineList = ArrayList()
        lineList.add(Entry(10f, 1f))
        lineList.add(Entry(12f, 2f))
        lineList.add(Entry(15f, 3f))
        lineList.add(Entry(20f, 4f))

        lineDataSet = LineDataSet(lineList, "Perkembangan Jumlah Daun")
        lineData = LineData(lineDataSet)
        binding.chart.data = lineData
        lineDataSet.setColors(*ColorTemplate.JOYFUL_COLORS)
        lineDataSet.valueTextColor = Color.BLACK
        lineDataSet.valueTextSize = 14f
        lineDataSet.setDrawFilled(true)
        lineDataSet.fillDrawable = ContextCompat.getDrawable(this, R.drawable.gradient_chart)

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            val decor = window.decorView
            decor.systemUiVisibility = View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR
        }

        setMqttCallBack()
    }

    private fun setMqttCallBack() {
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arceniter/common")
                mqttClient.subscribe("arceniter/monitoring")
                mqttClient.subscribe("arceniter/controlling")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                Log.w("Debug", "Message received from host '$MQTT_HOST': $mqttMessage")
                if(topic == "arceniter/common"){
                    val common = Gson().fromJson(mqttMessage.toString(), Common::class.java)
                    binding.plantName.text = common.plant_name.capitalize()
                    binding.startedPlanting.text = common.started_planting
                    commonMsg = common
                } else if (topic == "arceniter/monitoring"){
                    val monitoring = Gson().fromJson(mqttMessage.toString(), Monitoring::class.java)
                    binding.valTemperature.text = monitoring.temperature.toString() + "°C"
                    binding.valPh.text = monitoring.ph + " Ph"
                    binding.valGas.text = monitoring.gas.toString() + " ppm`"
                    binding.valNutrition.text = monitoring.nutrition.toString() + " ppm"
                    binding.valNutritionVolume.text = monitoring.nutrition_volume.toString() + " ml"
                    binding.valGrowthLamp.text = monitoring.growth_lamp.capitalize()
                } else if (topic == "arceniter/controlling"){
                    val controlling = Gson().fromJson(mqttMessage.toString(), Controlling::class.java)
                    controllingMsg = controlling
                }
            }

            override fun deliveryComplete(iMqttDeliveryToken: IMqttDeliveryToken) {
                Log.w("Debug", "Message published to host '$MQTT_HOST'")
            }
        })
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressed()
        return true
    }

    override fun onCreateOptionsMenu(menu: Menu): Boolean {
        menuInflater.inflate(R.menu.action_detail, menu)
        return true
    }

    override fun onOptionsItemSelected(item: MenuItem): Boolean {
        when(item.itemId) {
            R.id.camera -> {
                startActivity(Intent(this, CameraWebviewActivity::class.java))
            }
            R.id.done -> {
                val builder = AlertDialog.Builder(this)
                builder.setTitle("Are You Sure?")
                builder.setMessage("This can be perform the machine")
                builder.setPositiveButton("YES") { _, _ ->
                    val plant = Plant()
                    plant.name = commonMsg.plant_name
                    plant.category = commonMsg.category
                    plant.plantType = commonMsg.plant_name
                    plant.mode = controllingMsg.mode
                    plant.plantStarted = commonMsg.started_planting
                    val sdf = SimpleDateFormat("dd-M-yyyy, hh:mm")
                    plant.plantEnded = sdf.format(Date())
                    plant.status = "Done"
                    viewModel.addPlant(plant)

                    commonMsg.is_planting = "no"
                    commonMsg.started_planting = ""
                    commonMsg.plant_name = ""
                    commonMsg.category = ""
                    mqttClient.publish("arceniter/common", Gson().toJson(commonMsg))
                    startActivity(Intent(this, MainActivity::class.java))
                }
                builder.setNegativeButton("NO") { dialog, _ ->
                    dialog.dismiss()
                }
                val alert = builder.create()
                alert.show()
            }
            R.id.cancel -> {
                val builder = AlertDialog.Builder(this)
                builder.setTitle("Are You Sure?")
                builder.setMessage("This can be perform the machine")
                builder.setPositiveButton("YES") { _, _ ->
                    val plant = Plant()
                    plant.name = commonMsg.plant_name
                    plant.category = commonMsg.category
                    plant.plantType = commonMsg.plant_name
                    plant.mode = controllingMsg.mode
                    plant.plantStarted = commonMsg.started_planting
                    val sdf = SimpleDateFormat("dd-M-yyyy, hh:mm")
                    plant.plantEnded = sdf.format(Date())
                    plant.status = "Cancelled"
                    viewModel.addPlant(plant)

                    commonMsg.is_planting = "no"
                    commonMsg.started_planting = ""
                    commonMsg.plant_name = ""
                    mqttClient.publish("arceniter/common", Gson().toJson(commonMsg))
                    startActivity(Intent(this, MainActivity::class.java))
                }
                builder.setNegativeButton("NO") { dialog, _ ->
                    dialog.dismiss()
                }
                val alert = builder.create()
                alert.show()
            }
        }
        return super.onOptionsItemSelected(item)
    }

    override fun onDestroy() {
//        if (mqttClient.isConnected()) {
//            mqttClient.destroy()
//        }
        super.onDestroy()
    }

}