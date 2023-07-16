package com.agrapana.arnesys.ui.activity

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import com.agrapana.arnesys.R
import com.agrapana.arnesys.databinding.ActivityDetailFieldBinding
import com.agrapana.arnesys.databinding.ActivityMainBinding

class DetailFieldActivity : AppCompatActivity() {

    private lateinit var binding: ActivityDetailFieldBinding
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailFieldBinding.inflate(layoutInflater)
        setContentView(binding.root)
    }
}