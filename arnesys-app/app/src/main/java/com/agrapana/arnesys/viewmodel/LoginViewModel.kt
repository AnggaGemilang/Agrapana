package com.agrapana.arnesys.viewmodel

import android.app.Application
import android.util.Log
import android.view.View
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.model.AuthListener
import com.agrapana.arnesys.model.AuthResponse
import com.agrapana.arnesys.repository.AuthRepository


class LoginViewModel : ViewModel() {

    var authListener: AuthListener? = null

    fun onLoginButtonClick(email: String, password: String){
        if(email.isEmpty() || password.isEmpty()){
            authListener?.onFailure("Email or Password Is Incorrect!")
        }

        val loginResponse = AuthRepository().userLogin(email, password)
        authListener?.onSuccess(loginResponse)
    }

}
