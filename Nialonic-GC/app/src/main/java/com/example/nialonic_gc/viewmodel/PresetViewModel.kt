package com.example.nialonic_gc.viewmodel

import android.util.Log
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.example.nialonic_gc.model.Preset
import com.google.firebase.database.*

class PresetViewModel : ViewModel() {

    private val dbPresets = FirebaseDatabase.getInstance().getReference("presets")

    private val _presets = MutableLiveData<List<Preset>?>()
    val presets: MutableLiveData<List<Preset>?>
        get() = _presets

    private val _preset = MutableLiveData<Preset>()
    val preset: LiveData<Preset>
        get() = _preset

    private val _result = MutableLiveData<Exception?>()

    fun addPreset(preset: Preset) {
        preset.id = dbPresets.push().key.toString()
        dbPresets.child(preset.id).setValue(preset).addOnCompleteListener {
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
            val preset = snapshot.getValue(Preset::class.java)
            preset?.id = snapshot.key.toString()
            _preset.value = preset!!
        }

        override fun onChildRemoved(snapshot: DataSnapshot) {
            val preset = snapshot.getValue(Preset::class.java)
            preset?.id = snapshot.key.toString()
            _preset.value = preset!!
        }

        override fun onChildAdded(snapshot: DataSnapshot, p1: String?) {
            val preset = snapshot.getValue(Preset::class.java)
            preset?.id = snapshot.key.toString()
            _preset.value = preset!!
        }
    }

    fun getRealtimeUpdates(type: String) {
        dbPresets.orderByChild("category").equalTo(type).addChildEventListener(childEventListener)
    }

    private val valueEventListener = object : ValueEventListener {
        override fun onCancelled(error: DatabaseError) { }

        override fun onDataChange(snapshot: DataSnapshot) {
            val presets = mutableListOf<Preset>()
            if (snapshot.exists()) {
                for (dataSnapshot in snapshot.children) {
                    val preset = dataSnapshot.getValue(Preset::class.java)
                    preset?.id = dataSnapshot.key.toString()
                    preset?.let { presets.add(it) }
                }
                _presets.value = presets
            } else {
                _presets.value = presets
            }
        }
    }

    fun fetchPresets(type: String) {
        dbPresets.orderByChild("category").equalTo(type).addListenerForSingleValueEvent(valueEventListener)
    }

    fun updatePreset(author: Preset) {
        dbPresets.child(author.id).setValue(author).addOnCompleteListener {
            if(it.isSuccessful) {
                _result.value = null
            } else {
                _result.value = it.exception
            }
        }
    }

    fun deletePreset(preset: Preset) {
        dbPresets.child(preset.id).setValue(null).addOnCompleteListener {
            if(it.isSuccessful) {
                _result.value = null
            } else {
                _result.value = it.exception
            }
        }
    }

    override fun onCleared() {
        super.onCleared()
        dbPresets.removeEventListener(childEventListener)
    }

}