package com.agrapana.irosysco.ui.activity

import android.content.Intent
import android.content.SharedPreferences
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.EditText
import android.widget.Toast
import com.agrapana.irosysco.R
import com.agrapana.irosysco.databinding.ActivityLoginBinding
import com.agrapana.irosysco.databinding.ActivityOnboardingBinding

class LoginActivity : AppCompatActivity() {

    private lateinit var binding: ActivityLoginBinding
    private val validUsername = "angga"
    private val validPassword = "angga123"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)

        binding.btnLogin.setOnClickListener {

            if(validUsername == binding.etEmail.text.toString() && validPassword == binding.etPassword.text.toString()){
                val prefs: SharedPreferences = getSharedPreferences("prefs", MODE_PRIVATE)
                val editor: SharedPreferences.Editor? = prefs.edit()
                editor?.putBoolean("loginStart", false)
                editor?.apply()
                startActivity(Intent(this, MainActivity::class.java))
            } else {
                Toast.makeText(this, "Email or Password Incorrect", Toast.LENGTH_LONG).show()
            }

        }

    }


}