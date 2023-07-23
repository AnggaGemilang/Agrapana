package com.agrapana.arnesys.ui.fragment

import android.content.Intent
import android.content.SharedPreferences
import android.os.Build
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.annotation.RequiresApi
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import androidx.recyclerview.widget.LinearLayoutManager
import com.agrapana.arnesys.*
import com.agrapana.arnesys.adapter.FieldFilterAdapter
import com.agrapana.arnesys.config.MQTT_HOST
import com.agrapana.arnesys.databinding.FragmentHomeBinding
import com.agrapana.arnesys.helper.ChangeFieldListener
import com.agrapana.arnesys.helper.MqttClientHelper
import com.agrapana.arnesys.ui.activity.LoginActivity
import com.agrapana.arnesys.ui.activity.SettingActivity
import com.agrapana.arnesys.viewmodel.FieldViewModel
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage
import java.time.LocalDate
import java.time.format.DateTimeFormatter
import java.util.*


class HomeFragment : Fragment(), ChangeFieldListener {

    private lateinit var binding: FragmentHomeBinding
    private lateinit var prefs: SharedPreferences
    private lateinit var recyclerViewAdapter: FieldFilterAdapter
    private lateinit var viewModel: FieldViewModel

    private var clientId: String? = null
    private var fieldId: String? = null

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

        prefs = this.activity?.getSharedPreferences("prefs",
            AppCompatActivity.MODE_PRIVATE
        )!!
        clientId = prefs.getString("client_id", "")

        val name: String? = prefs.getString("name", "")
        val nameParts = name!!.trim().split("\\s+".toRegex())
        binding.greeting.text = "Hello there, ${nameParts[0]}"

        binding.toolbar.inflateMenu(R.menu.action_nav1)
        binding.toolbar.setOnMenuItemClickListener {
            when(it.itemId) {
                R.id.notification -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("This can be perform the machine")
                    builder.setPositiveButton("Close") { _, _ ->

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
                        val editor: SharedPreferences.Editor? = prefs.edit()
                        editor?.putBoolean("loginStart", true)
                        editor?.putString("client_id", null)
                        editor?.apply()
                        startActivity(Intent(activity, LoginActivity::class.java))
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

        initRecyclerView()
        initViewModel()
    }

    private fun initRecyclerView() {
        val linearLayoutManager = LinearLayoutManager(
            activity, LinearLayoutManager.HORIZONTAL, false
        )
        binding.recyclerView.layoutManager = linearLayoutManager
        recyclerViewAdapter = FieldFilterAdapter(activity!!)
        recyclerViewAdapter.changeFieldListener = this
        binding.recyclerView.adapter = recyclerViewAdapter
        recyclerViewAdapter.notifyDataSetChanged()
    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this)[FieldViewModel::class.java]
        viewModel.getAllField(clientId!!)
        viewModel.getLoadFieldObservable().observe(activity!!) {
            if(it?.data != null){
                recyclerViewAdapter.setFieldList(it.data)
            }
        }
    }

    private fun setMqttCallBack() {
        Log.d("mqtt", "aya naon ieuuu")
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arnesys/$clientId/$fieldId/utama")
                mqttClient.subscribe("arnesys/$clientId/$fieldId/pendukung/1")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                Log.w("mqttMessage", "Message received from host '$MQTT_HOST': $mqttMessage")
                if(topic == "arnesys/$clientId/$fieldId/utama"){

                } else if (topic == "arnesys/$clientId/$fieldId/pendukung/1"){

                }
                binding.valTemperaturePlaceholder.visibility = View.GONE
                binding.valGasPlaceholder.visibility = View.GONE
                binding.valPhPlaceholder.visibility = View.GONE
                binding.valVolumePlaceholder.visibility = View.GONE
                binding.valNutritionPlaceholder.visibility = View.GONE
                binding.valGasPlaceholder.visibility = View.GONE
                binding.valGrowthLampPlaceholder.visibility = View.GONE
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

    override fun onResume() {
        mqttClient.mqttAndroidClient.registerResources()
        super.onResume()
    }

    override fun onDestroy() {
        mqttClient.disconnect()
        super.onDestroy()
    }

    override fun onChangeField(id: String?) {
        Toast.makeText(context, id, Toast.LENGTH_SHORT).show()
        if (mqttClient.isConnected()) {
            mqttClient.unsubscribe("arnesys/$clientId/$fieldId/utama")
            mqttClient.unsubscribe("arnesys/$clientId/$fieldId/pendukung/1")
        }
        fieldId = id
        mqttClient.subscribe("arnesys/$clientId/$fieldId/utama")
        mqttClient.subscribe("arnesys/$clientId/$fieldId/pendukung/1")
        setMqttCallBack()
    }

}