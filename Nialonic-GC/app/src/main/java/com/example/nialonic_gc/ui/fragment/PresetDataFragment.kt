package com.example.nialonic_gc.ui.fragment

import android.os.Bundle
import android.view.*
import android.widget.PopupMenu
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.Fragment
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProviders
import com.example.nialonic_gc.R
import com.example.nialonic_gc.adapter.PresetsAdapter
import com.example.nialonic_gc.databinding.FragmentPresetDataBinding
import com.example.nialonic_gc.model.Preset
import com.example.nialonic_gc.viewmodel.PresetViewModel

class PresetDataFragment(type: String) : Fragment(), PresetsAdapter.TaskListener {

    private lateinit var binding: FragmentPresetDataBinding
    private lateinit var viewModel: PresetViewModel
    private val adapter = PresetsAdapter(this)
    private val type = type

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentPresetDataBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        initViewModel()
        viewModel.fetchPresets(type)
        viewModel.getRealtimeUpdates(type)
        binding.recyclerView.adapter = adapter
    }

    private fun initViewModel() {
        var total: Int = 0
        viewModel = ViewModelProviders.of(this)[PresetViewModel::class.java]
        viewModel.presets.observe(viewLifecycleOwner, Observer {
            if(it!!.isNotEmpty()){
                binding.progressBar.visibility = View.GONE
                binding.mainContent.visibility = View.VISIBLE
                total = it.size
                binding.size.text = "Data ditampilkan - " + it.size.toString()
                adapter.setPresets(it)
            } else {
                binding.progressBar.visibility = View.GONE
                binding.notFound.visibility = View.VISIBLE
            }
        })

        viewModel.preset.observe(viewLifecycleOwner, Observer {
            if(it != null){
                total++
                adapter.addPreset(it)
                binding.size.text = "Data ditampilkan - " + total++.toString()
            }
        })
    }

    override fun onOptionClick(view: View, preset: Preset) {
        val contextThemeWrapper = ContextThemeWrapper(context, R.style.MyPopupMenu)
        val popupMenu = PopupMenu(contextThemeWrapper, view, Gravity.END)
        popupMenu.menuInflater.inflate(R.menu.item_popup_action, popupMenu.menu)
        popupMenu.show()
        popupMenu.setOnMenuItemClickListener { menuItem ->
            when (menuItem.itemId) {
                R.id.act_edit -> {
                    val dialog = AddConfigurationFragment()
                    val bundle = Bundle()
                    bundle.putString("status", "update")
                    bundle.putString("id", preset.id)
                    bundle.putString("plantName", preset.plantName)
                    bundle.putString("category", preset.category)
                    bundle.putString("imageUrl", preset.imageUrl)
                    bundle.putString("nutrition", preset.nutrition)
                    bundle.putString("growthLamp", preset.growthLamp)
                    bundle.putString("gasValve", preset.gasValve)
                    bundle.putString("temperature", preset.temperature)
                    bundle.putString("pump", preset.pump)
                    bundle.putString("seedlingTime", preset.seedlingTime)
                    bundle.putString("growTime", preset.growTime)
                    dialog.arguments = bundle
                    activity?.let { it1 -> dialog.show(it1.supportFragmentManager, "BottomSheetDialog") }
                }
                R.id.act_delete -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("This can be deleted permamently")
                    builder.setPositiveButton("YES") { _, _ ->
                        viewModel.deletePreset(preset)
                        initViewModel()
                        viewModel.fetchPresets(type)
                        viewModel.getRealtimeUpdates(type)
                    }
                    builder.setNegativeButton("NO") { dialog, _ ->
                        dialog.dismiss()
                    }
                    val alert = builder.create()
                    alert.show()
                }
            }
            false
        }
    }
}