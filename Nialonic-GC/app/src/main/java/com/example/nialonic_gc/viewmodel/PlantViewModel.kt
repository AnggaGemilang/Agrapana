package com.example.nialonic_gc.viewmodel

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.example.nialonic_gc.model.Plant
import com.example.nialonic_gc.model.Preset
import com.google.firebase.database.*
import com.google.firebase.storage.FirebaseStorage


class PlantViewModel : ViewModel() {

    private val dbPlants = FirebaseDatabase.getInstance().getReference("plants")

    private val _plants = MutableLiveData<List<Preset>?>()
    val presets: MutableLiveData<List<Preset>?>
        get() = _plants

    private val _plant = MutableLiveData<Preset>()
    val preset: LiveData<Preset>
        get() = _plant

    private val _result = MutableLiveData<Exception?>()

    fun addPlant(preset: Preset) {
        preset.id = dbPlants.push().key.toString()
        dbPlants.child(preset.id).setValue(preset).addOnCompleteListener {
            if(it.isSuccessful) {
                _result.value = null
            } else {
                _result.value = it.exception
            }
        }
    }

    private val childEventListener = object : ChildEventListener {
        override fun onCancelled(error: DatabaseError) { }

        override fun onChildMoved(snapshot: DataSnapshot, p1: String?) { }

        override fun onChildChanged(snapshot: DataSnapshot, p1: String?) {
            val plant = snapshot.getValue(Preset::class.java)
            plant?.id = snapshot.key.toString()
            _plant.value = plant!!
        }

        override fun onChildRemoved(snapshot: DataSnapshot) {
            val plant = snapshot.getValue(Preset::class.java)
            plant?.id = snapshot.key.toString()
            _plant.value = plant!!
        }

        override fun onChildAdded(snapshot: DataSnapshot, p1: String?) {
            val plant = snapshot.getValue(Preset::class.java)
            plant?.id = snapshot.key.toString()
            _plant.value = plant!!
        }
    }

    fun getRealtimeUpdates(type: String) {
        dbPlants.orderByChild("category").equalTo(type).addChildEventListener(childEventListener)
    }

    private val valueEventListener = object : ValueEventListener {
        override fun onCancelled(error: DatabaseError) { }

        override fun onDataChange(snapshot: DataSnapshot) {
            val plants = mutableListOf<Preset>()
            if (snapshot.exists()) {
                for (dataSnapshot in snapshot.children) {
                    val preset = dataSnapshot.getValue(Preset::class.java)
                    preset?.id = dataSnapshot.key.toString()
                    preset?.let { plants.add(it) }
                }
                _plants.value = plants
            } else {
                _plants.value = plants
            }
        }
    }

    fun fetchPresets(type: String) {
        dbPlants.orderByChild("category").equalTo(type).addListenerForSingleValueEvent(valueEventListener)
    }

    fun updatePlant(plant: Plant) {
        dbPlants.child(plant.id).setValue(plant).addOnCompleteListener {
            if(it.isSuccessful) {
                _result.value = null
                fetchPresets(plant.category)
            } else {
                _result.value = it.exception
            }
        }
    }

    fun deletePlant(plant: Plant) {
        dbPlants.child(plant.id).setValue(null).addOnCompleteListener { it ->
            if(it.isSuccessful) {

            } else {
                _result.value = it.exception
            }
        }
    }

    override fun onCleared() {
        super.onCleared()
        dbPlants.removeEventListener(childEventListener)
    }

}