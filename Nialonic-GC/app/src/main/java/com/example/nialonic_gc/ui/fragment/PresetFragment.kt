package com.example.nialonic_gc.ui.fragment

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.Fragment
import androidx.fragment.app.FragmentTransaction
import com.example.nialonic_gc.R
import com.example.nialonic_gc.databinding.FragmentPresetBinding
import com.example.nialonic_gc.ui.activity.SettingActivity
import com.example.nialonic_gc.ui.activity.TurnOnActivity
import com.google.android.material.tabs.TabLayout

class PresetFragment : Fragment() {

    private lateinit var binding: FragmentPresetBinding

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentPresetBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.toolbar.inflateMenu(R.menu.action_nav2)
        binding.toolbar.setOnMenuItemClickListener {
            when(it.itemId) {
                R.id.add -> {
                    activity?.let { it1 -> AddConfigurationFragment().show(it1.supportFragmentManager, "BottomSheetDialog") }
                }
                R.id.power -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("This can be perform the machine")
                    builder.setPositiveButton("YES") { _, _ ->
                        startActivity(Intent(context, TurnOnActivity::class.java))
                    }
                    builder.setNegativeButton("NO") { dialog, _ ->
                        dialog.dismiss()
                    }
                    val alert = builder.create()
                    alert.show()
                }
                R.id.about -> {
                    AlertDialog.Builder(requireContext())
                        .setTitle("Versi Aplikasi")
                        .setMessage("Beta 1.0.0")
                        .setCancelable(true)
                        .setPositiveButton("OK", null)
                        .create()
                        .show()
                }
                R.id.setting -> {
                    startActivity(Intent(context, SettingActivity::class.java))
                }
            }
            true
        }

        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Fruit"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Microgreen"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Ornamental"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Vegetable"))
        binding.tabLayout.tabGravity = TabLayout.GRAVITY_FILL
        replaceFragment(PresetDataFragment())

    }

    private fun replaceFragment(fragment: Fragment?) {
        val fm = requireActivity().supportFragmentManager
        val ft = fm.beginTransaction()
        ft.replace(R.id.frame_container, fragment!!)
        ft.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN)
        ft.commit()
    }

}