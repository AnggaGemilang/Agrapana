package com.agrapana.arnesys.ui.activity

import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.Toast
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import com.agrapana.arnesys.databinding.ActivityLoginBinding
import com.agrapana.arnesys.model.AuthResponse
import com.agrapana.arnesys.viewmodel.LoginViewModel

class LoginActivity : AppCompatActivity() {

    private lateinit var binding: ActivityLoginBinding
    private lateinit var viewModel: LoginViewModel
    private val validUsername = "angga"
    private val validPassword = "angga123"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)

        initViewModel()

        binding.btnLogin.setOnClickListener {
            login(binding.etEmail.text.toString(), binding.etPassword.text.toString())
        }
    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this)[LoginViewModel::class.java]

    }

    private fun login(email: String, password: String) {
        viewModel.getLoginObservable().observe(this) {
            if (it == null) {
                Toast.makeText(this, "Username or password is incorrect", Toast.LENGTH_LONG).show()
            } else {
                val prefs: SharedPreferences = getSharedPreferences("prefs", MODE_PRIVATE)
                val editor: SharedPreferences.Editor? = prefs.edit()
                editor?.putBoolean("loginStart", false)
                editor?.putString("client_id", it.data?.id)
                editor?.apply()
                startActivity(Intent(this, MainActivity::class.java))
            }
        }
        viewModel.login(email, password)
    }

}