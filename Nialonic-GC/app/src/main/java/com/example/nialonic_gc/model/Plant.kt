package com.example.nialonic_gc.model

import android.os.Parcelable
import kotlinx.parcelize.Parcelize
import java.util.*

@Parcelize
data class Plant(
    var id: String = "",
    var name: String = "",
    var plantStarted: String = "",
    var plantEnded: String = "",
    var category: String = "",
    var mode: String = "",
    var plantType: String = "",
    var status: String = "",
    var imgUrl: String = ""
) : Parcelable
