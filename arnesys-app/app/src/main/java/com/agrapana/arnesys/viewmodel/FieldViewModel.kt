package com.agrapana.arnesys.viewmodel

import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.model.FieldList
import com.agrapana.arnesys.model.FieldResponse
import com.agrapana.arnesys.api.FieldService
import com.agrapana.arnesys.api.RetroInstance
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class FieldViewModel: ViewModel() {

    var recyclerListData: MutableLiveData<FieldList> = MutableLiveData()

    fun getUserListObserverable() : MutableLiveData<FieldList> {
        return recyclerListData
    }

    fun getFieldsList(client_id: String) {
        val retroInstance = RetroInstance.getRetroInstance().create(FieldService::class.java)
        val call = retroInstance.getFieldsByClient(client_id)
        call.enqueue(object : Callback<FieldResponse>{
            override fun onFailure(call: Call<FieldResponse>, t: Throwable) {
//                recyclerListData.postValue(null)
            }

            override fun onResponse(call: Call<FieldResponse>, response: Response<FieldResponse>) {
//                if(response.isSuccessful) {
//                    recyclerListData.postValue(response.body())
//                } else {
//                    recyclerListData.postValue(null)
//                }
            }
        })
    }
}