package com.agrapana.arnesys.model

data class FieldList(val data: List<User>)
data class Field(val id: String?,val name: String?,  val email: String?, val status: String?, val gender: String?)
data class FieldResponse(val code: Int?, val meta: String?, val data: User?)