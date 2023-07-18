package com.agrapana.arnesys.retrofit

import com.agrapana.arnesys.model.MonitoringMainDeviceResponse
import retrofit2.Call
import retrofit2.http.GET
import retrofit2.http.Headers
import retrofit2.http.Path

interface MonitoringSupportDeviceService {

    @GET("field/support-device/{field_id}/{number_of}")
    @Headers("Accept:application/json","Content-Type:application/json")
    fun getMonitoringSupportDevice(@Path("field_id") field_id: String, @Path("number_of") number_of: Int): Call<MonitoringMainDeviceResponse>
}