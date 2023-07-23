package com.agrapana.arnesys.model

import com.google.gson.annotations.SerializedName

data class ValueMonitoringSupportDevice(
    @SerializedName("soil_temperature") var soilTemperature: Int? = null,
    @SerializedName("soil_humidity") var soilHumidity: Int? = null,
    @SerializedName("soil_ph") var soilPh: Int? = null,
    @SerializedName("soil_nitrogen") var soilNitrogen: Int? = null,
    @SerializedName("soil_phosphor") var soilPhosphor: Int? = null,
    @SerializedName("soil_kalium") var soilKalium: Int? = null
)

data class MonitoringSupportDevice(
    var monitoring: ValueMonitoringSupportDevice
)