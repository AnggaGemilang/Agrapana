package com.example.nialonic_gc

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import com.example.nialonic_gc.databinding.ActivityTurnOnBinding
import com.ncorti.slidetoact.SlideToActView

class TurnOnActivity : AppCompatActivity() {

    private lateinit var binding: ActivityTurnOnBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityTurnOnBinding.inflate(layoutInflater)
        setContentView(binding.root)

        binding.slider.onSlideCompleteListener = object : SlideToActView.OnSlideCompleteListener{
            override fun onSlideComplete(view: SlideToActView) {
                startActivity(Intent(this@TurnOnActivity, MainActivity::class.java))
            }
        }
    }
}