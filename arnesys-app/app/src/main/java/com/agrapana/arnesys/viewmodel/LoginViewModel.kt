package com.agrapana.arnesys.viewmodel

import android.util.Log
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.helper.AuthListener
import com.agrapana.arnesys.repository.AuthRepository


class LoginViewModel : ViewModel() {

    var authListener: AuthListener? = null

    fun onLoginButtonClick(email: String, password: String){
        if(email.isEmpty() || password.isEmpty()){
            authListener?.onFailure("Email or Password Is Empty!")
        } else {
            val loginResponse = AuthRepository().userLogin(email, password)
            authListener?.onSuccess(loginResponse)
        }
    }
}
