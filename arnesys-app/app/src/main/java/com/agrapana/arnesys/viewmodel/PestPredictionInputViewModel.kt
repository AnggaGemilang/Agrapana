package com.agrapana.arnesys.viewmodel

import android.util.Log
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.api.MonitoringMainDeviceService
import com.agrapana.arnesys.api.RetroInstance
import com.agrapana.arnesys.model.InputPestPrediction
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class PestPredictionInputViewModel: ViewModel() {

    var loadPestPredictionInputViewModel =  MutableLiveData<InputPestPrediction?>()

    fun getLoadPestPredictionInputObservable(): MutableLiveData<InputPestPrediction?> {
        return loadPestPredictionInputViewModel
    }

    fun getPestPredictionInput(id: String) {
        val retroInstance = RetroInstance.getRetroInstance().create(MonitoringMainDeviceService::class.java)
        retroInstance.getPestDataInput(id)
            .enqueue(object : Callback<InputPestPrediction> {
                override fun onResponse(
                    call: Call<InputPestPrediction>,
                    response: Response<InputPestPrediction>
                ) {
                    if(response.isSuccessful){
                        Log.d("hasil ham berhasil", response.body().toString())
                        loadPestPredictionInputViewModel.postValue(response.body())
                    } else {
                        Log.d("hasil ham gagal", response.body().toString())
                        loadPestPredictionInputViewModel.postValue(null)
                    }
                }

                override fun onFailure(call: Call<InputPestPrediction>, t: Throwable) {
                    Log.d("hasil ham gagal", "warko")
                    loadPestPredictionInputViewModel.postValue(null)
                }
            })
    }
}