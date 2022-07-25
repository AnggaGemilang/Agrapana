package com.example.nialonic_gc.ui.fragment

import android.R
import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.example.nialonic_gc.databinding.FragmentAddPlantBinding

class AddPlantFragment : RoundedBottomSheetDialogFragment() {

    private lateinit var binding: FragmentAddPlantBinding
    val REQUEST_CODE = 100

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
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
    }

    private fun openGalleryForImage() {
        val intent = Intent(Intent.ACTION_PICK)
        intent.type = "image/*"
        startActivityForResult(intent, REQUEST_CODE)
    }
}