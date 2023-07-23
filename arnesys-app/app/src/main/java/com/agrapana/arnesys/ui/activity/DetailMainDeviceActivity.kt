package com.agrapana.arnesys.ui.activity

import android.app.PendingIntent.getActivity
import android.os.Build
import android.os.Bundle
import android.view.Menu
import android.view.MenuItem
import android.view.WindowManager
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import androidx.fragment.app.FragmentTransaction
import com.agrapana.arnesys.R
import com.agrapana.arnesys.databinding.ActivityDetailMainDeviceBinding
import com.agrapana.arnesys.ui.fragment.ChartFragment
import com.google.android.material.tabs.TabLayout
import org.imaginativeworld.oopsnointernet.NoInternetDialog
import java.util.*

class DetailMainDeviceActivity : AppCompatActivity() {

    private lateinit var binding: ActivityDetailMainDeviceBinding
    private var noInternetDialog: NoInternetDialog? = null
    private var imageFromMQTT: String = ""


    private val mqttClient by lazy {
//        MqttClientHelper(this)
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

        val string: String? = intent.getStringExtra("keyString")

        setSupportActionBar(binding.toolbar);
        supportActionBar?.title = "Suwarko"
        supportActionBar?.subtitle = "Nanang"
        supportActionBar?.setDisplayHomeAsUpEnabled(true);
        supportActionBar?.setDisplayShowHomeEnabled(true);

        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Weather"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("OPT"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Tab Menu 3"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Tab Menu 4"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Tab Menu 5"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Tab Menu 6"))
        binding.tabLayout.tabGravity = TabLayout.GRAVITY_FILL
        replaceFragment(ChartFragment())

        binding.tabLayout.addOnTabSelectedListener(object : TabLayout.OnTabSelectedListener {
            override fun onTabSelected(tab: TabLayout.Tab) {
                when (tab.position) {
                    0 -> replaceFragment(ChartFragment())
                    1 -> replaceFragment(ChartFragment())
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
//        mqttClient.setCallback(object : MqttCallbackExtended {
//            override fun connectComplete(b: Boolean, s: String) {
//                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
//                mqttClient.subscribe("arceniter/common")
//                mqttClient.subscribe("arceniter/monitoring")
//                mqttClient.subscribe("arceniter/controlling")
//                mqttClient.subscribe("arceniter/thumbnail")
//            }
//
//            override fun connectionLost(throwable: Throwable) {
//                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
//            }
//
//            @Throws(Exception::class)
//            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
//                binding.mainContent.visibility = View.VISIBLE
//                binding.loadingPanel.visibility = View.GONE
//                Log.w("Debug", "Message received from host '$MQTT_HOST': $mqttMessage")
//                when (topic) {
//                    "arceniter/common" -> {
//                        commonMsg = Gson().fromJson(mqttMessage.toString(), Common::class.java)
//                        val data = commonMsg.plant_name.split("#").toTypedArray()
//                        binding.plantName.text = data[0].capitalize()
//                        binding.startedPlanting.text = commonMsg.started_planting
//
//                        val cal = Calendar.getInstance()
//                        val s = SimpleDateFormat("dd MMM yyyy")
//                        cal.add(Calendar.DAY_OF_YEAR, Integer.parseInt(data[1]))
//                        binding.prediction.text = "(" + s.format(Date(cal.timeInMillis)) + ")"
//                    }
//                    "arceniter/monitoring" -> {
//                        val monitoring = Gson().fromJson(mqttMessage.toString(), Monitoring::class.java)
//                        binding.valTemperature.text = monitoring.temperature.toString() + "°C"
//                        binding.valPh.text = monitoring.ph + " Ph"
//                        binding.valGas.text = monitoring.gas.toString() + " ppm`"
//                        binding.valNutrition.text = monitoring.nutrition.toString() + " ppm"
//                        binding.valNutritionVolume.text = monitoring.nutrition_volume.toString() + "%"
//                        binding.valGrowthLamp.text = monitoring.growth_lamp.capitalize()
//                    }
//                    "arceniter/controlling" -> {
//                        val controlling = Gson().fromJson(mqttMessage.toString(), Controlling::class.java)
//                        controllingMsg = controlling
//                    }
//                    "arceniter/thumbnail" -> {
//                        thumbnailMsg = Gson().fromJson(mqttMessage.toString(), Thumbnail::class.java)
//                        binding.image.visibility = View.VISIBLE
//                        Glide.with(this@DetailActivity)
//                            .load(thumbnailMsg.imgURL)
//                            .into(binding.image)
//                        imageFromMQTT = thumbnailMsg.imgURL
//                    }
//                }
//            }
//            override fun deliveryComplete(iMqttDeliveryToken: IMqttDeliveryToken) {
//                Log.w("Debug", "Message published to host '$MQTT_HOST'")
//            }
//        })
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