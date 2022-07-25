package com.example.nialonic_gc.ui.fragment

import android.content.Intent
import android.os.Bundle
import android.util.Log
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


class PresetDataFragment : Fragment(), PresetsAdapter.TaskListener {

    private lateinit var binding: FragmentPresetDataBinding
    private lateinit var viewModel: PresetViewModel
    private val adapter = PresetsAdapter(this)

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        viewModel = ViewModelProviders.of(this)[PresetViewModel::class.java]
        binding = FragmentPresetDataBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.recyclerView.adapter = adapter
        viewModel.fetchPresets()
        viewModel.getRealtimeUpdates()

        viewModel.presets.observe(viewLifecycleOwner, Observer {
            Log.d("dadang", it.size.toString())
            if(it.isNotEmpty()){
                binding.progressBar.visibility = View.GONE
                binding.mainContent.visibility = View.VISIBLE
                binding.size.text = "Data ditampilkan - " + it.size.toString()
                adapter.setPresets(it)
            } else {
                binding.progressBar.visibility = View.GONE
                binding.notFound.visibility = View.VISIBLE
            }
        })

        viewModel.preset.observe(viewLifecycleOwner, Observer {
            adapter.addPreset(it)
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
                    activity?.let { it1 -> AddConfigurationFragment().show(it1.supportFragmentManager, "BottomSheetDialog") }
                }
                R.id.act_delete -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("This can be deleted permamently")
                    builder.setPositiveButton("YES") { _, _ ->
                        viewModel.deletePreset(preset)
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