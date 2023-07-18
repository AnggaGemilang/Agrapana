package com.agrapana.arnesys.model

data class MonitoringSupportDeviceList(val data: List<User>)
data class MonitoringSupportDevice(val id: String?,val name: String?,  val email: String?, val status: String?, val gender: String?)
data class MonitoringSupportDeviceResponse(val code: Int?, val meta: String?, val data: User?)