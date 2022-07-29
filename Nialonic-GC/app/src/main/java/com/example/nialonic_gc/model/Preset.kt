package com.example.nialonic_gc.model

import android.os.Parcelable
import kotlinx.parcelize.Parcelize
import java.util.*

@Parcelize
data class Preset(
    var id: String = "",
    var plantName: String = "",
    var category: String = "",
    var nutrition: String = "",
    var growthLamp: String = "",
    var gasValve: String = "",
    var temperature: String = "",
    var pump: String = "",
    var seedlingTime: String = "",
    var growTime: String = "",
    var imageUrl: String = "",

    var isDeleted: Boolean = false
) : Parcelable
