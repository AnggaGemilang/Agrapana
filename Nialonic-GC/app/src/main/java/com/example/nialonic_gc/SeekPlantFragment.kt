package com.example.nialonic_gc

import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.example.nialonic_gc.databinding.FragmentHomeBinding
import com.example.nialonic_gc.databinding.FragmentSeekPlantBinding

class SeekPlantFragment : RoundedBottomSheetDialogFragment() {

    private lateinit var binding: FragmentSeekPlantBinding

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentSeekPlantBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.btnDetails.setOnClickListener {
            startActivity(Intent(requireContext(), DetailActivity::class.java))
        }

    }
}