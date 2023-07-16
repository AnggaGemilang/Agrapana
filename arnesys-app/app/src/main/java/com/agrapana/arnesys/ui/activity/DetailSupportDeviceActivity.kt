package com.agrapana.arnesys.ui.activity

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import com.agrapana.arnesys.R
import com.agrapana.arnesys.databinding.ActivityDetailMainDeviceBinding
import com.agrapana.arnesys.databinding.ActivityDetailSupportDeviceBinding

class DetailSupportDeviceActivity : AppCompatActivity() {

    private lateinit var binding: ActivityDetailSupportDeviceBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailSupportDeviceBinding.inflate(layoutInflater)
        setContentView(binding.root)
    }
}