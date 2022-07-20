package com.example.nialonic_gc

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment
import com.example.nialonic_gc.databinding.FragmentAddConfigurationBinding
import com.google.android.material.bottomsheet.BottomSheetBehavior


class AddConfigurationFragment : RoundedBottomSheetDialogFragment() {

    private lateinit var binding: FragmentAddConfigurationBinding

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentAddConfigurationBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.designBottomSheet.layoutParams.height = ViewGroup.LayoutParams.MATCH_PARENT

    }
}