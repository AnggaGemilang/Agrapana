package com.agrapana.irosysco.helper

import android.content.Context
import android.util.Log
import com.agrapana.irosysco.config.*
import info.mqtt.android.service.MqttAndroidClient
import org.eclipse.paho.client.mqttv3.*
import org.eclipse.paho.client.mqttv3.MqttClient

class MqttClientHelper(context: Context?) {

    companion object {
        const val TAG = "MqttClientHelper"
    }

    var mqttAndroidClient: MqttAndroidClient
    val serverUri = MQTT_HOST
    private val clientId: String = MqttClient.generateClientId()

    fun setCallback(callback: MqttCallbackExtended?) {
        callback?.let { mqttAndroidClient.setCallback(it) }
    }

    init {
        mqttAndroidClient = MqttAndroidClient(context!!, serverUri, clientId)
        connect()
    }

    private fun connect() {
        val mqttConnectOptions = MqttConnectOptions()
        mqttConnectOptions.isAutomaticReconnect = MQTT_CONNECTION_RECONNECT
        mqttConnectOptions.isCleanSession = MQTT_CONNECTION_CLEAN_SESSION
        mqttConnectOptions.connectionTimeout = MQTT_CONNECTION_TIMEOUT
        mqttConnectOptions.keepAliveInterval = MQTT_CONNECTION_KEEP_ALIVE_INTERVAL
        try {
            mqttAndroidClient.connect(mqttConnectOptions, null, object : IMqttActionListener {
                override fun onSuccess(asyncActionToken: IMqttToken) {
                    val disconnectedBufferOptions =
                        DisconnectedBufferOptions()
                    disconnectedBufferOptions.isBufferEnabled = true
                    disconnectedBufferOptions.bufferSize = 100
                    disconnectedBufferOptions.isPersistBuffer = false
                    disconnectedBufferOptions.isDeleteOldestMessages = false
                    mqttAndroidClient.setBufferOpts(disconnectedBufferOptions)
                }

                override fun onFailure(
                    asyncActionToken: IMqttToken,
                    exception: Throwable
                ) {
                    Log.w(TAG, "Failed to connect to: $serverUri ; $exception")
                }
            })
        } catch (ex: MqttException) {
            ex.printStackTrace()
        }
    }

    fun subscribe(subscriptionTopic: String, qos: Int = 0) {
        try {
            mqttAndroidClient.subscribe(subscriptionTopic, qos, null, object : IMqttActionListener {
                override fun onSuccess(asyncActionToken: IMqttToken) {
                    Log.w(TAG, "Subscribed to topic '$subscriptionTopic'")
                }

                override fun onFailure(
                    asyncActionToken: IMqttToken,
                    exception: Throwable
                ) {
                    Log.w(TAG, "Subscription to topic '$subscriptionTopic' failed!")
                }
            })
        } catch (ex: MqttException) {
            System.err.println("Exception whilst subscribing to topic '$subscriptionTopic'")
            ex.printStackTrace()
        }
    }

    fun publish(topic: String, msg: String, qos: Int = 0) {
        try {
            val message = MqttMessage()
            Log.d(TAG, msg)
            message.payload = msg.toByteArray()
            Log.d(TAG, message.payload.toString())
            mqttAndroidClient.publish(topic, message.payload, qos, false)
            Log.d(TAG, "Message published to topic `$topic`: $msg")
        } catch (e: MqttException) {
            Log.d(TAG, "Error Publishing to $topic: " + e.message)
            e.printStackTrace()
        }

    }

    fun isConnected() : Boolean {
        return mqttAndroidClient.isConnected
    }

    fun destroy() {
        mqttAndroidClient.unregisterResources()
        mqttAndroidClient.disconnect()
    }
}