package com.agrapana.arnesys.model

import com.google.gson.annotations.SerializedName

data class ValueMonitoringMainDevice(
    @SerializedName("wind_temperature") var windTemperature: Int? = null,
    @SerializedName("wind_humidity") var windHumidity: Int? = null,
    @SerializedName("wind_pressure") var windPressure: Int? = null,
    @SerializedName("wind_speed") var windSpeed: Int? = null,
    @SerializedName("rainfall") var rainfall: Boolean? = null
)

data class MonitoringMainDevice(
    var monitoring: ValueMonitoringMainDevice
)