package com.example.nialonic_gc

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.Fragment
import androidx.fragment.app.FragmentTransaction
import com.example.nialonic_gc.databinding.FragmentPlantListBinding
import com.google.android.material.tabs.TabLayout

class PlantListFragment : Fragment() {

    private lateinit var binding: FragmentPlantListBinding

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentPlantListBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.toolbar.inflateMenu(R.menu.action_nav1)
        binding.toolbar.setOnMenuItemClickListener {
            when(it.itemId) {
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

        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Microgreen"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Fruits"))
        binding.tabLayout.addTab(binding.tabLayout.newTab().setText("Vegetables"))
        binding.tabLayout.tabGravity = TabLayout.GRAVITY_FILL
        replaceFragment(PlantListDataFragment())

    }

    fun replaceFragment(fragment: Fragment?) {
        val fm = requireActivity().supportFragmentManager
        val ft = fm.beginTransaction()
        ft.replace(R.id.frame_container, fragment!!)
        ft.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN)
        ft.commit()
    }

}