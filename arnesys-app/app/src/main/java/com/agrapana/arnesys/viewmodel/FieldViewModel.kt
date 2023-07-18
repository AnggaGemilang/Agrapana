package com.agrapana.arnesys.viewmodel

import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import com.agrapana.arnesys.model.FieldList

class FieldViewModel: ViewModel() {

    var recyclerListData: MutableLiveData<FieldList> = MutableLiveData()

    fun getUserListObserverable() : MutableLiveData<FieldList> {
        return recyclerListData
    }

    fun getUsersList() {


    }

    fun searchUser(searchText: String) {

    }

}