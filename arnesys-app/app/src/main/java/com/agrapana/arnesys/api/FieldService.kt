package com.agrapana.arnesys.api

import com.agrapana.arnesys.model.FieldResponse
import retrofit2.Call
import retrofit2.http.GET
import retrofit2.http.Headers
import retrofit2.http.Path

interface FieldService {

    @GET("fields/{client_id}")
    @Headers("Accept:application/json","Content-Type:application/json")
    fun getFieldsByClient(@Path("client_id") client_id: String): Call<FieldResponse>

}