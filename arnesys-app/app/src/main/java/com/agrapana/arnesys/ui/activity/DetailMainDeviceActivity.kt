package com.agrapana.arnesys.ui.activity

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import com.agrapana.arnesys.R
import com.agrapana.arnesys.databinding.ActivityDetailFieldBinding
import com.agrapana.arnesys.databinding.ActivityDetailMainDeviceBinding

class DetailMainDeviceActivity : AppCompatActivity() {

    private lateinit var binding: ActivityDetailMainDeviceBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailMainDeviceBinding.inflate(layoutInflater)
        setContentView(binding.root)
    }
}