package com.example.nialonic_gc

import android.os.Build
import android.os.Bundle
import android.view.WindowManager
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.example.nialonic_gc.databinding.ActivityMainBinding


class MainActivity : AppCompatActivity() {

    private lateinit var binding: ActivityMainBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            val w = window
            w.setFlags(
                WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS,
                WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS
            )
        }

        binding.bottomNavigationBar.background = null
        binding.bottomNavigationBar.menu.getItem(2).isEnabled = false

        binding.fab.setOnClickListener {
            AddPlantFragment().show(supportFragmentManager, "BottomSheetDialog")
        }

        val homeFragment = HomeFragment()
        makeCurrentFragment(homeFragment)

        val plantListFragment = PlantListFragment()
        val presetFragment = PresetFragment()
        val favoriteFragment = FavoriteFragment()

        binding.bottomNavigationBar.setOnNavigationItemSelectedListener() {
            when(it.itemId){
                R.id.home -> {
                    makeCurrentFragment(homeFragment)
                }
                R.id.lists -> {
                    makeCurrentFragment(plantListFragment)
                }
                R.id.presets -> {
                    makeCurrentFragment(presetFragment)
                }
                R.id.favorite -> {
                    makeCurrentFragment(favoriteFragment)
                }
            }
            true
        }
    }

    private fun makeCurrentFragment(fragment: Fragment) {
        supportFragmentManager.beginTransaction().apply {
            replace(R.id.frame_layout, fragment).commit()
        }
    }

    override fun onResume() {
        super.onResume()
    }
}