package com.agrapana.arnesys.repository

import android.util.Log
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import com.agrapana.arnesys.api.AuthService
import com.agrapana.arnesys.api.RetroInstance
import com.agrapana.arnesys.model.Auth
import com.agrapana.arnesys.model.AuthResponse
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.util.Date

class AuthRepository {

    fun userLogin(email: String, password: String): LiveData<AuthResponse?> {

        val loginResponse = MutableLiveData<AuthResponse?>()

        val retroInstance = RetroInstance.getRetroInstance().create(AuthService::class.java)
        retroInstance.login(email, password)
            .enqueue(object: Callback<AuthResponse>{
                override fun onResponse(
                    call: Call<AuthResponse>,
                    response: Response<AuthResponse>
                ) {
                    if(response.isSuccessful){
                        loginResponse.value = response.body()
                    } else {
                        val authResponse = AuthResponse("failed", "username or password is incorrect", null)
                        loginResponse.value = authResponse
                    }
                }

                override fun onFailure(call: Call<AuthResponse>, t: Throwable) {
                    loginResponse.value = null
                }

            })
        return loginResponse
    }
}