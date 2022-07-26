package com.example.nialonic_gc.ui.fragment

import android.R
import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import android.widget.Toast
import androidx.lifecycle.ViewModelProviders
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.example.nialonic_gc.databinding.FragmentAddPlantBinding
import com.example.nialonic_gc.model.Preset
import com.example.nialonic_gc.viewmodel.PlantViewModel
import com.example.nialonic_gc.viewmodel.PresetViewModel

class AddPlantFragment : RoundedBottomSheetDialogFragment() {

    private lateinit var viewModelPreset: PresetViewModel
    private lateinit var viewModelPlant: PlantViewModel

    private lateinit var binding: FragmentAddPlantBinding
    private var linkImage: Uri? = null
    private val GALLERY_REQUEST_CODE = 888

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        viewModelPreset = ViewModelProviders.of(this)[PresetViewModel::class.java]
        viewModelPlant = ViewModelProviders.of(this)[PlantViewModel::class.java]
        binding = FragmentAddPlantBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        binding.designBottomSheet.layoutParams.height = ViewGroup.LayoutParams.MATCH_PARENT
        val listItem = arrayOf("Choose Plant Type", "Item 1", "Item 2", "Item 3")
        val adapter = ArrayAdapter(requireContext(), R.layout.simple_spinner_item, listItem)
        binding.type.adapter = adapter

        binding.automatic.setOnCheckedChangeListener { _, isChecked ->
            binding.type.isEnabled = !isChecked
        }

        binding.nutritionManuallyChk.setOnCheckedChangeListener { _, isChecked ->
            binding.nutrition.isEnabled = !isChecked
            if(isChecked){
                binding.nutritionManually.visibility = View.VISIBLE
            } else {
                binding.nutritionManually.visibility = View.GONE
            }
        }
        binding.newConfiguration.setOnCheckedChangeListener { _, isChecked ->
            binding.type.isEnabled = !isChecked
            if(isChecked){
                binding.titleCategory.visibility = View.VISIBLE
                binding.category.visibility = View.VISIBLE
                binding.titlePlantName.visibility = View.VISIBLE
                binding.plantName.visibility = View.VISIBLE
                binding.titleNutrition.visibility = View.VISIBLE
                binding.nutrition.visibility = View.VISIBLE
                binding.nutritionManuallyChk.visibility = View.VISIBLE
                binding.titleDefaultImage.visibility = View.VISIBLE
                binding.defaultImage.visibility = View.VISIBLE
                binding.configurationItem1.visibility = View.VISIBLE
                binding.configurationItem2.visibility = View.VISIBLE
                binding.configurationItem3.visibility = View.VISIBLE
            } else {
                binding.titleCategory.visibility = View.GONE
                binding.category.visibility = View.GONE
                binding.titlePlantName.visibility = View.GONE
                binding.plantName.visibility = View.GONE
                binding.titleNutrition.visibility = View.GONE
                binding.nutrition.visibility = View.GONE
                binding.nutritionManuallyChk.visibility = View.GONE
                binding.titleDefaultImage.visibility = View.GONE
                binding.defaultImage.visibility = View.GONE
                binding.configurationItem1.visibility = View.GONE
                binding.configurationItem2.visibility = View.GONE
                binding.configurationItem3.visibility = View.GONE
            }
        }

        binding.open.setOnClickListener {
            selectImageFromGallery()
        }

        binding.btnSubmit.setOnClickListener {
            if(binding.newConfiguration.isChecked){
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
                viewModelPreset.addPreset(preset)
            } else {

            }
            dismiss()
            Toast.makeText(requireContext(), "Plant has added successfully", Toast.LENGTH_SHORT).show()
        }
    }

    override fun onActivityResult(
        requestCode: Int,
        resultCode: Int,
        data: Intent?
    ) {
        super.onActivityResult(
            requestCode,
            resultCode,
            data
        )
        if (requestCode == GALLERY_REQUEST_CODE
            && resultCode == Activity.RESULT_OK
            && data != null
            && data.data != null
        ) {
            val fileURL = data.data
            val urlFile = data.data!!.path.toString()
            binding.txtFilename.text = if(urlFile.length > 21) urlFile.substring(0, 20) + "..." else urlFile
            linkImage = fileURL!!
        }
    }

    private fun selectImageFromGallery() {
        val intent = Intent()
        intent.type = "image/*"
        intent.action = Intent.ACTION_GET_CONTENT
        startActivityForResult(
            Intent.createChooser(
                intent,
                "Please select..."
            ),
            GALLERY_REQUEST_CODE
        )
    }
}