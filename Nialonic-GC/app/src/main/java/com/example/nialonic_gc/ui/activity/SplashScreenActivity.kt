package com.example.nialonic_gc.ui.activity

import android.annotation.SuppressLint
import android.content.Intent
import android.content.SharedPreferences
import android.os.Build
import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.util.Log
import android.view.WindowInsets
import android.view.WindowManager
import androidx.appcompat.app.AppCompatActivity
import com.example.nialonic_gc.databinding.ActivitySplashScreenBinding

@SuppressLint("CustomSplashScreen")
class SplashScreenActivity : AppCompatActivity() {

    private var binding: ActivitySplashScreenBinding? = null
    private var progressStatus = 0

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivitySplashScreenBinding.inflate(layoutInflater)
        setContentView(binding!!.root)

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.R) {
            window.insetsController?.hide(WindowInsets.Type.statusBars())
        } else {
            window.setFlags(
                WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN
            )
        }

        var progressStatus = 0
        binding!!.progressBar.max = 100

        Thread {
            while (progressStatus < binding!!.progressBar.max) {
                progressStatus++
                Log.d("Progress bar", progressStatus.toString())
                binding!!.progressBar.progress = progressStatus
                try {
                    Thread.sleep(30)
                } catch (e: InterruptedException) {
                    e.printStackTrace()
                }
            }
            Handler(Looper.getMainLooper()).post {
                val prefs: SharedPreferences = getSharedPreferences("prefs", MODE_PRIVATE)
                val firstState: Boolean = prefs.getBoolean("firstStart", true)
                if(firstState){
                    startActivity(Intent(this, OnboardingActivity::class.java))
                } else {
                    startActivity(Intent(this, MainActivity::class.java))
                }
            }
        }.start()
    }
}