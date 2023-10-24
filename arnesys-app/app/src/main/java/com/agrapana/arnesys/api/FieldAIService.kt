package com.agrapana.arnesys.api

import com.agrapana.arnesys.model.FieldResponse
import com.agrapana.arnesys.model.InputCropRecommend
import com.agrapana.arnesys.model.InputPestPrediction
import com.agrapana.arnesys.model.PestPredictionResponse
import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.Headers
import retrofit2.http.POST
import retrofit2.http.Path

interface FieldAIService {

    @POST("recommend")
    @Headers("Accept:application/json","Content-Type:application/json")
    fun getCropRecommend(@Body data: String): Call<FieldResponse>

    @POST("pest")
    @Headers("Accept:application/json","Content-Type:application/json")
    fun getPestPrediction(@Body data: InputPestPrediction): Call<PestPredictionResponse>


}