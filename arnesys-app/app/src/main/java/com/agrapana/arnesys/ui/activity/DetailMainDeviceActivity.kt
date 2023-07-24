package com.agrapana.arnesys.ui.activity

import android.content.SharedPreferences
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
import androidx.fragment.app.Fragment
import androidx.fragment.app.FragmentTransaction
import com.agrapana.arnesys.R
import com.agrapana.arnesys.config.MQTT_HOST
import com.agrapana.arnesys.databinding.ActivityDetailMainDeviceBinding
import com.agrapana.arnesys.helper.MqttClientHelper
import com.agrapana.arnesys.model.Field
import com.agrapana.arnesys.model.MonitoringMainDevice
import com.agrapana.arnesys.model.MonitoringSupportDevice
import com.agrapana.arnesys.ui.fragment.ChartFragment
import com.bumptech.glide.Glide
import com.google.android.material.tabs.TabLayout
import com.google.gson.Gson
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage
import org.imaginativeworld.oopsnointernet.NoInternetDialog
import java.util.*


class DetailMainDeviceActivity : AppCompatActivity() {

    private lateinit var binding: ActivityDetailMainDeviceBinding
    private lateinit var prefs: SharedPreferences
    private var noInternetDialog: NoInternetDialog? = null

    private var clientId: String? = null
    private var fieldId: String? = null

    private val mqttClient by lazy {
        MqttClientHelper(this)
    }

    @RequiresApi(Build.VERSION_CODES.O)
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailMainDeviceBinding.inflate(layoutInflater)
        setContentView(binding.root)

        val w = window
        w.setFlags(
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS,
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS
        )

        prefs = this.getSharedPreferences("prefs", MODE_PRIVATE)!!
        clientId = prefs.getString("client_id", "")

        val passedData: Field = Gson().fromJson(intent.getStringExtra("passData"), Field::class.java)
        fieldId = passedData.id

        val imageParts = passedData.thumbnail.toString().trim().split("public/".toRegex())
        if(passedData.thumbnail != null){
            Glide.with(this).load("https://arnesys.agrapana.tech/storage/" + imageParts[1]).into(binding.imgThumbnail);
        } else {
            Glide.with(this).load(R.drawable.farmland).into(binding.imgThumbnail);
        }

        setSupportActionBar(binding.toolbar)
        supportActionBar?.title = "Main Device"
        supportActionBar?.setDisplayHomeAsUpEnabled(true);
        supportActionBar?.setDisplayShowHomeEnabled(true);

        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Weather"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Pests"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Warmth"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Humidity"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Wind Speed"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Wind Pressure"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Wind Intensity"))
        binding.tabLayout.tabGravity = TabLayout.GRAVITY_FILL
        replaceFragment(ChartFragment(passedData, "Weather"))

        binding.tabLayout.addOnTabSelectedListener(object : TabLayout.OnTabSelectedListener {
            override fun onTabSelected(tab: TabLayout.Tab) {
                when (tab.position) {
                    0 -> replaceFragment(ChartFragment(passedData, "Weather"))
                    1 -> replaceFragment(ChartFragment(passedData, "Pests"))
                    2 -> replaceFragment(ChartFragment(passedData, "Warmth"))
                    3 -> replaceFragment(ChartFragment(passedData, "Humidity"))
                    4 -> replaceFragment(ChartFragment(passedData, "Wind Speed"))
                    5 -> replaceFragment(ChartFragment(passedData, "Wind Pressure"))
                    6 -> replaceFragment(ChartFragment(passedData, "Wind Intensity"))
                }
            }
            override fun onTabUnselected(tab: TabLayout.Tab) {}
            override fun onTabReselected(tab: TabLayout.Tab) {}
        })

        setMqttCallBack()
    }

    private fun replaceFragment(fragment: Fragment?) {
        val fm = this.supportFragmentManager
        val ft = fm.beginTransaction()
        ft.replace(R.id.frame_container, fragment!!)
        ft.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN)
        ft.commit()
    }

    private fun setMqttCallBack() {
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arnesys/$clientId/$fieldId/utama")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                Log.w("mqttMessage", "Message received from host '$MQTT_HOST': $mqttMessage")
                if(topic == "arnesys/$clientId/$fieldId/utama"){
                    val message = Gson().fromJson(mqttMessage.toString(), MonitoringMainDevice::class.java)
                    Log.d("mqtt", message.toString())
                    binding.valWindTemperature.text = message.monitoring.windTemperature.toString() + "°"
                    binding.valWindHumidity.text = message.monitoring.windHumidity.toString() + "%"
                    binding.valWindSpeed.text = message.monitoring.windSpeed.toString() + "mph"
                    binding.valWindPressure.text = message.monitoring.windPressure.toString()
//                    binding.valPest.text = message.monitoring.pest.toString()
//                    binding.valLight.text = message.monitoring.lightIntensity.toString()
                }

                binding.valWindWarmthPlaceholder.visibility = View.GONE
                binding.valWindHumidityPlaceholder.visibility = View.GONE
                binding.valPestsPlaceholder.visibility = View.GONE
                binding.valWindSpeedPlaceholder.visibility = View.GONE
                binding.valWindPressurePlaceholder.visibility = View.GONE
                binding.valLightIntensityPlaceholder.visibility = View.GONE
                binding.valWindTemperature.visibility = View.VISIBLE
                binding.valWindHumidity.visibility = View.VISIBLE
                binding.valPest.visibility = View.VISIBLE
                binding.valWindSpeed.visibility = View.VISIBLE
                binding.valWindPressure.visibility = View.VISIBLE
                binding.valLightIntensity.visibility = View.VISIBLE

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
        menuInflater.inflate(R.menu.action_nav3, menu)
        return true
    }

    override fun onOptionsItemSelected(item: MenuItem): Boolean {
        when(item.itemId) {
            R.id.about -> {
                AlertDialog.Builder(this)
                    .setTitle("App Version")
                    .setMessage("Beta 1.0.0")
                    .setCancelable(true)
                    .setPositiveButton("OK", null)
                    .create()
                    .show()
            }
        }
        return super.onOptionsItemSelected(item)
    }

    override fun onPause() {
        super.onPause()
        if (noInternetDialog != null) {
            noInternetDialog!!.destroy();
        }
    }

    override fun onResume() {
        super.onResume()
        val builder1 = NoInternetDialog.Builder(this)
        builder1.cancelable = false // Optional
        builder1.noInternetConnectionTitle = "No Internet" // Optional
        builder1.noInternetConnectionMessage = "Check your Internet connection and try again" // Optional
        builder1.showInternetOnButtons = true // Optional
        builder1.pleaseTurnOnText = "Please turn on" // Optional
        builder1.wifiOnButtonText = "Wifi" // Optional
        builder1.mobileDataOnButtonText = "Mobile data" // Optional
        builder1.onAirplaneModeTitle = "No Internet" // Optional
        builder1.onAirplaneModeMessage = "You have turned on the airplane mode." // Optional
        builder1.pleaseTurnOffText = "Please turn off" // Optional
        builder1.airplaneModeOffButtonText = "Airplane mode" // Optional
        builder1.showAirplaneModeOffButtons = true // Optional
        noInternetDialog = builder1.build()
    }

    override fun onDestroy() {
//        if (mqttClient.isConnected()) {
//            mqttClient.destroy()
//        }
        super.onDestroy()
    }

}