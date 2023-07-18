package com.agrapana.arnesys.viewmodel

import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.model.AuthResponse
import com.agrapana.arnesys.retrofit.AuthService
import com.agrapana.arnesys.retrofit.RetroInstance
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class LoginViewModel: ViewModel() {

    var loginLiveData: MutableLiveData<AuthResponse?> = MutableLiveData()

    fun getLoginObservable(): MutableLiveData<AuthResponse?> {
        return loginLiveData
    }

    fun login(email: String, password: String) {
        val retroInstance = RetroInstance.getRetroInstance().create(AuthService::class.java)
        val call = retroInstance.login(email, password)
        call.enqueue(object : Callback<AuthResponse?> {
            override fun onFailure(call: Call<AuthResponse?>, t: Throwable) {
                loginLiveData.postValue(null)
            }

            override fun onResponse(call: Call<AuthResponse?>, response: Response<AuthResponse?>) {
                if(response.isSuccessful) {
                    loginLiveData.postValue(response.body())
                } else {
                    loginLiveData.postValue(null)
                }
            }
        })
    }

}