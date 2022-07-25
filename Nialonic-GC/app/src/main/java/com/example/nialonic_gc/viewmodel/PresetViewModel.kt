package com.example.nialonic_gc.viewmodel

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.example.nialonic_gc.model.Preset
import com.google.firebase.database.*

class PresetViewModel : ViewModel() {

    // make database
    private val dbPresets = FirebaseDatabase.getInstance().getReference("presets")

    // create list of author
    private val _presets = MutableLiveData<List<Preset>>()
    val presets: LiveData<List<Preset>>
        get() = _presets

    // create single author
    private val _preset = MutableLiveData<Preset>()
    val preset: LiveData<Preset>
        get() = _preset

    // create result
    private val _result = MutableLiveData<Exception?>()
    val result: LiveData<Exception?>
        get() = _result

    // fungsi untuk menambahkan data ke firebase realtime database
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

    // buat event untuk perubahan data untuk realtime update
    private val childEventListener = object : ChildEventListener {
        override fun onCancelled(error: DatabaseError) { }

        override fun onChildMoved(snapshot: DataSnapshot, p1: String?) { }

        // update data otomatis ketika data di edit
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

        // update data otomatis ketika data ditambahkan
        override fun onChildAdded(snapshot: DataSnapshot, p1: String?) {
            val preset = snapshot.getValue(Preset::class.java)
            preset?.id = snapshot.key.toString()
            _preset.value = preset!!
        }
    }

    // buat fungsi get realtimeupdate
    fun getRealtimeUpdates() {
        dbPresets.addChildEventListener(childEventListener)
    }

    // buat event untuk menampilkan data di firebase dengan metode fetching
    private val valueEventListener = object : ValueEventListener {
        override fun onCancelled(error: DatabaseError) { }

        override fun onDataChange(snapshot: DataSnapshot) {
            if (snapshot.exists()) {
                val presets = mutableListOf<Preset>()
                for (authorSnapshot in snapshot.children) {
                    val preset = authorSnapshot.getValue(Preset::class.java)
                    preset?.id = authorSnapshot.key.toString()
                    preset?.let { presets.add(it) }
                }
                _presets.value = presets
            }
        }
    }

    // fetch author untuk menampilkan data di firebase
    fun fetchPresets() {
        dbPresets.addListenerForSingleValueEvent(valueEventListener)
    }

    // fungsi update
    fun updatePreset(author: Preset) {
        dbPresets.child(author.id).setValue(author).addOnCompleteListener {
            if(it.isSuccessful) {
                _result.value = null
            } else {
                _result.value = it.exception
            }
        }
    }

    // fungsi delete
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