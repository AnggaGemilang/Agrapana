package com.example.nialonic_gc.model

import android.os.Parcelable
import kotlinx.parcelize.Parcelize
import java.util.*

@Parcelize
data class Plant(
    var id: String = "",
    var category: String = "",
    var mode: String = "",
    var plantType: String = ""
) : Parcelable
