package com.agrapana.arnesys.viewmodel

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.model.Plant

class PlantViewModel : ViewModel() {

    private val _plants = MutableLiveData<List<Plant>?>()
    val plants: MutableLiveData<List<Plant>?>
        get() = _plants

    private val _plant = MutableLiveData<Plant>()
    val plant: LiveData<Plant>
        get() = _plant

    private val _result = MutableLiveData<Exception?>()

    fun getAllDataPlants() {
    }

    fun getRealtimeUpdates(type: String) {
    }

    fun fetchPlants(type: String) {
    }

    fun updatePlant(plant: Plant) {

    }

    fun deletePlant(plant: Plant) {

    }

    override fun onCleared() {
        super.onCleared()
    }

}