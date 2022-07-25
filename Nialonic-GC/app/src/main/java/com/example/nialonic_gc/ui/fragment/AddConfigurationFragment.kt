package com.example.nialonic_gc.ui.fragment

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.lifecycle.ViewModelProviders
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.example.nialonic_gc.databinding.FragmentAddConfigurationBinding
import com.example.nialonic_gc.model.Preset
import com.example.nialonic_gc.viewmodel.PresetViewModel
import com.google.android.material.bottomsheet.BottomSheetBehavior


class AddConfigurationFragment : RoundedBottomSheetDialogFragment() {

    private lateinit var viewModel: PresetViewModel
    private lateinit var binding: FragmentAddConfigurationBinding

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        viewModel = ViewModelProviders.of(this)[PresetViewModel::class.java]
        binding = FragmentAddConfigurationBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        
        binding.nutritionManuallyChk.setOnCheckedChangeListener { _, isChecked ->
            binding.nutrition.isEnabled = !isChecked
            if(isChecked){
                binding.nutritionManually.visibility = View.VISIBLE
            } else {
                binding.nutritionManually.visibility = View.GONE
            }
        }

        // on click
        binding.btnSubmit.setOnClickListener {
            val name = binding.plantName.text.toString().trim()
            val category = binding.category.selectedItem.toString()
            val nutrition = if(binding.nutritionManuallyChk.isChecked){
                binding.nutritionManually.text.toString().trim()
            } else {
                binding.nutrition.selectedItem.toString()
            }
            val growthLamp = binding.growthLamp.selectedItem.toString()
            val gasValve = binding.gasValve.selectedItem.toString()
            val temperature = binding.temperature.text.toString().trim()
            val pump = binding.pump.selectedItem.toString()
            val seedlingTime = binding.seedling.text.toString().trim()
            val growTime = binding.grow.text.toString().trim()

            val preset = Preset()
            preset.plantName = name
            preset.category = category
            preset.nutrition = nutrition
            preset.growthLamp = growthLamp
            preset.gasValve = gasValve
            preset.temperature = temperature
            preset.pump = pump
            preset.seedlingTime = seedlingTime
            preset.growTime = growTime

            viewModel.addPreset(preset)
            dismiss()
            Toast.makeText(requireContext(), "Preset has added successfully", Toast.LENGTH_SHORT).show()
        }

    }

    override fun onStart() {
        super.onStart()
        val behavior = BottomSheetBehavior.from(requireView().parent as View)
        behavior.state = BottomSheetBehavior.STATE_EXPANDED
    }

}