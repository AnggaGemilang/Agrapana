package com.agrapana.arnesys.ui.fragment

import android.R
import android.app.Activity
import android.app.ProgressDialog
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.agrapana.arnesys.config.MQTT_HOST
import com.agrapana.arnesys.databinding.FragmentAddPlantBinding
import com.agrapana.arnesys.helper.MqttClientHelper
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended
import org.eclipse.paho.client.mqttv3.MqttMessage
import java.util.*

class AddPlantFragment : RoundedBottomSheetDialogFragment() {

    private var presetsName = mutableListOf<String>()

    private lateinit var binding: FragmentAddPlantBinding
    private var linkImage: Uri? = null
    private val GALLERY_REQUEST_CODE = 888

    private val mqttClient by lazy {
        MqttClientHelper(requireContext())
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentAddPlantBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        binding.designBottomSheet.layoutParams.height = ViewGroup.LayoutParams.MATCH_PARENT

        setMqttCallBack()

        binding.newConfiguration.setOnCheckedChangeListener { _, isChecked ->
            binding.type.isEnabled = !isChecked
            if(isChecked){
                binding.titleCategory.visibility = View.VISIBLE
                binding.category.visibility = View.VISIBLE
                binding.titlePlantName.visibility = View.VISIBLE
                binding.plantName.visibility = View.VISIBLE
                binding.titleNutrition.visibility = View.VISIBLE
                binding.nutrition.visibility = View.VISIBLE
                binding.titleDefaultImage.visibility = View.VISIBLE
                binding.defaultImage.visibility = View.VISIBLE
                binding.configurationItem1.visibility = View.VISIBLE
                binding.configurationItem2.visibility = View.VISIBLE
                binding.configurationItem3.visibility = View.VISIBLE
                binding.configurationItem4.visibility = View.VISIBLE
            } else {
                binding.titleCategory.visibility = View.GONE
                binding.category.visibility = View.GONE
                binding.titlePlantName.visibility = View.GONE
                binding.plantName.visibility = View.GONE
                binding.titleNutrition.visibility = View.GONE
                binding.nutrition.visibility = View.GONE
                binding.titleDefaultImage.visibility = View.GONE
                binding.defaultImage.visibility = View.GONE
                binding.configurationItem1.visibility = View.GONE
                binding.configurationItem2.visibility = View.GONE
                binding.configurationItem3.visibility = View.GONE
                binding.configurationItem4.visibility = View.GONE
            }
        }

        binding.open.setOnClickListener {
            selectImageFromGallery()
        }

        binding.btnSubmit.setOnClickListener {
            if(binding.newConfiguration.isChecked){
                val progressDialog = ProgressDialog(requireContext())
                progressDialog.setTitle("Please Wait")
                progressDialog.setMessage("System is working . . .")
                progressDialog.show()

                val fileName = UUID.randomUUID().toString() +".png"

            } else {
                dismiss()
            }
        }
    }

    private fun setMqttCallBack() {
        mqttClient.setCallback(object : MqttCallbackExtended {
            override fun connectComplete(b: Boolean, s: String) {
                Log.w("Debug", "Connection to host connected:\n'$MQTT_HOST'")
                mqttClient.subscribe("arceniter/thumbnail")
                mqttClient.subscribe("arceniter/common")
            }
            override fun connectionLost(throwable: Throwable) {
                Log.w("Debug", "Connection to host lost:\n'$MQTT_HOST'")
            }
            @Throws(Exception::class)
            override fun messageArrived(topic: String, mqttMessage: MqttMessage) {
                if(topic == "arceniter/common") {

                } else {

                }
            }
            override fun deliveryComplete(iMqttDeliveryToken: IMqttDeliveryToken) {
                Log.w("Debug", "Message published to host '$MQTT_HOST'")
            }
        })
    }

    override fun onActivityResult(
        requestCode: Int,
        resultCode: Int,
        data: Intent?
    ) {
        super.onActivityResult(
            requestCode,
            resultCode,
            data
        )
        if (requestCode == GALLERY_REQUEST_CODE
            && resultCode == Activity.RESULT_OK
            && data != null
            && data.data != null
        ) {
            val fileURL = data.data
            val urlFile = data.data!!.path.toString()
            binding.txtFilename.text = if(urlFile.length > 21) urlFile.substring(0, 20) + "..." else urlFile
            linkImage = fileURL!!
        }
    }

    private fun selectImageFromGallery() {
        val intent = Intent()
        intent.type = "image/*"
        intent.action = Intent.ACTION_GET_CONTENT
        startActivityForResult(
            Intent.createChooser(
                intent,
                "Please select..."
            ),
            GALLERY_REQUEST_CODE
        )
    }
}