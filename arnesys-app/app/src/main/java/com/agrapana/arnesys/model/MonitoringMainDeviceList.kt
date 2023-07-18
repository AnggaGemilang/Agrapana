package com.agrapana.arnesys.model

data class MonitoringMainDeviceList(val data: List<User>)
data class MonitoringMainDevice(val id: String?,val name: String?,  val email: String?, val status: String?, val gender: String?)
data class MonitoringMainDeviceResponse(val code: Int?, val meta: String?, val data: User?)