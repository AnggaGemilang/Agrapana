package com.example.nialonic_gc.ui.activity

import android.content.SharedPreferences
import android.os.Bundle
import android.view.View
import android.view.WindowManager
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.preference.Preference
import androidx.preference.PreferenceFragmentCompat
import androidx.preference.PreferenceManager
import com.example.nialonic_gc.R
import com.example.nialonic_gc.databinding.ActivitySettingBinding


class SettingActivity : AppCompatActivity() {

    private lateinit var binding: ActivitySettingBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivitySettingBinding.inflate(layoutInflater)
        setContentView(binding.root)

        val w = window
        w.setFlags(
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS,
            WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS
        )

        setSupportActionBar(binding.toolbar);
        supportActionBar?.setDisplayHomeAsUpEnabled(true);
        supportActionBar?.setDisplayShowHomeEnabled(true);
        supportActionBar?.title = ""

        if (savedInstanceState == null) {
            supportFragmentManager
                .beginTransaction()
                .replace(R.id.settings, SettingsFragment())
                .commit()
        }
        supportActionBar?.setDisplayHomeAsUpEnabled(true)
    }

    override fun onSupportNavigateUp(): Boolean {
        onBackPressed()
        return true
    }

    class SettingsFragment : PreferenceFragmentCompat() {
        override fun onCreatePreferences(savedInstanceState: Bundle?, rootKey: String?) {
            setPreferencesFromResource(R.xml.root_preferences, rootKey)

            val refreshTime: Preference = findPreference("refresh")!!
            val notification: Preference = findPreference("notification")!!

            refreshTime.setOnPreferenceChangeListener { _, newValue ->
                val prefs: SharedPreferences = activity!!.getSharedPreferences("prefs", MODE_PRIVATE)
                val editor: SharedPreferences.Editor? = prefs.edit()
                editor?.putString("refreshData", newValue.toString())
                editor?.apply()
                true
            }

            notification.setOnPreferenceChangeListener { _, newValue ->
                val prefs: SharedPreferences = activity!!.getSharedPreferences("prefs", MODE_PRIVATE)
                val editor: SharedPreferences.Editor? = prefs.edit()
                editor?.putString("notificationAlert", newValue.toString())
                editor?.apply()
                true
            }
        }
    }
}