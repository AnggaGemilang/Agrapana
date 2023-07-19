package com.agrapana.arnesys.ui.activity

import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.widget.Toast
import androidx.lifecycle.LiveData
import androidx.lifecycle.ViewModelProvider
import com.agrapana.arnesys.databinding.ActivityLoginBinding
import com.agrapana.arnesys.helper.AuthListener
import com.agrapana.arnesys.model.AuthResponse
import com.agrapana.arnesys.viewmodel.LoginViewModel

class LoginActivity : AppCompatActivity(), AuthListener {

    private lateinit var binding: ActivityLoginBinding
    private lateinit var viewModel: LoginViewModel

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)

        viewModel = ViewModelProvider(this)[LoginViewModel::class.java]
        viewModel.authListener = this

        binding.btnLogin.setOnClickListener {
            val email = binding.etEmail.text.toString()
            val password = binding.etPassword.text.toString()
            viewModel.onLoginButtonClick(email, password)
        }
    }

    override fun onSuccess(response: LiveData<AuthResponse?>) {

        response.observe(this) {

            if(it!!.status == "failed"){
                Toast.makeText(this, "Email or Password Is Incorrect!", Toast.LENGTH_SHORT).show()
            } else {
                val prefs: SharedPreferences = getSharedPreferences("prefs", MODE_PRIVATE)
                val editor: SharedPreferences.Editor? = prefs.edit()
                editor?.putBoolean("loginStart", false)
                editor?.putString("client_id", it.data?.id)
                editor?.apply()
                startActivity(Intent(this, MainActivity::class.java))
            }
        }
    }

    override fun onFailure(message: String) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show()
    }

}