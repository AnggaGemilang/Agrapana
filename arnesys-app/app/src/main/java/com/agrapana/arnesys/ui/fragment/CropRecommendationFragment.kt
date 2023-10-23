package com.agrapana.arnesys.ui.fragment

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import com.agrapana.arnesys.databinding.FragmentSeekCropRecommendationBinding
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialogFragment

class CropRecommendationFragment(private var cropRecommendation: String?, private var cropNow: String?) : RoundedBottomSheetDialogFragment() {

    private lateinit var binding: FragmentSeekCropRecommendationBinding

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentSeekCropRecommendationBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.txtCrop.text = cropRecommendation

        if(cropRecommendation == cropNow) {
            binding.txtCropDetail.text = "Based on the dataset used, the results of AI processing indicate that this land is already suitable for $cropRecommendation"
        } else {
            binding.txtCropDetail.text = "Based on the dataset used, the results of AI processing indicate that this land is suitable for $cropRecommendation With the current land being used for $cropNow, further studies are needed regarding the suitability of this land for the type of crops to be planted"
        }
    }

}