package com.agrapana.arnesys.viewmodel

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.model.Preset

class PresetViewModel : ViewModel() {

    private val _presets = MutableLiveData<List<Preset>?>()
    val presets: MutableLiveData<List<Preset>?>
        get() = _presets

    private val _preset = MutableLiveData<Preset>()
    val preset: LiveData<Preset>
        get() = _preset

    private val _result = MutableLiveData<Exception?>()

    fun getRealtimeUpdates(type: String) {

    }

    fun fetchOnePreset(name: String) {

    }

    fun getAllDataPreset() {
    }

    fun fetchPresets(type: String) {

    }

    fun deletePreset(preset: Preset) {

    }

    override fun onCleared() {
        super.onCleared()
    }

}