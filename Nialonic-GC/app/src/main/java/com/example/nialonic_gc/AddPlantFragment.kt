package com.example.nialonic_gc

import android.R
import android.content.Intent
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import android.widget.Toast
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialog
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.example.nialonic_gc.databinding.FragmentAddPlantBinding
import com.example.nialonic_gc.databinding.FragmentHomeBinding
import com.google.android.material.bottomsheet.BottomSheetDialogFragment
import com.google.firebase.database.core.Context
import java.util.Arrays.asList

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

        val listItem = arrayOf("Choose Plant Type", "Item 1", "Item 2", "Item 3")
        val adapter = ArrayAdapter(requireContext(), R.layout.simple_spinner_item, listItem)
        binding.type.adapter = adapter

        binding.newConfiguration.setOnCheckedChangeListener { _, isChecked ->
            binding.type.isEnabled = !isChecked
        }

    }

    private fun openGalleryForImage() {
        val intent = Intent(Intent.ACTION_PICK)
        intent.type = "image/*"
        startActivityForResult(intent, REQUEST_CODE)
    }
}