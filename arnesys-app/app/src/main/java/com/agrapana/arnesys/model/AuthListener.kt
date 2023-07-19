package com.agrapana.arnesys.model

import androidx.lifecycle.LiveData

interface AuthListener {

    fun onSuccess(response: LiveData<AuthResponse?>)
    fun onFailure(message: String)

}