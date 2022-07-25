package com.example.nialonic_gc.ui.fragment

import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.text.Editable
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import android.widget.Toast
import androidx.lifecycle.ViewModelProviders
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.example.nialonic_gc.databinding.FragmentAddConfigurationBinding
import com.example.nialonic_gc.model.Preset
import com.example.nialonic_gc.viewmodel.PresetViewModel
import com.google.android.material.bottomsheet.BottomSheetBehavior
import com.google.firebase.storage.FirebaseStorage
import java.util.*


class AddConfigurationFragment : RoundedBottomSheetDialogFragment() {

    private lateinit var viewModel: PresetViewModel
    private lateinit var binding: FragmentAddConfigurationBinding
    private lateinit var linkImage: Uri
    private val GALLERY_REQUEST_CODE = 999

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
        if(arguments?.getString("status") == "update"){
            binding.title.text = "Edit Configuration"
            binding.btnSubmit.text = "Edit Configuration"
            binding.plantName.text = Editable.Factory.getInstance().newEditable(arguments?.getString("plantName"))
            binding.temperature.text = Editable.Factory.getInstance().newEditable(arguments?.getString("temperature"))
            binding.seedling.text = Editable.Factory.getInstance().newEditable(arguments?.getString("seedlingTime"))
            binding.grow.text = Editable.Factory.getInstance().newEditable(arguments?.getString("growTime"))
            binding.category.setSelection(
                (binding.category.adapter as ArrayAdapter<String>).getPosition(
                    arguments?.getString("category")
                )
            )
            binding.growthLamp.setSelection(
                (binding.growthLamp.adapter as ArrayAdapter<String>).getPosition(
                    arguments?.getString("growthLamp")
                )
            )
            binding.gasValve.setSelection(
                (binding.gasValve.adapter as ArrayAdapter<String>).getPosition(
                    arguments?.getString("gasValve")
                )
            )
            binding.pump.setSelection(
                (binding.pump.adapter as ArrayAdapter<String>).getPosition(
                    arguments?.getString("pump")
                )
            )
            if(arguments?.getString("nutrition") == "+" || arguments?.getString("nutrition") == "-"){
                binding.nutrition.setSelection(
                    (binding.nutrition.adapter as ArrayAdapter<String>).getPosition(
                        arguments?.getString("nutrition")
                    )
                )
            } else {
                binding.nutrition.isEnabled = false
                binding.nutritionManuallyChk.isChecked = true
                binding.nutritionManually.visibility = View.VISIBLE
                binding.nutritionManually.text = Editable.Factory.getInstance().newEditable(arguments?.getString("nutrition"))
            }
        }
        binding.nutritionManuallyChk.setOnCheckedChangeListener { _, isChecked ->
            binding.nutrition.isEnabled = !isChecked
            if(isChecked){
                binding.nutritionManually.visibility = View.VISIBLE
            } else {
                binding.nutritionManually.visibility = View.GONE
            }
        }

        binding.open.setOnClickListener {
            selectImageFromGallery()
        }

        binding.btnSubmit.setOnClickListener {
            if(arguments?.getString("status") == "update") {
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
                preset.id = arguments?.getString("id")!!
                preset.plantName = name
                preset.category = category
                preset.nutrition = nutrition
                preset.growthLamp = growthLamp
                preset.gasValve = gasValve
                preset.temperature = temperature
                preset.pump = pump
                preset.seedlingTime = seedlingTime
                preset.growTime = growTime
                viewModel.updatePreset(preset)
            } else {
                val fileName = UUID.randomUUID().toString() +".png"
                val refStorage = FirebaseStorage.getInstance().reference.child("thumbnail_preset/$fileName")
                refStorage.putFile(linkImage)
                    .addOnSuccessListener { taskSnapshot ->
                        taskSnapshot.storage.downloadUrl.addOnSuccessListener {
                            val imageUrl = it.toString()
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
                            preset.imageUrl = imageUrl

                            viewModel.addPreset(preset)
                        }
                    }
                    .addOnFailureListener { e ->
                        Log.d("gagal", e.message.toString())
                    }
            }
            dismiss()
            if(arguments?.getString("status") == "update"){
                Toast.makeText(requireContext(), "Preset has updated successfully", Toast.LENGTH_SHORT).show()
            } else {
                Toast.makeText(requireContext(), "Preset has added successfully", Toast.LENGTH_SHORT).show()
            }
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

    override fun onStart() {
        super.onStart()
        val behavior = BottomSheetBehavior.from(requireView().parent as View)
        behavior.state = BottomSheetBehavior.STATE_EXPANDED
    }

}